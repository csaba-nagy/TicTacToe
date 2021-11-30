<?php

declare(strict_types=1);

namespace TicTacToe;

use Exception;
use TicTacToe\Contracts\Runnable;

class Game implements Runnable
{
    /** @var \TicTacToe\Player[] $_players */
    private array $_players = [];

    /**
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Start the game.
     *
     * @return void
     */
    public function run(): void
    {
        dump($this->_players);
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
}
