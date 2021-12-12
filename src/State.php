<?php

declare(strict_types=1);

namespace TicTacToe;

class State
{
    /** @var (string|null)[][] */
    private array $fields;

    /** @var int[] */
    private array $stepsCountMap = [3 => 5];

    public function getFields(): array
    {
        return $this->fields;
    }

    public function setFields(array $fields): void
    {
        $this->fields = $fields;
    }

    public function getMinimumStepsForLineLength(int $lineLength): int
    {
        return $this->stepsCountMap[$lineLength] ?? DEFAULT_LINE_LENGTH;
    }
}
