<?php

    include "classes/Game.php";
    use Game\Game;

    //create Game object
    $game = new Game('LightIT Battle Arena');
    //start the game
    $game->startGame();
?>