<?php
/**
 * @since 1.0.0
 * @author Luca
 * @licence MIT
 */

if ( !loggedIn() ) {
    $_SESSION['failMessage'] = 'Sie müssen dafür eingeloggt sein. Jetzt <a href="?login">einloggen</a> oder <a href="?register">registrieren</a>.';
    goToHome();
}

echo '<h1>Game</h1>';