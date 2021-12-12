<?php

declare(strict_types=1);

namespace TicTacToe\Contracts;

interface Strategy
{
    /**
     * Get fields for current strategy.
     *
     * @return array
     */
    public function getFields(): array;

    public function setFieldIndices(array $data): void;

    public function getLineLength(): int;

    /**
     * Set line length for current strategy in runtime.
     *
     * @param int $value
     * @return void
     */
    public function setLineLength(int $value): void;
}
