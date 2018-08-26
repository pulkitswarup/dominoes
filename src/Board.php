<?php

namespace Game\Dominoes;

class Board
{
    /** @var Domino[] domino tiles on the board */
    private $dominoes = [];

    /**
     * Queues a dominos at the end of the set
     *
     * @param Domino $domino
     * @return void
     */
    public function queue(Domino $domino) : void
    {
        $this->dominoes[] = $domino;
    }

    /**
     * Pushes dominoes at the begining of the set
     *
     * @param Domino $domino
     * @return void
     */
    public function push(Domino $domino) : void
    {
        array_unshift($this->dominoes, $domino);
    }
    /**
     * Returns the domino tiles on the board
     *
     * @return Domino[]
     */
    public function get() : array
    {
        return $this->dominoes;
    }

    /**
     * Returns whether there are domino tiles on the board or not
     *
     * @return boolean
     */
    public function hasDominoes() : bool
    {
        if (count($this->dominoes) > 0) {
            return true;
        }
        return false;
    }

    public function __toString()
    {
        if ($this->hasDominoes()) {
            $dominoes = [];
            foreach ($this->dominoes as $domino) {
                $dominoes[] = sprintf("<%s:%s>", $domino->getFirst(), $domino->getSecond());
            }
            return implode(' ', $dominoes);
        }
        return '';
    }
}