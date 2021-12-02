<?php

declare(strict_types=1);

namespace TicTacToe\Board;

class Coordinate
{
    public function __construct(
        public int $x,
        public int $y,
    ) {
    }
}
