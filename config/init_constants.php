<?php
/**
 * @since 1.0.0
 * @author Luca
 * @licence MIT
 */

// Define the name of the game.
define( 'WEB_NAME', 'The Big Bang Theory - Browsergame' );
define( 'LOCAL', ( strpos( $_SERVER['HTTP_HOST'], '192.168.' ) !== false || strpos( $_SERVER['HTTP_HOST'], 'localhost' ) !== false ? true : false ) );
define( 'LIVE', !LOCAL );

if ( LOCAL ) {
    define( 'WEB_DIR', '/TBBT-Projekt' );
} elseif ( LIVE ) {
    define( 'WEB_DIR', '/' );
}

// Define credentials to connect to our database.
define( 'MYSQL_USER', 'tbbt-user' );
define( 'MYSQL_PASSWORD', 'tbbt-pass' );
define( 'MYSQL_HOST', 'localhost' );
define( 'MYSQL_DATABASE', 'tbbt' );