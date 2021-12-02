<?php

declare(strict_types=1);

namespace TicTacToe;

use TicTacToe\Contracts\Movable;
use TicTacToe\Contracts\Signable;

abstract class Player implements Movable, Signable
{
    /**
     *
     * @param string $sign
     * @return void
     */
    public function __construct(public string $sign)
    {
    }

    /**
     *
     * @inheritDoc
     */
    public function move(int $x, int $y): void
    {
        $container = Container::getInstance();

        /** @var \Board $board */
        $board = $container->make(Board::class);

        $board->touch(new Field($x, $y));
    }
}
