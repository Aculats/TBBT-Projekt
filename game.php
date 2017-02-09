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

$game = new \lib\Game( $currentUser );

$template = new lib\Template();

$template->assign( 'session', $_SESSION );
$template->assign( 'webDir', WEB_DIR );
$template->assign( 'webName', WEB_NAME );
$template->assign( 'user', $currentUser );
$template->assign( 'elements', \lib\Game::getElements() );
$template->display( 'templates/game.phtml' );