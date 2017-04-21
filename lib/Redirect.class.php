<?php
/**
 * @since 1.0.0
 * @author Luca
 * @licence MIT
 */

namespace Lib;


class Redirect {
    public static function to( $url ) {
        header( 'Location: ' . $url );
        exit();
    }
}