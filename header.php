<?php
/**
 * Created by PhpStorm.
 * User: Luca, Omer, Jan, Tobias M.
 * Date: 01.02.2017
 * Time: 10:16
 */

require_once 'config.php';

?>

<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>TBBT - <?php
        echo ( isset( $_GET['game'] ) && !empty( $_GET['game'] ) ? ucfirst( $_GET['game'] ) : 'Browser Game' );
        ?></title>
</head>
<body>
<header>
    <nav>
        <a href="?game=test">Test</a>
        <a href="?game=game">Game</a>
    </nav>
</header>
<main>