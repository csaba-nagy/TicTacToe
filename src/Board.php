<?php

declare(strict_types=1);

namespace TicTacToe;

class Board
{
    private State $state;

    public function setState(State $state): void
    {
        $this->state = $state;
    }

    public function getState(): State
    {
        return $this->state;
    }
}
