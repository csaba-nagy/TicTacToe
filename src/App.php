<?php

declare(strict_types=1);

namespace TicTacToe;

use TicTacToe\Contracts\Runnable;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class App implements Runnable
{
    /**
     * Initialize the application. Setup the error handler on development.
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    public function __construct()
    {
        $this->_setupWhoops();
    }

    /**
     * Run the application after add players.
     *
     * @return void
     */
    public function run(): void
    {
        $game = new Game();

        $game->addPlayer(new Player(Player::SIGN_X));
        $game->addPlayer(new Player(Player::SIGN_O));
        $game->run();
    }

    /**
     * Enable whoops error handling for development purposes only.
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    private function _setupWhoops(): void
    {
        if ($_SERVER['SERVER_NAME'] !== 'localhost') {
            return;
        }

        (new Run())->pushHandler(new PrettyPageHandler())->register();
    }
}
