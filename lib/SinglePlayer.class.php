<?php
/**
 * @since 1.0.0
 * @author Luca
 * @licence MIT
 */

namespace Lib;


use function Couchbase\fastlzCompress;

class SinglePlayer {
    public $id;
    public $player1 = '';
    public $player2 = '';
    public $currentPlayer = '';
    public $round = 0;
    public $selection1 = '';
    public $selection2 = '';
    public $winner = '';

    private static $table = 'singleuser';

    public function __construct() {
        if ( isset( $_SESSION['gameEnd'] ) ) {
            $gameData = $this->loadGame( $_SESSION['gameId'] );

            unset( $_SESSION['gameId'] );
            unset( $_SESSION['gameEnd'] );

            foreach ( $gameData as $key => $value ) {
                $this->$key = $value;
            }

            $this->winner = $this->getWinner();

            if ( !$this->winner ) {
                $this->winner = 'Unentschieden';
            }

            return $this;
        }

        if ( isset( $_SESSION['gameId'] ) && !empty( $_SESSION['gameId'] ) && !isset( $_SESSION['gameEnd'] ) ) {

            $gameData = $this->loadGame( $_SESSION['gameId'] );

            foreach ( $gameData as $key => $value ) {
                $this->$key = $value;
            }

            $this->currentPlayer = $this->round == 1 ? $this->player2 : $this->player1;

            if ( isset( $_POST['move'] ) ) {
                $this->setMove();
            }

            if ( isset( $_SESSION['gameEnd'] ) ) {
                Redirect::to( WEB_DIR . '/?gameend' );
                exit();
            }

            return $this;
        }

        if ( empty( $_POST['player1'] ) && !isset( $_SESSION['gameId'] ) ) {
            Redirect::to( WEB_DIR . '/?gamestart' );
            exit();
        }

        $this->player1 = filter_input( INPUT_POST, 'player1' ) ?? '';
        $this->player2 = filter_input( INPUT_POST, 'player2' );

        if ( empty( $this->player2 ) ) {
            $this->player2 = 'CPU';
        }

        $this->currentPlayer = $this->player1;

        $this->saveGame( true );

        return $this;
    }

    private function setMove() {
        if ( $this->currentPlayer == $this->player1 ) {
            $this->selection1 = filter_input( INPUT_POST, 'move' );
        } else {
            $this->selection2 = filter_input( INPUT_POST, 'move' );
        }

        if ( $this->player2 == 'CPU' ) {
            $this->selection2 = rand( 1, 5 );
        }

        $this->saveGame();

        if ( $this->player2 == 'CPU' || $this->round == 3 ) {
            $_SESSION['gameEnd'] = true;
        }
    }

    private function loadGame( $gameId ) {
        global $pdo;

        $dbData = $pdo->query( 'SELECT * FROM ' . self::$table . ' WHERE id = ' . $gameId );
        $data = [];

        foreach ( $dbData as $row ) {
            $data['id'] = $row['id'];
            $data['player1'] = $row['player1'];
            $data['player2'] = $row['player2'];
            $data['round'] = $row['round'];
            $data['selection1'] = $row['selection1'];
            $data['selection2'] = $row['selection2'];
        }

        return $data;
    }

    private function saveGame( $isNew = false ) {
        global $pdo;

        if ( !isset( $_SESSION['gameId'] ) || empty( $_SESSION['gameId'] ) || isset( $_SESSION['gameEnd'] ) ) {
            unset( $_SESSION['gameEnd'] );
        }

        $round = $this->round + 1;

        if ( $isNew ) {
            $stmt = $pdo->prepare( 'INSERT INTO ' . self::$table . '(player1, player2) VALUES (?, ?)' );
            $stmt->bindParam( 1, $this->player1 );
            $stmt->bindParam( 2, $this->player2 );
        } else {
            $stmt = $pdo->prepare( 'UPDATE ' . self::$table . ' SET selection1=?, selection2=?, round=? WHERE id=' . $this->id );
            $stmt->bindParam( 1, $this->selection1 );
            $stmt->bindParam( 2, $this->selection2 );
            $stmt->bindParam( 3, $round );
        }

        $stmt->execute();

        if ( $isNew ) {
            $_SESSION['gameId'] = $pdo->lastInsertId();
        }
    }

    private function getWinner() {
        if ( in_array( $this->selection1, Game::getMatches( $this->selection2 ) ) ) {
            return $this->player2;
        } elseif ( in_array( $this->selection2, Game::getMatches( $this->selection1 ) ) ) {
            return $this->player1;
        } else {
            return false;
        }
    }
}