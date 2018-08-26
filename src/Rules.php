<?php

namespace Game\Dominoes;

interface Rules
{
    /** @var MIN_PLAYERS minimum number of player allowed in the game */
    public const MIN_PLAYERS = 2;

    /** @var MAX_PLAYERS maximum number of player allowed in the game */
    public const MAX_PLAYERS = 3;

    /** @var TILES_PER_PLAYER maximum number of tiles with a player */
    public const TILES_PER_PLAYER = 7;

    /**
     * Performs validation basis the defined rules
     *
     * @return boolean
     */
    public function validate() : bool;
}