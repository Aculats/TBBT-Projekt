<?php
/**
 * Created by PhpStorm.
 * User: Luca, Omer, Jan, Tobias M.
 * Date: 31.01.2017
 * Time: 10:48
 */

$dbUser = 'root';
$dbPass = '';
$dbName = 'schnick-schnack';
$dbHost = 'localhost';

$db = new PDO( 'mysql:host=' . $dbHost, $dbUser, $dbPass );

if ( !$db->exec( 'USE ' . $dbName ) ) {
    $sql = file_get_contents( 'tables.sql' );
    $db->query( $sql );
    unset( $sql );
}
