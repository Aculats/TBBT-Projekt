<?php
/**
 * Created by PhpStorm.
 * User: Luca, Omer, Jan, Tobias M.
 * Date: 31.01.2017
 * Time: 10:43
 */

require_once 'header.php';

if ( isset( $_GET['game'] ) && !empty( $_GET['game'] ) && is_file( $_GET['game'] . '.php' ) ) {
    require_once $_GET['game'] . '.php';
} elseif ( !empty( $_GET ) ) {
    echo '<h1>Seite nicht gefunden</h1>';
} else {
    require_once 'home.php';
}

require_once 'footer.php';