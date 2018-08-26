<?php

namespace Game\Dominoes;

use Game\Dominoes\Exceptions\DominoNotFoundException;
use Game\Dominoes\Exceptions\DominoAlreadyExistsException;
use Game\Dominoes\Exceptions\NoDominoesToMatchException;

class Player
{
    /** @var string name of the player */
    private $name;

    /** @var Domino[] */
    private $dominoes = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Returns the name of the player
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Returns the (current) score of the player
     *
     * @return integer
     */
    public function getScore() : int
    {
        $score = 0;
        foreach ($this->dominoes as $domino) {
            $score += $domino->getTotal();
        }

        return $score;
    }

    /**
     * Returns the dominoes in players hand
     *
     * @return Domino[]|null
     */
    public function getDominoes() : ?array
    {
        return $this->dominoes;
    }

    /**
     * Adds dominoes in players hand
     *
     * @param Domino $domino
     * @return int total number of dominoes with the player
     */
    public function addDomino(Domino $domino)
    {
        if (isset($this->dominoes[$domino->getId()])) {
            throw new DominoAlreadyExistsException();
        }

        $this->dominoes = [$domino->getId() => $domino] + $this->dominoes;

        return count($this->dominoes);
    }

    /**
     * Removes domino from players hand
     *
     * @param Domino $domino
     * @return boolean
     * @throws DominoNotFoundException
     */
    public function removeDomino(Domino $domino) : bool
    {
        if ($this->hasDominoes()) {
            foreach ($this->dominoes as $idx => $tile)
            {
                if (
                    $tile->getFirst() === $domino->getFirst()
                    && $tile->getSecond() === $domino->getSecond()
                ) {
                    unset($this->dominoes[$idx]);
                    return true;
                }
            }
        }
        throw new DominoNotFoundException();
    }

    /**
     * Returns whether a player has dominoes in his hand or not
     *
     * @return boolean
     */
    public function hasDominoes() : bool
    {
        return count($this->dominoes) ? true : false;
    }

    /**
     * Returns the matching pairs
     *
     * @param integer $value
     * @return Domino|null
     * @throws NoDominoesToMatchException
     */
    public function getMatch(int $value) : ?Domino
    {
        if ($this->hasDominoes()) {
            foreach ($this->dominoes as $domino) {
                if ($domino->isMatching($value)) {
                    return $domino;
                }
            }
            return null;
        }
        throw new NoDominoesToMatchException();
    }

    public function __toString()
    {
        if ($this->hasDominoes()) {
            $tiles = [];
            foreach ($this->dominoes as $domino) {
                $tiles[] = sprintf('<%s:%s>', $domino->getFirst(), $domino->getSecond());
            }

            return implode(' ', $tiles);
        }
        return '';
    }
}