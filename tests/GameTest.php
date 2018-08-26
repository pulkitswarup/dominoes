<?php

namespace Game\Dominoes\Tests;

use Game\Dominoes\Set;
use Game\Dominoes\Game;
use Game\Dominoes\Board;
use Game\Dominoes\Rules;
use Game\Dominoes\Player;
use Game\Dominoes\Domino;
use PHPUnit\Framework\TestCase;
use Game\Dominoes\Exceptions\NoDominoesOnTheBoardException;
use Game\Dominoes\Exceptions\NoDominoesInSetException;
use Game\Dominoes\Exceptions\ValidationException;

class GameTest extends TestCase
{
    /** @test */
    public function it_instantiates_game()
    {
        $players = [new Player('Alice'), new Player('Bob')];
        $set = new Set(Domino::class);
        $board = new Board();

        $game = new Game($players, $set, $board);

        $this->assertInstanceOf(Game::class, $game);
        $this->assertEquals($players, $game->getPlayers());
    }

    /** @test */
    public function it_deals_tiles_to_the_players()
    {
        $players = [new Player('Alice'), new Player('Bob')];
        $set = new Set(Domino::class);
        $board = new Board();
        $game = new Game($players, $set, $board);

        $reflector = new \ReflectionClass(Game::class);
        $method = $reflector->getMethod('deal');
        $method->setAccessible(true);

        $method->invokeArgs($game, []);

        foreach ($players as $player) {
            /** @var array $dominoes */
            $dominoes = $player->getDominoes();
            $this->assertEquals(Rules::TILES_PER_PLAYER, count($dominoes));
        }
    }

    /** @test */
    public function it_throws_exception_in_case_of_insufficient_dominos_while_dealing()
    {
        $this->expectException(NoDominoesInSetException::class);

        $players = [new Player('Alice'), new Player('Bob')];

        $set = new Set(Domino::class);
        $count = 0;
        while ($count < 26) {
            $domino = $set->draw();
            $count++;
        }

        $board = new Board();
        $game = new Game($players, $set, $board);

        $reflector = new \ReflectionClass(Game::class);
        $method = $reflector->getMethod('deal');
        $method->setAccessible(true);

        $method->invokeArgs($game, []);

        foreach ($players as $player) {
            /** @var array $dominoes */
            $dominoes = $player->getDominoes();
            $this->assertEquals(Rules::TILES_PER_PLAYER, count($dominoes));
        }
    }

    /** @test */
    public function it_throws_exception_when_trying_to_draw_when_no_tiles_on_the_board()
    {
        $this->expectException(NoDominoesOnTheBoardException::class);

        $players = [new Player('Alice'), new Player('Bob')];
        $set = new Set(Domino::class);
        $board = new Board();
        $game = new Game($players, $set, $board);

        $reflector = new \ReflectionClass(Game::class);
        $method = $reflector->getMethod('drawNextHand');
        $method->setAccessible(true);

        $value = $method->invokeArgs($game, [current($players)]);
    }

    /** @test */
    public function it_deals_tiles_to_players()
    {
        $players = [new Player('Alice'), new Player('Bob')];
        $set = new Set(Domino::class);
        $board = new Board();
        $game = new Game($players, $set, $board);

        $reflector = new \ReflectionClass(Game::class);
        $method = $reflector->getMethod('deal');
        $method->setAccessible(true);

        $method->invokeArgs($game, []);
        $players = $game->getPlayers();

        foreach ($players as $player) {
            /** @var array $dominoes */
            $dominoes = $player->getDominoes();
            $this->assertEquals(Rules::TILES_PER_PLAYER, count($dominoes));
        }
    }

    /** @test */
    public function it_draws_hand_in_the_begining_of_the_list()
    {
        $player = new Player('Alice');
        $player->addDomino(new Domino(5,3));

        $players = [$player, new Player('Bob')];

        $set = new Set(Domino::class);

        $board = new Board();
        $board->push(new Domino(3,4));

        $game = new Game($players, $set, $board);

        $reflector = new \ReflectionClass(Game::class);
        $method = $reflector->getMethod('drawNextHand');
        $method->setAccessible(true);

        $value = $method->invokeArgs($game, [$player]);

        $this->assertTrue($value);
        $this->assertEquals('<5:3> <3:4>', (string) $board);
        $this->assertFalse($player->hasDominoes());
    }

    /** @test */
    public function it_draws_hand_in_the_begining_of_the_list_flip_domino()
    {
        $player = new Player('Alice');
        $player->addDomino(new Domino(3,5));

        $players = [$player, new Player('Bob')];

        $set = new Set(Domino::class);

        $board = new Board();
        $board->push(new Domino(3,4));

        $game = new Game($players, $set, $board);

        $reflector = new \ReflectionClass(Game::class);
        $method = $reflector->getMethod('drawNextHand');
        $method->setAccessible(true);

        $value = $method->invokeArgs($game, [$player]);

        $this->assertTrue($value);
        $this->assertEquals('<5:3> <3:4>', (string) $board);
        $this->assertFalse($player->hasDominoes());
    }

    /** @test */
    public function it_draws_hand_in_the_end_of_the_list()
    {
        $player = new Player('Alice');
        $player->addDomino(new Domino(4,1));

        $players = [$player, new Player('Bob')];

        $set = new Set(Domino::class);

        $board = new Board();
        $board->push(new Domino(3,4));

        $game = new Game($players, $set, $board);

        $reflector = new \ReflectionClass(Game::class);
        $method = $reflector->getMethod('drawNextHand');
        $method->setAccessible(true);

        $value = $method->invokeArgs($game, [$player]);

        $this->assertTrue($value);
        $this->assertEquals('<3:4> <4:1>', (string) $board);
        $this->assertFalse($player->hasDominoes());
    }

    /** @test */
    public function it_draws_hand_in_the_end_of_the_list_flip_domino()
    {
        $player = new Player('Alice');
        $player->addDomino(new Domino(1,4));

        $players = [$player, new Player('Bob')];

        $set = new Set(Domino::class);

        $board = new Board();
        $board->push(new Domino(3,4));

        $game = new Game($players, $set, $board);

        $reflector = new \ReflectionClass(Game::class);
        $method = $reflector->getMethod('drawNextHand');
        $method->setAccessible(true);

        $value = $method->invokeArgs($game, [$player]);

        $this->assertTrue($value);
        $this->assertEquals('<3:4> <4:1>', (string) $board);
        $this->assertFalse($player->hasDominoes());
    }

    /** @test */
    public function it_draws_from_set_and_matches_on_board()
    {
        $set = new Set(Domino::class);

        /** @var Domino $domino */
        $domino = $set->draw();

        $player = new Player('Alice');
        $player->addDomino($domino);

        $players = [$player, new Player('Bob')];

        $board = new Board();
        $board->push(new Domino(3, 4));

        $game = new Game($players, $set, $board);

        $reflector = new \ReflectionClass(Game::class);
        $method = $reflector->getMethod('drawNextHand');
        $method->setAccessible(true);

        $value = $method->invokeArgs($game, [$player]);

        /** @var array $dominoes */
        $dominoes = $player->getDominoes();

        $this->assertTrue($value);
        $this->assertArraySubset([$domino->getId() => $domino], $dominoes);
    }

    /** @test */
    public function it_throws_exception_in_case_set_is_empty_before_play()
    {
        $this->expectException(NoDominoesInSetException::class);

        $set = new Set(Domino::class);
        $count = 0;
        while($count < 14) {
            $domino = $set->draw();
            $count++;
        }

        $players = [new Player('Alice'), new Player('Bob')];

        $board = new Board();
        $board->push($domino);

        $game = new Game($players, $set, $board);

        $game->play();

        // foreach($players as $player) {
        //     $this->assertGreaterThan(0, count($player->getDominoes()));
        // }
    }

    /** @test */
    public function it_ends_in_a_draw()
    {
        $count = 0;
        $set = new Set(Domino::class);
        while ($count < 13) {
            $domino = $set->draw();
            $count++;
        }

        $players = [new Player('Alice'), new Player('Bob')];

        $board = new Board();
        $board->push($domino);

        $game = new Game($players, $set, $board);

        $game->play();

        foreach($players as $player) {
            $this->assertGreaterThan(0, count($player->getDominoes()));
        }
    }

    /** @test */
    public function it_ends_with_one_player_winning()
    {
        $set = $this->getMockBuilder(Set::class)
            ->disableOriginalConstructor()
            ->getMock();

        $original = new Set(Domino::class);
        while ($original->hasDominoes()) {
            $domino = $original->draw();
        }

        $original->add(new Domino(3,5)); // Player ('Alice')
        $original->add(new Domino(0,2)); // Player ('Alice')
        $original->add(new Domino(3,4)); // Player ('Alice')
        $original->add(new Domino(2,6)); // Player ('Alice')
        $original->add(new Domino(1,2)); // Player ('Alice')
        $original->add(new Domino(1,0)); // Player ('Alice')
        $original->add(new Domino(3,6)); // Player ('Alice')
        $original->add(new Domino(0,1)); // Player ('Bob')
        $original->add(new Domino(0,3)); // Player ('Bob')
        $original->add(new Domino(0,5)); // Player ('Bob')
        $original->add(new Domino(1,1)); // Player ('Bob')
        $original->add(new Domino(1,3)); // Player ('Bob')
        $original->add(new Domino(4,5)); // Player ('Bob')
        $original->add(new Domino(2,2)); // Player ('Bob')
        $original->add(new Domino(2,3)); // Player ('Deck')
        $original->add(new Domino(2,4)); // Player ('Deck')

        $set->method('shuffle')->willReturn($original);

        $player1 = new Player('Alice');
        $player2 = new Player('Bob');

        $board = new Board();

        $game = new Game([$player1, $player2], $set, $board);

        $game->play();

        $this->assertEquals(0, count($player1->getDominoes()));
        $this->assertEquals(1, count($player2->getDominoes()));
    }

    /** @test */
    public function it_fails_validation()
    {
        $this->expectException(ValidationException::class);

        $player = new Player('Alice');
        $set = new Set(Domino::class);
        $board = new Board();

        $game = new Game([$player], $set, $board);
        $game->play();
    }
}