<?php
/**
 * @since 1.0.0
 * @author Luca
 * @licence MIT
 */

if ( $currentUser->id !== 0 ) {
    $currentUser->logout();
}
 goToHome();