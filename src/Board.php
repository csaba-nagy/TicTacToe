<?php

declare(strict_types=1);

namespace TicTacToe;

class Board
{
    /**
     * @return void
     */
    public function __construct(
        private array $_state,
    ) {
    }
}
