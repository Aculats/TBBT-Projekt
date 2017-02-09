<?php
/**
 * Created by PhpStorm.
 * User: Luca, Omer, Jan, Tobias M.
 * Date: 08.02.2017
 * Time: 10:24
 */

namespace lib;

/**
 * Class User
 * @package lib
 */
class User
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $password;

    /**
     * @var integer
     */
    public $status;

    /**
     * User constructor.
     * @param string $post
     */
    public function __construct( $post = '' ) {
        if ( isset( $post ) ) {
            $loadById = isset( $post['id'] ) ? $this->loadById( $post['id'] ) : false;
            $load = self::sLoad( $post ) ? self::sLoad( $post ) : false;

            switch ( true ) {
                case $loadById:
                    return $loadById;
                case $load:
                    return $load;
                default:
                    return $this->create( $post );
            }
        } else {
            $this->id = 0;
            $this->username = '';
            $this->password = '';
            $this->status = 1;

            return $this;
        }
    }

    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param $id
     */
    private function setId( $id ) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @param $username
     */
    private function setUsername( $username ) {
        $this->username = $username;
    }

    /**
     * @return bool|string
     */
    public function getPasswordHash() {
        if ( strlen( $this->password ) == 60 ) {
            return $this->password;
        }

        return password_hash( $this->password, PASSWORD_BCRYPT, [ 'cost' => 12 ] );
    }

    /**
     * @param string $password
     */
    private function setPasswordHash( $password = '' ) {
        if ( empty( $this->password ) ) {
            $this->password = $password;
        }

        $this->password = password_hash( $this->password, PASSWORD_BCRYPT, [ 'cost' => 12 ] );
    }

    /**
     * @param $password
     */
    private function setPassword( $password ) {
        $this->password = $password;
    }

    public function getStatus() {
        return $this->status;
    }

    private function setStatus( $status ) {
        $this->status = $status;
    }

    /**
     * @param $post
     * @return $this|bool
     */
    public function create( $post ) {
        global $pdo;

        $this->setUsername( trim( $post['username'] ) );
        $this->setPassword( trim( $post['password'] ) );

        // Construct the SQL statement and prepare it.
        $sql = "SELECT COUNT(username) AS num FROM users WHERE username = :username";
        $stmt = $pdo->prepare( $sql );

        // Bind the provided username to our prepared statement.
        $stmt->bindValue( ':username', $this->getUsername() );
        $stmt->execute();

        // Fetch the row.
        $row = $stmt->fetch( \PDO::FETCH_ASSOC );

        if ( $row['num'] > 0 ) {
            die( 'Der Benutzername existiert bereits.' );
        }

        // Hash the password as we do NOT want to store our passwords in plain text.
        $password = $this->getPasswordHash();

        // Prepare our INSERT statement.
        $sql = "INSERT INTO users (username, password, status) VALUES (:username, :password, :status)";
        $stmt = $pdo->prepare( $sql );
        $stmt->bindValue( ':username', $this->username );
        $stmt->bindValue( ':password', $password );
        $stmt->bindValue( ':status', 1 );

        // If the signup progress is successful.
        if ( $stmt->execute() ) {
            $this->setPasswordHash();
            $this->setId( $pdo->lastInsertId() );
            $this->setStatus( 1 );
            return $this;
        }

        return new User();
    }

    /**
     * @param $id
     * @return $this|bool
     */
    public function loadById( $id ) {
        global $pdo;

        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $pdo->prepare( $sql );
        $stmt->bindValue( ':id', $id );
        $stmt->execute();

        if ( $result = $stmt->fetch( \PDO::FETCH_ASSOC ) ) {
            $this->setId( $result['id'] );
            $this->setUsername( $result['username'] );
            $this->setPassword( $result['password'] );
            $this->setStatus( $result['status'] );
            return $this;
        } else {
            return new User();
        }
    }

    /**
     * @return bool
     */
    public function login() {
        global $pdo;

        if ( !empty( $this->id ) && $this->id != 0 ) {
            $sql = "UPDATE users SET status = :status WHERE id = :id";
            $stmt = $pdo->prepare( $sql );
            $stmt->bindValue( ':status', 1 );
            $stmt->bindValue( ':id', $this->id );
            if ( $stmt->execute() ) {
                $_SESSION['userId'] = $this->id;
                $this->setStatus( 1 );
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function logout() {
        global $pdo;

        if ( isset( $_SESSION['userId'] ) && $_SESSION['userId'] == $this->id ) {
            $sql = "UPDATE users SET status = :status WHERE id = :id";
            $stmt = $pdo->prepare( $sql );
            $stmt->bindValue( ':status', 0 );
            $stmt->bindValue( ':id', $this->id );

            if ( $stmt->execute() ) {
                $this->setStatus( 0 );
                unset( $_SESSION['userId'] );
                return true;
            }
        }

        return false;
    }

    /**
     * @param $post
     * @return bool|User
     */
    public static function sLoad( $post ) {
        global $pdo;

        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare( $sql );
        $stmt->bindValue( ':username', $post['username'] );
        $stmt->execute();

        $result = $stmt->fetch( \PDO::FETCH_ASSOC );
        $passValid = password_verify( $post['password'], $result['password'] );

        if ( $result && $passValid ) {
            return new User( $result );
        } else {
            return false;
        }
    }

    /**
     * @param $id
     * @return bool|User
     */
    public static function sLoadById( $id ) {
        global $pdo;

        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $pdo->prepare( $sql );
        $stmt->bindValue( ':id', $id );
        $stmt->execute();

        if ( $result = $stmt->fetch( \PDO::FETCH_ASSOC ) ) {
            return new User( $result );
        } else {
            return false;
        }
    }
}