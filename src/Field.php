<?php

declare(strict_types=1);

namespace TicTacToe;

class Field
{
    /**
     *
     * @param int $x
     * @param int $y
     * @param null|string $sign
     * @return void
     */
    public function __construct(
        public int $x,
        public int $y,
        public ?string $sign = null,
    ) {
    }
}
