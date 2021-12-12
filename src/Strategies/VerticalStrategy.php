<?php

declare(strict_types=1);

namespace TicTacToe\Strategies;

class VerticalStrategy extends BaseStrategy
{
    public function getFields(): array
    {
        return transposeData($this->fieldIndices);
    }
}
