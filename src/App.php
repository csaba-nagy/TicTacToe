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
     * Run the application.
     *
     * @return void
     */
    public function run(): void
    {
        (new Game())->run();
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
