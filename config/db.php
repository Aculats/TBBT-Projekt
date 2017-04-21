<?php
/**
 * Created by PhpStorm.
 * User: Luca, Omer, Jan, Tobias M.
 * Date: 31.01.2017
 * Time: 10:48
 */

/**
 * PDO options / configuration details.
 * I'm going to set the error mode to "Exceptions".
 * I'm also going to turn off emulated prepared statements.
 */
$pdoOptions = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
];

/**
 * Tables in DB - tbbt:
 *
 * singleuser:
 *  - id        -> int (primary)
 *  - player1   -> varchar (255)
 *  - player2   -> varchar (255)
 *  - round     -> int
 *  - selection1-> int
 *  - selection2-> int
 */
$tables = [
    'singleuser',
];

// Connect to MySQL and instantiate the PDO object.
$pdo = new PDO(
    'mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DATABASE, // DSN
    MYSQL_USER, // Username
    MYSQL_PASSWORD, // Password
    $pdoOptions // Options
);