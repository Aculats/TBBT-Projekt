<?php
/**
 * @since 1.0.0
 * @author Luca
 * @licence MIT
 */


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