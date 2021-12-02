<?php

declare(strict_types=1);

namespace TicTacToe\Contracts;

interface Movable
{
    /**
     *
     * @param int $x
     * @param int $y
     * @return void
     */
    public function move(int $x, int $y): void;
}
