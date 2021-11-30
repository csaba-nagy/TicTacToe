<?php

declare(strict_types=1);

namespace TicTacToe;

use TicTacToe\Contracts\Runnable;

class Game implements Runnable
{
    /**
     * Start the game.
     *
     * @return void
     */
    public function run(): void
    {
        dump(__METHOD__);
    }
}
