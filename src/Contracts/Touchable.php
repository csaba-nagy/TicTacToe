<?php

declare(strict_types=1);

namespace TicTacToe\Contracts;

use TicTacToe\Field;

interface Touchable
{
    /**
     *
     * @param \TicTactToe\Field $field
     * @return void
     */
    public function touch(Field $field): void;
}
