<?php

declare(strict_types=1);

namespace TicTacToe;

use TicTacToe\Board\Coordinate;
use TicTacToe\Contracts\Movable;
use TicTacToe\Contracts\Signable;

class Player implements Signable, Movable
{
    /**
     *
     * @param string $_sign
     * @return void
     */
    public function __construct(
        private string $_sign,
    ) {
    }

    public function move(Coordinate $coordinate): void
    {
        dump([$coordinate, $this->_sign]);
    }
}
