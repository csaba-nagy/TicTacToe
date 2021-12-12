<?php

declare(strict_types=1);

namespace TicTacToe\Players;

use TicTacToe\Contracts\Symbolic;
use TicTacToe\Game;

class BasePlayer implements Symbolic
{
    protected string $symbol;
    protected Game $game;

    public function setSymbol(string $symbol): void
    {
        $this->symbol = $symbol;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function setGame(Game $game): void
    {
        $this->game = $game;
    }
}
