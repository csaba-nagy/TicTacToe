<?php

declare(strict_types=1);

namespace TicTacToe\Players;

class Player extends BasePlayer
{
    /**
     *
     * @param int[] $coordinates
     * @return void
     */
    public function move(array $coordinates): void
    {
        [$rowIndex, $columnIndex] = $coordinates;
        $fields = $this->game->getBoard()->getState()->getFields();

        foreach (array_keys($fields) as $fieldRowIndex) {
            if ($fieldRowIndex !== $rowIndex) {
                continue;
            }

            $fields[$rowIndex][$columnIndex] = $this->symbol;
        }

        $this->game->getBoard()->getState()->setFields($fields);
    }
}
