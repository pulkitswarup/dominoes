<?php
ob_implicit_flush();

include_once __DIR__ . '/vendor/autoload.php';

use Game\Dominoes\Set;
use Game\Dominoes\Game;
use Game\Dominoes\Domino;
use Game\Dominoes\Player;
use Game\Dominoes\Board;

// Add player (2 <= number_of_player <= 3)
$players = [
    new Player('Alice'),
    new Player('Bob')
];

// Get a set of dominoes
$set = new Set(Domino::class);

// Add the game to the board
$board = new Board();

// Initialize game
$game = new Game($players, $set, $board);
$game->play();