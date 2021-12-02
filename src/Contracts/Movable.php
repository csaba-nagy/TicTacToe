<?php

declare(strict_types=1);

namespace TicTacToe\Contracts;

use TicTacToe\Board\Coordinate;

interface Movable
{
    public function move(Coordinate $coordinate): void;
}
