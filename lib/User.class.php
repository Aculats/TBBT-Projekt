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
     * User constructor.
     * @param string $post
     */
    public function __construct( $post = '' ) {
        var_dump( '__construct' );

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
            $this->id = '';
            $this->username = '';
            $this->password = '';

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

    /**
     * @param $post
     * @return $this|bool
     */
    public function create( $post ) {
        var_dump( 'create' );
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
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $pdo->prepare( $sql );
        $stmt->bindValue( ':username', $this->username );
        $stmt->bindValue( ':password', $password );

        // If the signup progress is successful.
        if ( $stmt->execute() ) {
            $this->setPasswordHash();
            $this->setId( $pdo->lastInsertId() );
            return $this;
        }

        return false;
    }

    /**
     * @param $id
     * @return $this|bool
     */
    public function loadById( $id ) {
        var_dump( 'loadById' );
        global $pdo;

        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $pdo->prepare( $sql );
        $stmt->bindValue( ':id', $id );
        $stmt->execute();

        if ( $result = $stmt->fetch( \PDO::FETCH_ASSOC ) ) {
            $this->setId( $result['id'] );
            $this->setUsername( $result['username'] );
            $this->setPassword( $result['password'] );
            return $this;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function login() {
        var_dump( 'login' );

        if ( empty( $this->id ) ) {
            return false;
        }

        $_SESSION['userId'] = $this->id;

        return true;
    }

    /**
     * @return bool
     */
    public function logout() {
        var_dump( 'logout' );

        if ( isset( $_SESSION['userId'] ) && $_SESSION['userId'] == $this->id ) {
            unset( $_SESSION['userId'] );
            return true;
        }

        return false;
    }

    /**
     * @param $post
     * @return bool|User
     */
    public static function sLoad( $post ) {
        var_dump( 'load' );
        global $pdo;

        $sql = "SELECT id, username, password FROM users WHERE username = :username";
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
        var_dump( 'sLoadById' );
        global $pdo;

        $sql = "SELECT id, username, password FROM users WHERE id = :id";
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