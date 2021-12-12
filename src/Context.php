<?php

declare(strict_types=1);

namespace TicTacToe;

use TicTacToe\Contracts\Strategy;

class Context
{
    public array $fieldIndices;

    private Strategy $strategy;
    private State $state;

    public function setStrategy(Strategy $strategy): self
    {
        $this->strategy = $strategy;

        return $this;
    }

    public function setState(State $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function updateFieldIndices(): void
    {
        $this->fieldIndices[$this->strategy::class] = array_reduce(
            $this->strategy->getFields(),
            fn (array $result, array $item) => [...$result, $item],
            [],
        );
    }

    public function hasWinner(string $symbol): bool
    {
        /**
         * Filter out only given symbol and check items count is equal to line length.
         * If so, then there is a winner.
         */
        $items = array_map(
            fn (array $item) => count($item) === $this->strategy->getLineLength(),
            array_map(
                fn (array $item) => array_filter(
                    array_map(
                        fn (string|null $item) => flatData($this->state->getFields())[$item],
                        $item,
                    ),
                    fn (string|null $item) => $item === $symbol,
                ),
                $this->fieldIndices[$this->strategy::class],
            ),
        );

        foreach ($items as $item) {
            if ($item === 0) {
                continue;
            }

            return true;
        }

        return false;
    }
}
