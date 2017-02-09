<?php
/**
 * Created by PhpStorm.
 * User: Luca, Omer, Jan, Tobias M.
 * Date: 08.02.2017
 * Time: 10:24
 */

namespace lib;

/**
 * Class to handle users.
 *
 * Class User.
 *
*@package lib
 */
class User {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $passwordCheck;

    /**
     * @var integer
     */
    private $status;

    /**
     * User constructor.
     *
     * @param array $args (optional)
     *  Array with user arguments.
     */
    public function __construct( $args = [ ] ) {
        if ( !empty( $args ) ) {
            // For each argument, set property with value.
            foreach ( $args as $key => $value ) {
                $this->__set( $key, $value );
            }
        }

        return $this;
    }

    /**
     * Magic function getter to get any property.
     *
     * @param mixed $prop
     *  Property of this class.
     *
     * @return null|mixed
     *  Returns the value of the property.
     */
    public function __get( $prop ) {
        if ( property_exists( $this, $prop ) ) {
            return $this->$prop;
        }

        return null;
    }

    /**
     * Magic function setter to set private properties.
     *
     * @param mixed $prop
     *  Property that should be changed.
     * @param mixed $value
     *  Property value.
     *
     * @return object $this
     *  Returns the current object.
     */
    public function __set( $prop, $value ) {
        if ( property_exists( $this, $prop ) ) {
            $this->$prop = $value;
        }

        return $this;
    }

    /**
     * Get the hashed password.
     *
     * @return bool|string
     *  Returns the hashed password or false on error.
     */
    public function getPasswordHash() {
        if ( strlen( $this->password ) == 60 ) {
            return $this->password;
        }

        return password_hash( $this->password, PASSWORD_BCRYPT, [ 'cost' => 12 ] );
    }

    /**
     * If Password is not hashed, hash it.
     *
     * @param string $password (optional)
     *  The password to hash.
     */
    public function setPasswordHash( $password = '' ) {
        if ( empty( $this->password ) ) {
            $this->password = $password;
        }

        $this->password = password_hash( $this->password, PASSWORD_BCRYPT, [ 'cost' => 12 ] );
    }

    /**
     * Save the user object.
     *
     * @return bool
     *  Returns true on success, false on failure.
     */
    public function save() {
        // If there is no username or password don't save.
        if (
            empty( $this->username )
            || empty( $this->password )
            || $this->password !== $this->passwordCheck
        ) {
            return false;
        }

        // If we have an id, just update the user, else create new.
        if ( !empty( $this->id ) ) {
            $this->update();
        } else {
            $this->create();
        }

        return true;
    }

    /**
     * Create a new user.
     *
     * @return $this|User
     *  Returns the user object.
     */
    private function create() {
        global $pdo;

        // Check if the username is already in use.
        $sql = "SELECT COUNT(username) AS num FROM users WHERE username = :username";
        $stmt = $pdo->prepare( $sql );
        $stmt->bindValue( ':username', $this->username );
        $stmt->execute();
        $row = $stmt->fetch( \PDO::FETCH_ASSOC );

        if ( $row['num'] > 0 ) {
            // ToDo: Add error message
            die( 'Gibt\'s schon' );
        }

        if ( !$this->verifyPass( $this->password, $this->passwordCheck ) ) {
            // ToDo: Add error message
            die( 'nicht das gleiche Passwort' );
        }

        // Get the hashed password so anybody can see it.
        $passwordHash = $this->getPasswordHash();

        // Save the user.
        $sql = "INSERT INTO users (username, password, status) VALUES (:username, :password, :status)";
        $stmt = $pdo->prepare( $sql );
        $stmt->bindValue( 'username', $this->username );
        $stmt->bindValue( 'password', $passwordHash );
        $stmt->bindValue( 'status', !empty( $this->status ) ? $this->status : 1 );

        // If there are no SQL errors...
        if ( $stmt->execute() ) {
            // ... set password to hashed;
            $this->setPasswordHash();
            // ... set id;
            $this->id = $pdo->lastInsertId();
            // ... set status to logged in;
            $this->status = !empty( $this->status ) ? $this->status : 1;
            // ... return the created user.
            return $this;
        }

        // ... else return a user object with the given properties.
        return new User( $this );
    }

    /**
     * Update a given user.
     *
     * @return $this|User
     *  Returns the user object.
     */
    private function update() {
        global $pdo;

        // Add all given parameters to the update statement.
        $sql = "UPDATE users SET ";

        $i = 0;
        foreach ( $this as $key => $value ) {
            if ( $key != 'id' ) {
                $sql .= $key . " = :" . $key;
                $i++;

                if ( count( (array)$this ) > $i ) {
                    $sql .= ", ";
                }
            }
        }
        $sql .= " WHERE id = :id";
        $stmt = $pdo->prepare( $sql );

        foreach ( $this as $key => $value ) {
            $stmt->bindValue( $key, $value );
        }

        // If there are no SQL errors...
        if ( $stmt->execute() ) {
            // ... return the updated user.
            return $this;
        }

        // ... else return a user object with the given properties.
        return new User( $this );
    }

    /**
     * Load a given user.
     *
     * @param integer|string $args
     *  Identifier or username of the user to load.
     *
     * @return bool|User
     *  Returns the given user or false on error.
     */
    public static function load( $args ) {
        // Get the type to know if it's the id or username.
        switch ( gettype( $args ) ) {
            case 'integer':
                $user = self::loadById( $args );
                break;
            case 'string':
                $user = self::loadByUsername( $args );
                break;
            default:
                $user = new User();
        }

        return $user;
    }

    /**
     * Load a given user by identifier.
     *
     * @param integer $id
     *  The identifier of a user.
     *
     * @return bool|User
     *  Returns the user object or false on error.
     */
    private static function loadById( $id ) {
        global $pdo;

        // Get all of the information from user.
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $pdo->prepare( $sql );
        $stmt->bindValue( ':id', $id );

        // If there are no SQL errors...
        if ( $result = $stmt->execute() ) {
            $data = $stmt->fetch( \PDO::FETCH_ASSOC );
            // ... return a user object with data from database.
            return new User( $data );
        }

        // ... else return false.
        return false;
    }

    /**
     * Load a given user by username.
     *
     * @param string $username
     *  Username of a user.
     *
     * @return bool|User
     *  Returns the user object or false on error.
     */
    private static function loadByUsername( $username ) {
        global $pdo;

        // Get all of the information from user.
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare( $sql );
        $stmt->bindValue( ':username', $username );

        // If there are no SQL errors...
        if ( $stmt->execute() ) {
            $data = $stmt->fetch( \PDO::FETCH_ASSOC );
            // ... return a user object with data from database.
            return new User( $data );
        }

        // ... else return false.
        return false;
    }

    /**
     * Deletes a given user.
     *
     * @return bool
     *  Returns true on success, false on failure.
     */
    public function delete() {
        global $pdo;

        // Remove all the data of this user,
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $pdo->prepare( $sql );
        $stmt->bindValue( ':id', $this->id );

        return $stmt->execute();
    }

    /**
     * Check the password.
     *
     * @param string $passwordIn
     *  Password, that the user typed in.
     * @param string $realPassword
     *  Second password on registration or hashed from the database.
     * @param bool $hashed (optional)
     *  Set true when $realPassword is hashed.
     *
     * @return bool
     *  Returns the result of the checked passwords.
     */
    public function verifyPass( $passwordIn, $realPassword, $hashed = false ) {
        if ( $hashed ) {
            return password_verify( $passwordIn, $realPassword );
        }

        return $passwordIn == $realPassword ? true : false;
    }

    /**
     * Log in this user.
     *
     * @return bool
     *  Returns true on success, false on failure.
     */
    public function login() {
        global $pdo;

        $tempUser = self::loadByUsername( $this->username );
        if ( $this->verifyPass( $this->password, $tempUser->password, true ) ) {
            // If we actually have a user, set status to logged in and save it in database.
            if ( !empty( $tempUser->id ) ) {
                $sql = "UPDATE users SET status = :status WHERE id = :id";
                $stmt = $pdo->prepare( $sql );
                $stmt->bindValue( ':status', 1 );
                $stmt->bindValue( ':id', $tempUser->id );

                if ( $stmt->execute() ) {
                    // Add the user id to our session.
                    $_SESSION['userId'] = $tempUser->id;
                    $tempUser->status = 1;

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Logout this user.
     *
     * @return bool
     *  Returns true on success, false on failure.
     */
    public function logout() {
        global $pdo;

        // If there is a user id in our session and it is the id of the current user logout.
        if ( isset( $_SESSION['userId'] ) && $_SESSION['userId'] == $this->id ) {
            $sql = "UPDATE users SET status = :status WHERE id = :id";
            $stmt = $pdo->prepare( $sql );
            $stmt->bindValue( ':status', 0 );
            $stmt->bindValue( ':id', $this->id );

            if ( $stmt->execute() ) {
                $this->status = 0;
                // Remove the user id from our session.
                unset( $_SESSION['userId'] );

                return true;
            }
        }

        return false;
    }
}