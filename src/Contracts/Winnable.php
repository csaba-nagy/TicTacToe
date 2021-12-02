<?php

declare(strict_types=1);

namespace TicTacToe\Contracts;

interface Winnable
{
    /**
     *
     * @return bool
     */
    public function hasWinner(): bool;
}
