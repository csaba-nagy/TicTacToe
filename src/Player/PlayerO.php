<?php

declare(strict_types=1);

namespace TicTacToe\Player;

use TicTacToe\Player;

class PlayerO extends Player
{
    /**
     *
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct(self::SIGN_O);
    }
}
