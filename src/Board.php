<?php

declare(strict_types=1);

namespace TicTacToe;

class Board
{
    /**
     *
     * @param \TicTacToe\State $state
     * @return void
     */
    public function __construct(
        public State $state,
    ) {
    }

    public function touch(Field $field): void
    {
        /** @var \TicTacToe\Game $game */
        $game = Container::getInstance()->make(Game::class);

        foreach ($this->state->fields as $fields) {
            foreach ($fields as $_field) {
                if ($field->x !== $_field->x) {
                    continue;
                }

                if ($field->y !== $_field->y) {
                    continue;
                }

                $_field->sign = $game->currentPlayer->sign;
            }
        }

        $this->state->updateFields();
    }
}
