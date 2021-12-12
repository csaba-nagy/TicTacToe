<?php

declare(strict_types=1);

namespace TicTacToe\Strategies;

use TicTacToe\Contracts\Strategy;

class BaseStrategy implements Strategy
{
    protected array $fields = [];
    protected int $lineLength = DEFAULT_LINE_LENGTH;

    public function getLineLength(): int
    {
        return $this->lineLength;
    }

    public function setLineLength(int $value): void
    {
        $this->lineLength = $value;
    }

    public function setFields(array $data): void
    {
        $this->fields = $data;
    }

    public function getFields(): array
    {
        return $this->fields;
    }
}
