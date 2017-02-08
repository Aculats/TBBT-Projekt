<?php
/**
 * Created by PhpStorm.
 * User: Luca, Omer, Jan, Tobias M.
 * Date: 31.01.2017
 * Time: 10:43
 */

require_once 'header.php';

if ( isset( $_POST['login'] ) ) {
    if ( $user = \lib\User::sLoad( $_POST ) ) {
        $user->login();
        goToHome();
    } else {
        echo 'Der Benutzername oder das Password ist falsch. Bitte versuche es erneut.';
    }
} elseif ( isset( $_POST['register'] ) ) {
    $user = new \lib\User( $_POST );
    $user->login();
    goToHome();
}

if ( !empty( $_GET ) ) {
    $getKeys = array_keys( $_GET );
    if ( count( $getKeys ) < 2 && is_file( $getKeys[0] . '.php' ) ) {
        require_once $getKeys[0] . '.php';
    } else {
        goToHome();
    }
} else {
    require_once 'home.php';
}

require_once 'footer.php';

var_dump(loggedIn());