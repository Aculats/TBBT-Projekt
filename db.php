<?php
/**
 * Created by PhpStorm.
 * User: Luca, Omer, Jan
 * Date: 31.01.2017
 * Time: 10:48
 */

$dbUser = 'schnick';
$dbPass = 'schnick';
$dbName = 'schnick-schnack';
$dbHost = 'localhost';

$db = new PDO( 'mysql:host=' . $dbHost . ';dbname=' . $dbName, $dbUser, $dbPass );
//$db = new PDO( 'mysql:host=localhost;dbname=test', $user, $pass );
