<?php

declare(strict_types=1);

namespace TicTacToe;

use TicTacToe\Board\Coordinate;
use TicTacToe\Contracts\Runnable;
use TicTacToe\Contracts\Signable;
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
        /** @var (\TicTacToe\Board\Coordinate|null)[][] $state */
        $state = [
            [null, null, null],
            [null, null, null],
            [null, null, null],
        ];

        $playerX = new Player(Signable::SIGN_X);

        $game = new Game();

        $game->addPlayer($playerX);
        $game->addPlayer(new Player(Signable::SIGN_O));
        $game->setBoard(new Board($state));
        $game->run();

        $playerX->move(new Coordinate(0, 0));
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
