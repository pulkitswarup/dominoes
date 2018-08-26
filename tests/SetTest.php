<?php

namespace Game\Dominoes\Tests;

use Game\Dominoes\Set;
use Game\Dominoes\Domino;
use PHPUnit\Framework\TestCase;
use Game\Dominoes\Exceptions\InvalidDominoTypeException;
use Game\Dominoes\Exceptions\NoDominoTilesException;
use Game\Dominoes\Exceptions\NoDominoesInSetException;

class SetTest extends TestCase
{
    /** @test */
    public function it_creates_a_set_of_dominoes()
    {
        $set = new Set(Domino::class);

        $this->assertEquals(28, $set->total());
        for ($first = Domino::MIN_VALUE; $first <= Domino::MAX_VALUE; $first++) {
            for ($second = $first; $second <= Domino::MAX_VALUE; $second++) {
                $this->assertEquals(new Domino($first, $second), $set->draw());
            }
        }
        $this->assertEquals(0, $set->total());
    }

    /** @test */
    public function it_creates_a_set_of_default_dominoes()
    {
        $set = new Set();

        for ($first = Domino::MIN_VALUE; $first <= Domino::MAX_VALUE; $first++) {
            for ($second = $first; $second <= Domino::MAX_VALUE; $second++) {
                $this->assertEquals(new Domino($first, $second), $set->draw());
            }
        }
    }

    /** @test */
    public function it_throws_exception_for_invalid_domino_type()
    {
        $this->expectException(InvalidDominoTypeException::class);

        $set = new Set('NonExistentClass');
    }

    /** @test */
    public function it_throws_exception_for_drawing_more_tiles_than_in_the_set()
    {
        $this->expectException(NoDominoesInSetException::class);
        $set = new Set();

        for ($first = Domino::MIN_VALUE; $first <= Domino::MAX_VALUE; $first++) {
            for ($second = $first; $second <= Domino::MAX_VALUE; $second++) {
                $set->draw();
            }
        }

        // Trying to draw more, would return null
        $this->assertEquals(null, $set->draw());
    }

    /** @test */
    public function it_shuffles_the_set()
    {
        $set = new Set();
        $original = $set->get();
        $set->shuffle();
        $this->assertArraySubset($set->get(), $original);
    }

    /** @test */
    public function it_casts_to_string()
    {
        $set = new Set();
        $set2 = new Set();

        $set = (string) $set;

        while($set2->hasDominoes()) {
            $set2->draw();
        }
        $set2 = (string) $set2;

        $this->assertEquals(
            '<0:0> <0:1> <0:2> <0:3> <0:4> <0:5> <0:6> <1:1> <1:2> <1:3> <1:4> <1:5> <1:6> <2:2> <2:3> <2:4> <2:5> <2:6> <3:3> <3:4> <3:5> <3:6> <4:4> <4:5> <4:6> <5:5> <5:6> <6:6>',
            $set
        );

        $this->assertEquals('', $set2);
    }
}