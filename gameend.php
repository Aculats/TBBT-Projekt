<?php
/**
 * Created by PhpStorm.
 * User: Luca, Omer, Jan, Tobias M.
 * Date: 20.04.2017
 * Time: 08:53
 */

$game = new \Lib\SinglePlayer();
$name1 = \lib\Game::getElements( $game->selection1 )['name'];
$name2 = \lib\Game::getElements( $game->selection2 )['name'];

?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Gewinner: <?php echo $game->winner; ?></h1>
                </div>

                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td class="col-md-4">Spieler</td>
                            <td class="col-md-4">Gewählt</td>
                            <td class="col-md-4">Bild</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo $game->player1; ?></td>
                            <td><?php echo $name1; ?></td>
                            <td>
                                <img src="img/<?php echo $name1; ?>.png"
                                        alt="<?php echo $name1; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $game->player2; ?></td>
                            <td><?php echo $name2; ?></td>
                            <td>
                                <img src="img/<?php echo $name2; ?>.png"
                                        alt="<?php echo $name2; ?>">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="panel-footer">
                    <a href="<?php echo WEB_DIR; ?>/?gamestart">Nochmal spielen</a>
                </div>
            </div>
        </div>
    </div>
</div>