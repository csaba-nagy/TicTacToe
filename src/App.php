<?php

declare(strict_types=1);

namespace TicTacToe;

use TicTacToe\Contracts\Symbolic;
use TicTacToe\Players\Player;
use TicTacToe\Strategies\DiagonalLeftStrategy;
use TicTacToe\Strategies\DiagonalRightStrategy;
use TicTacToe\Strategies\HorizontalStrategy;
use TicTacToe\Strategies\VerticalStrategy;

class App
{
    /** @var \TicTacToe\Contracts\Strategy[] $strategies */
    private array $strategies = [];

    public function __construct()
    {
        $this->setup();
    }

    /**
     * _Important: just for testing purposes._
     *
     * @return void
     */
    public function run(): void
    {
        /** @var int[][] $indices */
        $indices = [
            [0, 1, 2],
            [3, 4, 5],
            [6, 7, 8],
        ];

        $context = new Context();

        foreach ($this->strategies as $strategy) {
            $strategy->setFieldIndices($indices);
            $context->setStrategy($strategy)->updateFieldIndices();
        }

        $state = new State();

        $state->setFields([
            [null, null, null],
            [null, null, null],
            [null, null, null],
        ]);

        $board = new Board();

        $board->setState($state);

        $currentPlayer = new Player();
        $opponent = new Player();

        $currentPlayer->setSymbol(Symbolic::SIGN_CROSS);
        $opponent->setSymbol(Symbolic::SIGN_CIRCLE);

        ($game = new Game())
            ->setContext($context)
            ->setBoard($board)
            ->addPlayer($currentPlayer)
            ->addPlayer($opponent)
            ->setCurrentPlayer($currentPlayer);

        $game->move([0, 0]);
        $game->move([0, 2]);
        $game->move([1, 0]);
        $game->move([1, 2]);
        $game->move([2, 0]);
    }

    private function setup(): void
    {
        $this->setStrategies();
    }

    private function setStrategies(): void
    {
        $this->strategies = [
            new HorizontalStrategy(),
            new VerticalStrategy(),
            new DiagonalLeftStrategy(),
            new DiagonalRightStrategy(),
        ];
    }
}
