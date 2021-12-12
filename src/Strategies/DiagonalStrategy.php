<?php

declare(strict_types=1);

namespace TicTacToe\Strategies;

class DiagonalStrategy extends BaseStrategy
{
    /**
     * Get field value for current strategy. Returns diagonal values from top left to bottom right.
     *
     * Create chunks from fields array and get each (line length + 1)th element,
     * which are diagonal values from top left to bottom right. This is the way
     * to get diagonal values from top left to bottom right.
     *
     *
     * @param array $fields
     * @return array
     * @example -
     *
     * ```php
     * [0,1,2] => [\,1,/]
     * [3,4,5] => [3,X,5]
     * [6,7,8] => [/,7,\]
     *
     * flatten => [ \, 1, /, 3,   X, 5, /, 7,   \ ];
     * chunked => [[\, 1, /, 3], [X, 5, /, 7], [\]]];
     * shifted => [ \,            \,            \ ];
     * ```
     */
    protected function getDiagonalLeft(array $fields): array
    {
        $result = array_map(
            fn (array $item) => array_shift($item),
            array_chunk(flatData($fields), $this->getLineLength() + 1),
        );

        return isDataAssociative($result) ? $result : [$result];
    }
}
