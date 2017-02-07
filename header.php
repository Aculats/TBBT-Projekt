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
    <title><?php echo WEB_NAME; ?></title>
</head>
<body>
<header>
    <nav>
        <a href="<?php echo WEB_DIR; ?>">Home</a>
        <a href="?game">Game</a>
        <?php if ( loggedIn() ): ?>
            <a href="?logout">Logout</a>
        <?php else: ?>
            <a href="?login">Login</a>
            <a href="?register">Register</a>
        <?php endif; ?>
    </nav>
</header>
<main>