<?php

declare(strict_types=1);

namespace TicTacToe\Strategies;

class DiagonalRightStrategy extends DiagonalStrategy
{
    public function getFields(): array
    {
        return $this->getDiagonalLeft(transposeData($this->fieldIndices));
    }
}
