<?php

declare(strict_types=1);

namespace TicTacToe;

class State
{
    /** @var (string|null)[][] */
    private array $fields;

    public function getFields(): array
    {
        return $this->fields;
    }

    public function setFields(array $fields): void
    {
        $this->fields = $fields;
    }
}
