<?php
/**
 * Created by PhpStorm.
 * User: Luca, Omer, Jan, Tobias M.
 * Date: 20.04.2017
 * Time: 10:10
 */

?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Game - Spieler anlegen</h1>
                </div>

                <div class="panel-body">
                    <form class="form-horizontal col-md-8 col-md-offset-2" action="?game" method="post">
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="player1">Spieler 1</label>
                            <div class="col-md-10">
                                <input type="text"
                                       id="player1"
                                       name="player1"
                                       class="form-control">
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Start</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>