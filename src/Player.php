<?php

declare(strict_types=1);

namespace TicTacToe;

class Player
{
    public const SIGN_O = '⭕';
    public const SIGN_X = '❌';

    /**
     *
     * @param string $_sign
     * @return void
     */
    public function __construct(
        private string $_sign,
    ) {
    }
}
