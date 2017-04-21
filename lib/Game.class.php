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
        self::STEIN => [
            'id' => self::STEIN,
            'name' => 'Stein',
        ],
        self::PAPIER => [
            'id' => self::PAPIER,
            'name' => 'Papier',
        ],
        self::SCHERE => [
            'id' => self::SCHERE,
            'name' => 'Schere',
        ],
        self::ECHSE => [
            'id' => self::ECHSE,
            'name' => 'Echse',
        ],
        self::SPOCK => [
            'id' => self::SPOCK,
            'name' => 'Spock',
        ],
    ];

    public static function getElements( $selection = null ) {
        if ( $selection == null ) {
            return self::ELEMENTS;
        }

        return self::ELEMENTS[$selection];
    }

    public static function getMatches( $selection ) {
        return self::MATCHES[(int)$selection];
    }
}