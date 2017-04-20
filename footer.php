<?php
/**
 * Created by PhpStorm.
 * User: Luca, Omer, Jan, Tobias M.
 * Date: 01.02.2017
 * Time: 10:17
 */

$template = new lib\Template();

$template->assign( 'loggedIn', loggedIn() );
$template->display( 'templates/footer.phtml' );