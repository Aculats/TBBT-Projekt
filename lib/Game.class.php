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

    const ROCK = 1;
    const PAPER = 2;
    const SCISSORS = 3;
    const LIZARD = 4;
    const SPOCK = 5;
    const MATCHES = [
        self::ROCK => [
            self::SCISSORS,
            self::LIZARD
        ],
        self::PAPER => [
            self::ROCK,
            self::SPOCK
        ],
        self::SCISSORS => [
            self::PAPER,
            self::LIZARD
        ],
        self::LIZARD => [
            self::SPOCK,
            self::PAPER
        ],
        self::SPOCK => [
            self::SCISSORS,
            self::ROCK
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

    public function __construct( $player1, $player2 = '' ) {
        if ( empty( $player2 ) ) {
            $player2 = $this->findPlayer( $player1->id );
            var_dump( $player1->__get( 'username' ) );
            var_dump( $player2->__get( 'username' ) );
        }

    }

    private function findPlayer( $id ) {
        global $pdo;

        $sql = "SELECT * FROM users WHERE status = :status";
        $stmt = $pdo->prepare( $sql );
        $stmt->bindValue( ':status', 1 );
        $stmt->execute();

        if ( $rows = $stmt->fetchAll() ) {
            $rowCount = count( $rows );
            $i = 0;
            $break = false;
            do {
                if ( $i == 10 ) {
                    $break = true;
                    break;
                }
                $index = rand( 0, $rowCount - 1 );
                $i++;
            } while( $rows[$index]['id'] == $id );

            if ( !$break ) {
                $player2 = User::load( $rows[$index]['id'] );
                return $player2;
            }
        } else {
            die( 'Anybody is online.' );
        }

        die( 'Cannot find any user.' );
    }

    public static function getElements() {
        return self::ELEMENTS;
    }

    public static function play( $player1, $player2 )
    {
        if ( !self::isValid( $player1 ) || !self::isValid( $player2 ) ) {
            throw new Exception( 'Invalid input!' );
        }

        return in_array( $player2, self::matches[$player1] );
    }

    public static function isValid( $num )
    {
        return array_key_exists( self::MATCHES, $num );
    }
}