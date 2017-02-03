<?php
/**
 * Created by PhpStorm.
 * User: Luca, Omer, Jan, Tobias M.
 * Date: 31.01.2017
 * Time: 10:48
 */

$dbUser = 'schnickuser';
$dbPass = 'schnick';
$dbName = 'schnick-schnack';
$dbHost = 'localhost';

try {
    $db = new PDO( 'mysql:host=' . $dbHost, $dbUser, $dbPass );
    $db->exec( 'USE ' . $dbName );
} catch ( PDOException $e ) {
    $tempDB = new PDO( 'mysql:host=' . $dbHost, 'root', '' );
    $tempSQL = file_get_contents( 'tables.sql' );
    $tempDB->query( $tempSQL );
    unset( $tempSQL );
    unset( $tempDB );

    $db = new PDO( 'mysql:host=' . $dbHost, $dbUser, $dbPass );

    $db->exec( 'USE ' . $dbName );
}
