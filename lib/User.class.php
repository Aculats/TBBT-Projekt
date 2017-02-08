<?php
/**
 * Created by PhpStorm.
 * User: Luca, Omer, Jan, Tobias M.
 * Date: 08.02.2017
 * Time: 10:24
 */

namespace lib;


class User
{
    public $id;
    public $username;
    public $password;

    public function __construct( $post = '' ) {
        if ( isset( $post ) ) {
            if ( $user = self::load( $post ) ) {
                return $user;
            } else {
                return $this->create( $post );
            }
        } else {
            $this->id = '';
            $this->username = '';
            $this->password = '';

            return $this;
        }
    }

    public function create( $post ) {
        global $pdo;

        $this->username = !empty( $post['username'] ) ? trim( $post['username'] ) : null;
        $this->password = !empty( $post['password'] ) ? trim( $post['password'] ) : null;

        // Construct the SQL statement and prepare it.
        $sql = "SELECT COUNT(username) AS num FROM users WHERE username = :username";
        $stmt = $pdo->prepare( $sql );

        // Bind the provided username to our prepared statement.
        $stmt->bindValue( ':username', $this->username );
        $stmt->execute();

        // Fetch the row.
        $row = $stmt->fetch( PDO::FETCH_ASSOC );

        if ( $row['num'] > 0 ) {
            die( 'Der Benutzername existiert bereits.' );
        }

        // Hash the password as we do NOT want to store our passwords in plain text.
        $passwordHash = password_hash( $this->password, PASSWORD_BCRYPT, [ 'cost' => 12 ] );

        // Prepare our INSERT statement.
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $pdo->prepare( $sql );
        $stmt->bindValue( ':username', $this->username );
        $stmt->bindValue( ':password', $passwordHash );
        $result = $stmt->execute();

        // If the signup progress is successful.
        if ( $result ) {
            $this->login();
            return true;
        }

        return false;
    }

    public function loadById( $id ) {
        global $pdo;

        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $pdo->prepare( $sql );
        $stmt->bindValue( ':id', $id );
        $result = $stmt->execute();

        if ( $result ) {
            var_dump( $result );
            $this->login();
            return true;
        } else {
            var_dump( 'false' );
            return false;
        }
    }

    public function login() {
        global $pdo;

        // Retrieve the user account information for the given username.
        $sql = "SELECT id, username, password FROM users WHERE id = :id";
        $stmt = $pdo->prepare( $sql );

        // Bind value.
        $stmt->bindValue( ':id', $this->id );
        $stmt->execute();

        // Fetch row.
        $user = $stmt->fetch( PDO::FETCH_ASSOC );

        // If $row is false.
        if ( $user === false ) {
            die( 'Der Benutzername oder das Passwort ist nicht korrekt.' );
        } else {
            // Compare the passwords.
            $validPassword = password_verify( $this->password, $user['password'] );

            // If $validPassword is true, the login has been successful.
            if ( $validPassword ) {

                // Provide the user with a login session.
                $_SESSION['userId'] = $user['id'];
                $_SESSION['loggedIn'] = time();
            } else {
                die( 'Der Benutzername oder das Passwort ist nicht korrekt.' );
            }
        }

        goToHome();
    }

    public static function load( $post ) {
        global $pdo;

        // Hash the password as we do NOT want to store our passwords in plain text.
        $passwordHash = password_hash( $post['password'], PASSWORD_BCRYPT, [ 'cost' => 12 ] );
        $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
        $stmt = $pdo->prepare( $sql );
        $stmt->bindValue( ':username', $post['username'] );
        $stmt->bindValue( ':password', $passwordHash );
        $result = $stmt->execute();

        if ( $result ) {
            var_dump( $result );
            User::login();
            return true;
        } else {
            var_dump( 'false' );
            return false;
        }
    }
}