<?php

$template = new lib\Template();

$template->assign( 'webDir', WEB_DIR );
$template->display( 'templates/login.phtml' );