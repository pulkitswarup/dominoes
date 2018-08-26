<?php

namespace Game\Dominoes\Tests;

use Game\Dominoes\Board;
use Game\Dominoes\Domino;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    /** @test */
    public function it_queues_domino_on_the_board()
    {
        $domino1 = new Domino(1,5);
        $domino2 = new Domino(2,5);
        $board = new Board();
        $board->queue($domino1);
        $board->queue($domino2);

        $dominoes = $board->get();
        $this->assertEquals([$domino1, $domino2], $dominoes);
    }

    /** @test */
    public function it_pushes_domino_on_the_board()
    {
        $domino1 = new Domino(1, 5);
        $domino2 = new Domino(2, 5);
        $board = new Board();
        $board->push($domino1);
        $board->push($domino2);

        $dominoes = $board->get();
        $this->assertEquals([$domino2, $domino1], $dominoes);

    }

    /** @test */
    public function it_fetches_all_the_dominos_on_the_board()
    {
        $board = new Board();
        $board->queue(new Domino(1,6));
        $board->queue(new Domino(2,5));
        $board->queue(new Domino(3,1));
        $board->queue(new Domino(3,4));

        $this->assertEquals(
            [new Domino(1,6), new Domino(2,5), new Domino(3,1), new Domino(3,4)],
            $board->get()
        );
    }

    /** @test */
    public function it_checks_whether_the_board_has_dominos_or_not()
    {
        $board1 = new Board();
        $board2 = new Board();
        $board2->queue(new Domino(1, 6));

        $this->assertFalse($board1->hasDominoes());
        $this->assertTrue($board2->hasDominoes());
    }

    /** @test */
    public function it_casts_to_string()
    {
        $board = new Board();
        $board2 = new Board();

        $board->queue(new Domino(1, 6));
        $board->queue(new Domino(2, 5));
        $board->queue(new Domino(3, 1));
        $board->queue(new Domino(3, 4));

        $this->assertEquals('<1:6> <2:5> <3:1> <3:4>', (string) $board);
        $this->assertEquals('', (string) $board2);
    }
}