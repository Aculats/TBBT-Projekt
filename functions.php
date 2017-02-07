<?php
/**
 * @since 1.0.0
 * @author Luca
 * @licence MIT
 */

/**
 * @param $post
 * @return bool|string
 */
function register( $post ) {
    global $pdo;

    // Retrieve the field values from our registration form.
    $username = !empty( $post['username'] ) ? trim( $post['username'] ) : null;
    $password = !empty( $post['password'] ) ? trim( $post['password'] ) : null;

    // ToDo: Add error checking.

    // Construct the SQL statement and prepare it.
    $sql = "SELECT COUNT(username) AS num FROM users WHERE username = :username";
    $stmt = $pdo->prepare( $sql );

    // Bind the provided username to our prepared statement.
    $stmt->bindValue( ':username', $username );
    $stmt->execute();

    // Fetch the row.
    $row = $stmt->fetch( PDO::FETCH_ASSOC );

    if ( $row['num'] > 0 ) {
        die( 'Der Benutzername existiert bereits.' );
    }

    // Hash the password as we do NOT want to store our passwords in plain text.
    $passwordHash = password_hash( $password, PASSWORD_BCRYPT, ['cost' => 12] );

    // Prepare our INSERT statement.
    $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
    $stmt = $pdo->prepare( $sql );
    $stmt->bindValue( ':username', $username );
    $stmt->bindValue( ':password', $passwordHash );
    $result = $stmt->execute();

    // If the signup progress is successful.
    if ( $result ) {
        echo 'Vielen Dank, dass Sie sich für ' . WEB_NAME . ' registriert haben.';
        goToHome();
    }

    return false;
}

/**
 * @param $post
 */
function login( $post ) {
    global $pdo;

    // Retrieve the field values from our login form.
    $username = !empty( $post['username'] ) ? trim( $post['username'] ) : null;
    $passwordAttempt = !empty( $post['password'] ) ? trim( $post['password'] ) : null;

    // Retrieve the user account information for the given username.
    $sql = "SELECT id, username, password FROM users WHERE username = :username";
    $stmt = $pdo->prepare( $sql );

    // Bind value.
    $stmt->bindValue( ':username', $username );
    $stmt->execute();

    // Fetch row.
    $user = $stmt->fetch( PDO::FETCH_ASSOC );

    // If $row is false.
    if ( $user === false ) {
        die( 'Der Benutzername oder das Passwort ist nicht korrekt.' );
    } else {
        // Compare the passwords.
        $validPassword = password_verify( $passwordAttempt, $user['password'] );

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

function logout() {
    unset( $_SESSION['userId'] );
    unset( $_SESSION['loggedIn'] );
    goToHome();
}

function loggedIn() {
    if ( !isset( $_SESSION['userId'] ) || !isset( $_SESSION['loggedIn'] ) ) {
        return false;
    }

    return true;
}

function goToHome() {
    header( 'Location: ' . WEB_DIR );
}