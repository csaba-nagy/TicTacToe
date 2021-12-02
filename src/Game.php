<?php

declare(strict_types=1);

namespace TicTacToe;

use TicTacToe\Contracts\Winnable;
use TicTacToe\Player\PlayerO;
use TicTacToe\Player\PlayerX;

class Game implements Winnable
{
    /**
     *
     * @param \TicTacToe\Player[] $players
     * @param \TicTacToe\Board $board
     */
    public function __construct(
        public array $players,
        public Board $board,
        public ?Player $currentPlayer = null,
    ) {
        $this->switchPlayer();
    }

    /**
     *
     * @return void
     */
    public function switchPlayer(): void
    {
        $playerKey = $this->currentPlayer instanceof PlayerX ? PlayerO::class : PlayerX::class;

        $this->currentPlayer = $this->players[$playerKey];
    }

    /**
     *
     * @inheritDoc
     */
    public function hasWinner(): bool
    {
        $state = $this->board->state;

        if (count($state->unavailableFields) < $this->getMinimumFieldsToWin(3)) {
            return false;
        }

        foreach ($this->board->state->getRows() as $field) {
            $values = [];

            foreach ($field as $value) {
                $values[] = $value->sign;
            }

            if (count(array_filter($values)) !== 3) {
                continue;
            }

            return array_unique($values)[0] === $this->currentPlayer->sign;
        }

        foreach ($this->board->state->getColumns() as $field) {
            $values = [];

            foreach ($field as $value) {
                $values[] = $value->sign;
            }

            if (count(array_filter($values)) !== 3) {
                continue;
            }

            return array_unique($values)[0] === $this->currentPlayer->sign;
        }

        return false;
    }

    /**
     *
     * @param int $length
     * @return int
     */
    private function getMinimumFieldsToWin(int $length): int
    {
        return [
            3 => 5,
        ][$length];
    }
}
