<?php

declare(strict_types=1);

namespace TicTacToe;

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

        $strategyFields = [
            HorizontalStrategy::class => [
                ['❌', '❌', '❌'],
                [null, null, null],
                [null, null, null],
            ],
            VerticalStrategy::class => [
                ['❌', null, null],
                ['❌', null, null],
                ['❌', null, null],
            ],
            DiagonalLeftStrategy::class => [
                ['❌', null, null],
                [null, '❌', null],
                [null, null, '❌'],
            ],
            DiagonalRightStrategy::class => [
                [null, null, '❌'],
                [null, '❌', null],
                ['❌', null, null],
            ],
        ];

        $context = new Context();
        $state = new State();

        foreach ($this->strategies as $strategy) {
            /**
             * Strategy's line length can be changed, but default is DEFAULT_LINE_LENGTH - is 3.
             *
             * $strategy->setLineLength(4);
             */
            $strategy->setFieldIndices($indices);
            $context->setStrategy($strategy)->updateFieldIndices();
        }

        foreach ($strategyFields as $strategyName => $fields) {
            $state->setFields($fields);
            $context->setState($state);

            dump([$strategyName => $context->hasWinner('❌')]);
        }
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
