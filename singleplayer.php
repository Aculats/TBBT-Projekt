<?php
/**
 * Created by PhpStorm.
 * User: Luca, Omer, Jan, Tobias M.
 * Date: 20.04.2017
 * Time: 08:53
 */

?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Game</h1>
                </div>

                <div class="panel-body">
                    <?php
                    foreach ( \lib\Game::getElements() as $element ) :
                    ?>
                    <div class="element">
                        <a href="#" id="<?php echo $element['id']; ?>"><?php echo $element['name']; ?> </a>
                    </div>
                    <?php
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>