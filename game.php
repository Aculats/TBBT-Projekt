<?php
/**
 * Created by PhpStorm.
 * User: Luca, Omer, Jan, Tobias M.
 * Date: 20.04.2017
 * Time: 08:53
 */

$game = new \Lib\SinglePlayer();

?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Am Zug: <?php echo $game->currentPlayer; ?></h1>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <?php
                        $i = 0;
                        foreach ( \lib\Game::getElements() as $element ) :
                            ?>
                            <form action="?game"
                                    method="post"
                                    class="form-horizontal col-md-2<?php echo $i == 0 ? ' col-md-offset-1' : ''; ?>"
                                    id="<?php echo $element['id']; ?>">
                                <button type="submit"
                                        class="btn btn-primary"
                                        name="move"
                                        value="<?php echo $element['id']; ?>">
                                    <img src="img/<?php echo $element['name']; ?>.png"
                                            class="col-md-12"
                                            alt="<?php echo $element['name']; ?>">
                                </button>
                                <div class="text-center">
                                    <?php echo $element['name']; ?>
                                </div>
                            </form>
                            <?php
                            $i++;
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>