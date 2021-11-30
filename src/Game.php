<?php

declare(strict_types=1);

namespace TicTacToe;

use Exception;
use TicTacToe\Contracts\Runnable;

class Game implements Runnable
{
    /** @var \TicTacToe\Player[] $_players */
    private array $_players = [];

    private Board $_board;

    /**
     * Start the game.
     *
     * @return void
     */
    public function run(): void
    {
        dump($this->_players, $this->_board);
    }

    /**
     * Add a player to the game only, if the player is not already in the game.
     *
     * @param \TicTacToe\Player $player
     * @return void
     */
    public function addPlayer(Player $player): void
    {
        if (in_array($player, $this->_players, true)) {
            throw new Exception('Player already exists.');
        }

        $this->_players[] = $player;
    }

    /**
     * Add a board to the game.
     *
     * @param \TicTacToe\Board $board
     * @return void
     */
    public function setBoard(Board $board): void
    {
        $this->_board = $board;
    }
}
