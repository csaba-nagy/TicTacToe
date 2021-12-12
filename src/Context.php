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

    public function hasStateFieldsMinimumCount(): bool
    {
        $minimumSteps = $this->state->getMinimumStepsForLineLength(
            $this->strategy->getLineLength(),
        );

        return count(array_filter(flatData($this->state->getFields()))) >= $minimumSteps;
    }

    /**
     * In ideal case, we need to populate the `$this->fieldIndices` array with once. But in case of
     * a draw, we need to populate it more times, because of line length will grows by two.
     *
     * @return void
     */
    public function updateFieldIndices(): void
    {
        $this->fieldIndices[$this->strategy::class] = array_reduce(
            $this->strategy->getFields(),
            fn (array $result, array $item) => [...$result, $item],
            [],
        );
    }

    public function hasIdenticalSymbolsInARowAs(string $symbol): bool
    {
        /**
         * Prevent unnecessary performative calculations.
         */
        if (!$this->hasStateFieldsMinimumCount()) {
            return false;
        }

        foreach ($this->getItemsForSymbol($symbol) as $item) {
            if ($item === 0) {
                continue;
            }

            return true;
        }

        return false;
    }

    /**
     * Filter out only given symbol and check items count is equal to line length. If so,
     * then there is a winner.
     *
     * @param string $symbol
     * @return array
     */
    private function getItemsForSymbol(string $symbol): array
    {
        return array_map(
            fn (array $item) => count($item) === $this->strategy->getLineLength(),
            array_map(
                fn (array $item) => array_filter(
                    array_map(
                        fn (?string $item) => flatData($this->state->getFields())[$item],
                        $item,
                    ),
                    fn (?string $item) => $item === $symbol,
                ),
                $this->fieldIndices[$this->strategy::class],
            ),
        );
    }
}
