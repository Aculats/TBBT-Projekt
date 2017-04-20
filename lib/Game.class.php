<?php
/**
 * Created by PhpStorm.
 * User: Luca, Omer, Jan, Tobias M.
 * Date: 09.02.2017
 * Time: 08:33
 */

namespace lib;


class Game {
    public $id;

    const STEIN = 1;
    const PAPIER = 2;
    const SCHERE = 3;
    const ECHSE = 4;
    const SPOCK = 5;
    const MATCHES = [
        self::STEIN => [
            self::SCHERE,
            self::ECHSE
        ],
        self::PAPIER => [
            self::STEIN,
            self::SPOCK
        ],
        self::SCHERE => [
            self::PAPIER,
            self::ECHSE
        ],
        self::ECHSE => [
            self::SPOCK,
            self::PAPIER
        ],
        self::SPOCK => [
            self::SCHERE,
            self::STEIN
        ],
    ];

    const ELEMENTS = [
        [
            'id' => 'stein',
            'name' => 'Stein',
        ],
        [
            'id' => 'papier',
            'name' => 'Papier',
        ],
        [
            'id' => 'schere',
            'name' => 'Schere',
        ],
        [
            'id' => 'echse',
            'name' => 'Echse',
        ],
        [
            'id' => 'spock',
            'name' => 'Spock',
        ],
    ];

    public static function getElements() {
        return self::ELEMENTS;
    }

    public static function play( $player1, $player2 )
    {
        if ( !self::isValid( $player1 ) || !self::isValid( $player2 ) ) {
            throw new Exception( 'Invalid input!' );
        }

        return in_array( $player2, self::MATCHES[$player1] );
    }

    public static function isValid( $num )
    {
        return array_key_exists( self::MATCHES, $num );
    }
}