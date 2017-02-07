<?php
/**
 * @since 1.0.0
 * @author Luca
 * @licence MIT
 */

$template = new lib\Template();

$template->assign( 'session', $_SESSION );
$template->display( 'templates/home.phtml' );