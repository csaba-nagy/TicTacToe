<?php

declare(strict_types=1);

namespace TicTacToe\Strategies;

use TicTacToe\Contracts\Strategy;

class BaseStrategy implements Strategy
{
    protected array $fieldIndices = [];
    protected int $lineLength = DEFAULT_LINE_LENGTH;

    public function getLineLength(): int
    {
        return $this->lineLength;
    }

    public function setLineLength(int $value): void
    {
        $this->lineLength = $value;
    }

    public function setFieldIndices(array $data): void
    {
        $this->fieldIndices = $data;
    }

    public function getFields(): array
    {
        return $this->fieldIndices;
    }
}
