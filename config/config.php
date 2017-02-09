<?php
/**
 * Created by PhpStorm.
 * User: Luca, Omer, Jan, Tobias M.
 * Date: 31.01.2017
 * Time: 10:53
 */

require_once 'init_constants.php';

// Include our MySQL connection.
require_once 'db.php';

// Include classes.
$classArray = scandir( 'lib' );
foreach ( $classArray as $class ) {
    if ( strpos( $class, '.class.php' ) ) {
        require_once( 'lib/' . $class );
    }
}

// Start the session.
session_start();

// Include our basic functions.
require_once 'functions.php';

$currentUser = new \lib\User();
if ( isset( $_SESSION['userId'] ) ) {
    $currentUser = $currentUser->loadById( $_SESSION['userId'] );
}