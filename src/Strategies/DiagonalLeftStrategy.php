<?php

declare(strict_types=1);

namespace TicTacToe\Strategies;

class DiagonalLeftStrategy extends DiagonalStrategy
{
    public function getFields(): array
    {
        return $this->getDiagonalLeft($this->fieldIndices);
    }
}
