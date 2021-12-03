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
     * TODO: check winner before switch player
     *
     * @return void
     */
    public function switchPlayer(): void
    {
        $playerKey = $this->currentPlayer instanceof PlayerO ? PlayerX::class : PlayerO::class;

        $this->currentPlayer = $this->players[$playerKey];
    }

    /**
     *
     * @inheritDoc
     */
    public function hasWinner(): bool
    {
        $state = $this->board->state;

        if (count($state->unavailableFields) < $this->getMinimumFieldCountToWin(3)) {
            return false;
        }

        if (!$this->isRowWon($this->board->state->getRows()) {
            return false;
        }

        if (!$this->isRowWon($this->board->state->getColumns()) {
            return false;
        }

        return true;
    }

    /**
     *
     * @param \TicTacToe\Field[][] $fields
     * @return bool
     */
    private function isRowWon(array $fields): bool
    {
        foreach ($fields as $field) {
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
    private function getMinimumFieldCountToWin(int $length): int
    {
        return [
            3 => 5,
        ][$length];
    }
}
