<?php

declare(strict_types=1);

namespace TicTacToe;

class State
{
    /**
     *
     * @param \TicTacToe\Field[][] $fields
     * @param \TicTacToe\Field[] $availableFields
     * @param \TicTacToe\Field[] $unavailableFields
     * @return void
     */
    public function __construct(
        public array $fields,
        public array $availableFields = [],
        public array $unavailableFields = [],
    ) {
    }

    /**
     *
     * @return void
     */
    public function updateFields(): void
    {
        $this->availableFields = [];
        $this->unavailableFields = [];

        foreach ($this->flatFields() as $field) {
            $this->{$field->sign ? 'unavailableFields' : 'availableFields'}[] = $field;
        }
    }

    /**
     *
     * @return \TicTacToe\Field[][]
     */
    public function getRows(): array
    {
        return $this->fields;
    }

    /**
     *
     * @return \TicTacToe\Field[][]
     */
    public function getColumns(): array
    {
        $result = [];

        foreach ($this->fields as $row => $fields) {
            foreach ($fields as $column => $value) {
                $result[$column][$row] = $value;
            }
        }

        return $result;
    }

    /**
     *
     * @return \TicTacToe\Field[]
     */
    private function flatFields(): array
    {
        $result = [];

        foreach ($this->fields as $row) {
            foreach ($row as $field) {
                $result[] = $field;
            }
        }

        return $result;
    }
}
