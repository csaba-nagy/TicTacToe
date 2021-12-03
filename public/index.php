<?php

declare(strict_types=1);

use TicTacToe\Board;
use TicTacToe\Container;
use TicTacToe\Field;
use TicTacToe\Game;
use TicTacToe\Player\PlayerO;
use TicTacToe\Player\PlayerX;
use TicTacToe\State;
use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;

require __DIR__ . '/../vendor/autoload.php';

(new Run())->pushHandler(new PrettyPageHandler())->register();

$container = Container::getInstance();

$container
    ->bind(State::class, fn () => new State([
        [new Field(0, 0), new Field(0, 1), new Field(0, 2)],
        [new Field(1, 0), new Field(1, 1), new Field(1, 2)],
        [new Field(2, 0), new Field(2, 1), new Field(2, 2)],
    ]))
    ->bind(Board::class, fn () => new Board($container->make(State::class)))
    ->bind(PlayerX::class, fn () => new PlayerX())
    ->bind(PlayerO::class, fn () => new PlayerO())
    ->bind(Game::class, fn () => new Game([
        PlayerX::class => $container->make(PlayerX::class),
        PlayerO::class => $container->make(PlayerO::class),
    ], $container->make(Board::class)));

/** @var \TicTacToe\Game $game */
$game = $container->make(Game::class);

$game->currentPlayer->move(0, 0);
$game->switchPlayer();
$game->currentPlayer->move(0, 1);
$game->switchPlayer();
$game->currentPlayer->move(1, 0);
$game->switchPlayer();
$game->currentPlayer->move(1, 1);
$game->switchPlayer();
$game->currentPlayer->move(2, 0);

dump($game->hasWinner(), $game);
