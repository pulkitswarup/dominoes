<?php

namespace Game\Dominoes;

use Game\Dominoes\Exceptions\InvalidDominoValueException;

class Domino
{
    /** @var MIN_VALUE Minimum a side of tile can have */
    public const MIN_VALUE = 0;

    /** @var MAX_VALUE Maximum a side of tile can have */
    public const MAX_VALUE = 6;

    /** @var int one half of the rectagular tile */
    private $first;

    /** @var int second half of rectangular tile */
    private $second;

    public function __construct(int $first, int $second)
    {
        if ($this->isValid($first, $second)) {
            throw new InvalidDominoValueException();
        }

        $this->first = $first;
        $this->second = $second;
    }

    /**
     * Returns unique identifier for the rectangular tile
     *
     * @return string
     */
    public function getId() : string
    {
        $sides = [];
        if ($this->first <= $this->second) {
            $sides = array_merge($sides, [$this->first, $this->second]);
        } else {
            $sides = array_merge($sides, [$this->second, $this->first]);
        }

        return implode(':', $sides);
    }

    /**
     * Returns the first half of the rectangular tile
     *
     * @return integer
     */
    public function getFirst() : int
    {
        return $this->first;
    }

    /**
     * Returns the second half of the rectangular tile
     *
     * @return integer
     */
    public function getSecond() : int
    {
        return $this->second;
    }

    /**
     * Flips the sides of a rectangular tile
     *
     * @return void
     */
    public function flip() : void
    {
        [$this->second, $this->first] = [$this->first, $this->second];
    }

    /**
     * Returns the total value of the rectangular tile
     *
     * @return integer
     */
    public function getTotal() : int
    {
        return ($this->first + $this->second);
    }

    /**
     * Determines whether the value one of the domino values
     *
     * @param integer $value
     * @return boolean
     */
    public function isMatching(int $value) : bool
    {
        return (
            $this->getFirst() === $value
            || $this->getSecond() === $value
        );
    }

    /**
     * Returns whether a domino is valid or not
     *
     * @param int $first
     * @param int $second
     * @return boolean
     */
    public function isValid($first, $second) : bool
    {
        return (
            ($first < static::MIN_VALUE || $first > static::MAX_VALUE)
            || ($second < static::MIN_VALUE || $second > static::MAX_VALUE)
        );
    }
    public function __toString()
    {
        return sprintf("<%s:%s>", $this->first, $this->second);
    }
}