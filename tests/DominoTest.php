<?php

namespace Game\Dominoes\Tests;

use Game\Dominoes\Domino;
use PHPUnit\Framework\TestCase;
use Game\Dominoes\Exceptions\InvalidDominoValueException;

class DominoTest extends TestCase
{
    /** @test */
    public function it_creates_domino_tile()
    {
        $domino = new Domino(6,1);

        $this->assertEquals('1:6', $domino->getId());
        $this->assertNotEquals('6:1', $domino->getId());
        $this->assertEquals(6, $domino->getFirst());
        $this->assertEquals(1, $domino->getSecond());
    }

    /** @test */
    public function it_throws_exception_for_invalid_domino_value()
    {
        $this->expectException(InvalidDominoValueException::class);

        $domino = new Domino(7,1);
    }

    /** @test */
    public function it_returns_correct_total_for_a_tile()
    {
        $domino = new Domino(6,6);

        $this->assertEquals(12, $domino->getTotal());
    }

    /** @test */
    public function it_flips_the_tiles()
    {
        $domino = new Domino(6,1);

        $this->assertEquals(6, $domino->getFirst());
        $this->assertEquals(1, $domino->getSecond());
        $domino->flip();
        $this->assertEquals(1, $domino->getFirst());
        $this->assertEquals(6, $domino->getSecond());
    }

    /** @test */
    public function it_matches_the_domino_value()
    {
        $domino = new Domino(1,6);

        $this->assertTrue($domino->isMatching(1));
        $this->assertTrue($domino->isMatching(6));
    }

    /** @test */
    public function it_casts_to_string()
    {
        $domino = new Domino(6,1);

        $domino = (string) $domino;
        $this->assertEquals('<6:1>', $domino);
    }
}