<?php

namespace Game\Dominoes;

use Game\Dominoes\Exceptions\NoDominoesInSetException;
use Game\Dominoes\Exceptions\InvalidDominoTypeException;

class Set
{
    /** @var Domino[] */
    private $set = [];

    public function __construct(string $dominoType = Domino::class)
    {
        if (! class_exists($dominoType)) {
            throw new InvalidDominoTypeException();
        }

        for ($first = $dominoType::MIN_VALUE; $first <= $dominoType::MAX_VALUE; $first++) {
            for ($second = $first; $second <= $dominoType::MAX_VALUE; $second++) {
                $this->set[] = new $dominoType($first, $second);
            }
        }
    }

    /**
     * Returns the tiles in the set
     *
     * @return Domino[]
     */
    public function get() : array
    {
        return $this->set;
    }

    /**
     * Adds tiles to the set
     *
     * @return void
     */
    public function add(Domino $domino)
    {
        $this->set[] = $domino;
    }

    /**
     * Shuffles the set of dominoes
     *
     * @return self
     */
    public function shuffle() : self
    {
        $this->set = array_shuffle_assoc($this->set);
        return $this;
    }

    /**
     * Draws the top most tile from the set
     *
     * @return Domino
     * @throws NoDominoesInSetException
     */
    public function draw() : Domino
    {
        if (!$this->hasDominoes()) {
            throw new NoDominoesInSetException();
        }
        return array_shift($this->set);
    }

    /**
     * Returns the total number of tiles in the set
     *
     * @return integer
     */
    public function total() : int
    {
        return count($this->set);
    }

    /**
     * Returns whether set has dominoes or not
     *
     * @return boolean
     */
    public function hasDominoes() : bool
    {
        if ($this->total() > 0) {
            return true;
        }
        return false;
    }

    public function __toString()
    {
        if ($this->hasDominoes()) {
            $set = [];
            foreach ($this->set as $domino) {
                $set[] = sprintf("<%s:%s>", $domino->getFirst(), $domino->getSecond());
            }

            return implode(' ', $set);
        }
        return '';
    }
}