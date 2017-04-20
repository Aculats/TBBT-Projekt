<?php
/**
 * @since 1.0.0
 * @author Luca
 * @licence MIT
 */

namespace Lib;


class SinglePlayer {
    public $gameId = 0;
    public $player1 = '';
    public $player2 = 'CPU';
    public $currentPlayer = '';
    public $selection1 = '';
    public $selection2 = '';

    private static $table = 'singleuser';

    public function __construct() {
        if ( isset( $_SESSION['gameId'] ) && !empty( $_SESSION['gameId'] ) ) {
            $this->loadGame( $_SESSION['gameId'] );

            return $this;
        }

        $this->player1 = filter_input( INPUT_POST, 'player1' );
        $this->player2 = filter_input( INPUT_POST, 'player2' ) ?? 'CPU';
        $this->currentPlayer = $this->player1;

        $this->saveGame();

        return $this;
    }

    public function startGame() {
        if ( empty( $_POST['player1'] ) ) {
            Redirect::to( WEB_DIR . '/?gamestart' );
            exit();
        }

        if ( empty( $_POST['player2'] ) ) {
            return $this->startSinglePlayer();
        }

        return $this->startMultiPlayer();
    }

    private function startSinglePlayer() {

    }

    private function startMultiPlayer() {

    }

    private function saveGame() {
        global $pdo;

        $stmt = $pdo->prepare( 'INSERT INTO ' . self::$table . '(gameId, player1, player2, selection1, selection2) VALUES (?, ?, ?, ?, ?)' );
        $stmt->bindParam( 1, $this->player1 );
        $stmt->bindParam( 2, $this->player2 );
        $stmt->bindParam( 4, $this->selection1 );
        $stmt->bindParam( 5, $this->selection2 );

        $stmt->execute();
    }
}