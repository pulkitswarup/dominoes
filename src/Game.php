<?php

namespace Game\Dominoes;

use Game\Dominoes\Exceptions\DominoNotFoundException;
use Game\Dominoes\Exceptions\NoDominoesOnTheBoardException;
use Game\Dominoes\Exceptions\ValidationException;

class Game implements Rules
{
    /** @var Player[] list of players */
    private $players;

    /** @var Set set of domino tiles */
    private $set;

    /** @var Board board upon which the game would be played */
    private $board;

    public function __construct(
        array $players,
        Set $set,
        Board $board
    ) {
        $this->players = $players;
        $this->set = $set->shuffle();
        $this->board = $board;
    }

    /**
     * Returns list of players in the game
     *
     * @return Player[]
     */
    public function getPlayers() : array
    {
        return $this->players;
    }

    /**
     * Play the game
     *
     * @return void
     */
    public function play() : void
    {
        $round = 0;
        $currentPlayer = null;
        $totalPlayer = count($this->getPlayers());

        if(!$this->validate()) {
            throw new ValidationException();
        }

        $this->deal();

        /** @var Domino $first draw a tile from the set*/
        $first = $this->set->draw();

        $this->board->queue($first);
        message(sprintf("Game starting with first tile: %s", (string) $first));

        while (
            $this->set->hasDominoes()
            && (
                (
                    $currentPlayer !== null
                    && $currentPlayer->hasDominoes()
                )
                || $currentPlayer === null
            )
        ) {
            $currentPlayer = $this->players[$round % $totalPlayer];
            $hasDrawn = $this->drawNextHand($currentPlayer);
            message(sprintf("Board is now: %s", (string) $this->board));
            $round++;
        }

        if ($currentPlayer !== null && $currentPlayer->getScore() === 0) {
            message(
                sprintf('Player %s has won! %s', $currentPlayer->getName(), '🎉')
            );
        } else {
            message(sprintf("The game ends in a draw! %s", '🙁'));
        }
    }

    /**
     * Deals tiles to the players
     *
     * @return void
     */
    protected function deal() : void
    {
        foreach ($this->players as $player) {
            for ($count=0; $count < Rules::TILES_PER_PLAYER; $count++) {
                /** @var Domino $domino */
                $domino = $this->set->draw();
                $player->addDomino($domino);
            }
        }
    }

    /**
     * Draws matching tile from players hand
     *
     * @param Player $currentPlayer
     * @return boolean
     */
    protected function drawNextHand(Player $currentPlayer) : bool
    {
        $dominosOnTheBoard = $this->board->get();
        if (empty($dominosOnTheBoard)) {
            throw new NoDominoesOnTheBoardException();
        }

        if ($domino = $currentPlayer->getMatch(reset($dominosOnTheBoard)->getFirst())) {
            if ($domino->getFirst() === reset($dominosOnTheBoard)->getFirst()) {
                $domino->flip();
            }
            message(
                sprintf(
                    "%s plays %s to connect to tile %s on the board",
                    $currentPlayer->getName(),
                    (string) $domino,
                    (string) reset($dominosOnTheBoard)
                )
            );
            $currentPlayer->removeDomino($domino);
            $this->board->push($domino);
        } else if ($domino = $currentPlayer->getMatch(end($dominosOnTheBoard)->getSecond())) {
            if ($domino->getSecond() === end($dominosOnTheBoard)->getSecond()) {
                $domino->flip();
            }
            message(
                sprintf(
                    "%s plays %s to connect to tile %s on the board",
                    $currentPlayer->getName(),
                    (string) $domino,
                    (string) end($dominosOnTheBoard)
                )
            );
            $currentPlayer->removeDomino($domino);
            $this->board->queue($domino);
        } else if ($this->set->hasDominoes()) {
            $domino = $this->set->draw();
            message(
                sprintf('%s can\'t play, drawing tile %s', $currentPlayer->getName(), (string) $domino)
            );
            $currentPlayer->addDomino($domino);
            $this->drawNextHand($currentPlayer);
        }

        return true;
    }

    /** @inheritDoc */
    public function validate() : bool
    {
        if (!(
            count($this->getPlayers()) < Rules::MIN_PLAYERS
            || count($this->getPlayers()) > Rules::MAX_PLAYERS
        )) {
            return true;
        }
        return false;
    }
}