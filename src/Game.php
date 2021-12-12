<?php

declare(strict_types=1);

namespace TicTacToe;

use Exception;
use TicTacToe\Players\Player;

class Game
{
    /** @var \TicTacToe\Players\Player[] $players */
    private array $players;
    private Board $board;
    private Context $context;
    // TODO: move into a new state and switch players there
    private Player $currentPlayer;

    public function move(array $coordinates): void
    {
        $this->getNextPlayer()->move($coordinates);
        $this->context->setState($this->board->getState());

        if (!$this->context->hasIdenticalSymbolsInARowAs($this->currentPlayer->getSymbol())) {
            return;
        }

        throw new Exception("Player {$this->currentPlayer->getSymbol()} won!");
    }

    public function addPlayer(Player $player): self
    {
        $player->setGame($this);

        $this->players[] = $player;

        return $this;
    }

    public function setCurrentPlayer(Player $player): self
    {
        $this->currentPlayer = $player;

        return $this;
    }

    public function setBoard(Board $board): self
    {
        $this->board = $board;

        return $this;
    }

    public function setContext(Context $context): self
    {
        $this->context = $context;

        return $this;
    }

    public function getBoard(): Board
    {
        return $this->board;
    }

    private function getNextPlayer(): Player
    {
        $nextPlayer = $this->currentPlayer === $this->players[0]
            ? $this->players[1]
            : $this->players[0];

        return $this->currentPlayer = $nextPlayer;
    }
}
