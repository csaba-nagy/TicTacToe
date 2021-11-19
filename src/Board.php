<?php

declare(strict_types=1);

namespace TicTacToe;

class Board
{
  public const ROW_COUNT = 3;

  public const COLUMN_COUNT = 3;

  public const GRID_BASE = 12;

  private Game $_game;

  public static function generateGridParameters(
    int $itemCount,
    int $gridBase = Board::GRID_BASE,
  ): array {
    $items = [];
    $delta = (int) ($gridBase / $itemCount);

    for ($rowIndex = 0; $rowIndex < $itemCount; $rowIndex++) {
      $items[] = [$rowIndex * $delta + 1, $rowIndex * $delta + 1 + $delta];
    }

    return $items;
  }

  public static function generateCoordinates(
    int $rowCount = Board::ROW_COUNT,
    int $columnCount = Board::COLUMN_COUNT,
  ): array {
    if ($rowCount < static::ROW_COUNT || $columnCount < static::COLUMN_COUNT) {
      throw new \InvalidArgumentException(message: 'Invalid board size');
    }

    $coordinates = [];

    for ($rowIndex = 0; $rowIndex < $rowCount; $rowIndex++) {
      $coordinates[$rowIndex] = [];

      for ($columnIndex = 0; $columnIndex < $columnCount; $columnIndex++) {
        $coordinates[$rowIndex][] = new Coordinate(_x: $rowIndex, _y: $columnIndex);
      }
    }

    return $coordinates;
  }

  /**
   *
   * @param \TicTacToe\Coordinate[][] $_coordinates
   * @return never
   */
  public function __construct(
    private array $_coordinates = [],
    private int $_rowCount = Board::ROW_COUNT,
    private int $_columnCount = Board::COLUMN_COUNT,
    private int $_gridBase = Board::GRID_BASE,
  ) {
  }

  public function getRowCount(): int
  {
    return $this->_rowCount;
  }

  public function getColumnCount(): int
  {
    return $this->_columnCount;
  }

  public function setRowCount(int $value): void
  {
    $this->_rowCount = $value;
  }

  public function setColumnCount(int $value): void
  {
    $this->_columnCount = $value;
  }

  public function setGridBase(int $value): void
  {
    $this->_gridBase = $value;
  }

  public function setGame(Game $game): void
  {
    $this->_game = $game;
  }

  public function getCoordinates(): array
  {
    return $this->_coordinates;
  }

  public function selectField(Coordinate $coordinate): void
  {
    $currentPlayer = $this->_game->getCurrentPlayer();

    $this->_coordinates[$coordinate->getX()][$coordinate->getY()]
      ->setValue(value: $currentPlayer->getSign());

    if ($this->_game->checkWinner(player: $currentPlayer)) {
      $this->_game->setWinner(player: $currentPlayer);

      return;
    }

    $this->_game->switchPlayer();
  }

  public function render(): string
  {
    $result = <<<BOARD
      <div
        class="board"
        style="--column-count: {$this->_gridBase}; --row-count: {$this->_gridBase}"
      >
    BOARD;

    $gridRows = static::generateGridParameters(
      itemCount: $this->_rowCount,
      gridBase: $this->_gridBase,
    );

    $gridColumns = static::generateGridParameters(
      itemCount: $this->_columnCount,
      gridBase: $this->_gridBase,
    );

    foreach ($this->_coordinates as $rowIndex => $row) {
      foreach ($row as $columnIndex => $coordinate) {
        $gridArea = implode(
          separator: '/',
          array: [
            $gridRows[$rowIndex][0],
            $gridColumns[$columnIndex][0],
            $gridRows[$rowIndex][1],
            $gridColumns[$columnIndex][1],
          ],
        );

        $result .= <<<FIELD
          <div class="field" style="grid-area: {$gridArea}">
            {$coordinate->getValue()}
          </div>
        FIELD;
      }
    }

    return <<<BOARD
        {$result}
      </div>
    BOARD;
  }
}
