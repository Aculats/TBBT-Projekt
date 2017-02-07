<?php
/**
 * Created by PhpStorm.
 * User: Luca, Omer, Jan, Tobias M.
 * Date: 01.02.2017
 * Time: 10:16
 */

require_once 'config.php';

$template = new lib\Template();

$template->assign( 'webDir', WEB_DIR );
$template->assign( 'webName', WEB_NAME );
$template->assign( 'loggedIn', loggedIn() );
$template->display( 'templates/header.phtml' );