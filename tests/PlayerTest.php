<?php

namespace Game\Dominoes\Tests;

use Game\Dominoes\Domino;
use Game\Dominoes\Player;
use PHPUnit\Framework\TestCase;
use Game\Dominoes\Exceptions\DominoNotFoundException;
use Game\Dominoes\Exceptions\DominoAlreadyExistsException;
use Game\Dominoes\Exceptions\NoDominoesToMatchException;

class PlayerTest extends TestCase
{
    /** @test */
    public function it_creates_a_player()
    {
        $player = new Player('Alice');

        $this->assertInstanceOf(Player::class, $player);
        $this->assertEquals("Alice", $player->getName());
    }

    /** @test */
    public function it_gets_zero_score_for_player_with_no_dominoes()
    {
        $player = new Player('Alice');

        $this->assertEquals(0, $player->getScore());
    }

    /** @test */
    public function it_gets_correct_score_for_player_with_dominoes()
    {
        $player = new Player('Alice');

        $player->addDomino(new Domino(0,1));
        $player->addDomino(new Domino(0,2));
        $player->addDomino(new Domino(0,3));
        $player->addDomino(new Domino(0,4));

        $this->assertEquals(10, $player->getScore());
    }

    /** @test */
    public function it_can_add_dominoes_to_players_hand()
    {
        $player = new Player('Alice');

        $player->addDomino(new Domino(0,1));
        $player->addDomino(new Domino(0,2));
        $player->addDomino(new Domino(0,3));
        $player->addDomino(new Domino(0,4));

        /** @var Domino[] $dominoes */
        $dominoes = $player->getDominoes();
        $this->assertEquals(4, count($dominoes));
        $this->assertInstanceOf(Domino::class, current($dominoes));
    }

    /** @test */
    public function it_tells_whether_a_player_has_dominoes()
    {
        $player1 = new Player('Alice');
        $player2 = new Player('Bob');

        $player2->addDomino(new Domino(0,1));
        $player2->addDomino(new Domino(0,2));
        $player2->addDomino(new Domino(0,3));

        $this->assertFalse($player1->hasDominoes());
        $this->assertTrue($player2->hasDominoes());
    }

    /** @test */
    public function it_throws_exception_when_trying_to_add_duplicate_domino()
    {
        $this->expectException(DominoAlreadyExistsException::class);

        $player = new Player('Alice');
        $player->addDomino(new Domino(0,1));
        $player->addDomino(new Domino(0,1));
    }

    /** @test */
    public function it_throws_exception_when_removing_domino_that_is_not_present()
    {
        $this->expectException(DominoNotFoundException::class);

        $player = new Player('Alice');

        $player->addDomino(new Domino(0,1));
        $player->addDomino(new Domino(0,2));

        $player->removeDomino(new Domino(0,3));
    }

    /** @test */
    public function it_removes_requested_domino_from_players_hand()
    {
        $player = new Player('Alice');

        $player->addDomino(new Domino(0,1));
        $player->addDomino(new Domino(0,2));
        $player->addDomino(new Domino(0,3));

        $this->assertTrue($player->removeDomino(new Domino(0,1)));
    }

    /** @test */
    public function it_matches_the_dominoes_from_players_hand()
    {
        $player = new Player('Alice');

        $player->addDomino(new Domino(3,4));
        $player->addDomino(new Domino(1,2));

        $this->assertEquals(new Domino(3,4), $player->getMatch(3));
        $this->assertEquals(new Domino(3,4), $player->getMatch(4));
        $this->assertEquals(new Domino(1,2), $player->getMatch(1));
        $this->assertEquals(new Domino(1,2), $player->getMatch(2));
        $this->assertNull($player->getMatch(6));
    }

    /** @test */
    public function it_throws_exception_when_trying_to_match_with_no_tiles_in_hand()
    {
        $this->expectException(NoDominoesToMatchException::class);
        $player = new Player('Alice');

        $player->getMatch(1);
    }

    /** @test */
    public function it_casts_to_string()
    {
        $player = new Player('Alice');
        $player2 = new Player('Bob');

        $player->addDomino(new Domino(1,2));
        $player->addDomino(new Domino(2,3));

        $this->assertEquals('<2:3> <1:2>', (string) $player);
        $this->assertEquals('', (string) $player2);
    }

}