<?php

declare(strict_types=1);

namespace TicTacToe\Contracts;

interface Symbolic
{
    public const SIGN_CIRCLE = '⭕';
    public const SIGN_CROSS = '❌';
    public const SIGN_EMPTY = null;

    public function setSymbol(string $symbol): void;

    public function getSymbol(): string;
}
