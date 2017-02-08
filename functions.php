<?php
/**
 * @since 1.0.0
 * @author Luca
 * @licence MIT
 */

function loggedIn() {
    if ( !isset( $_SESSION['userId'] ) ) {
        return false;
    }

    return true;
}

function goToHome() {
    header( 'Location: ' . WEB_DIR );
}