<?php

declare(strict_types=1);

namespace TicTacToe;

class Board
{
    /** @var (null|string)[] */
    public const BOARD_3_BY_3 = [
        [null, null, null],
        [null, null, null],
        [null, null, null],
    ];

    /**
     * @return void
     */
    public function __construct()
    {
        dump(self::BOARD_3_BY_3);
    }
}
