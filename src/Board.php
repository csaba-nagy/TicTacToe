<?php

declare(strict_types=1);

namespace TicTacToe;

use InvalidArgumentException;

class Board
{
  public const ROW_COUNT = 3;

  public const COLUMN_COUNT = 3;

  public const GRID_BASE = 12;

  private Game $_game;

  /**
   *
   * @param int $itemCount
   * @param int $gridBase
   * @return int[][]
   */
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

  /**
   *
   * @param int $rowCount
   * @param int $columnCount
   * @return \TicTacToe\Coordinate[][]
   * @throws \InvalidArgumentException
   */
  public static function generateCoordinates(
    int $rowCount = Board::ROW_COUNT,
    int $columnCount = Board::COLUMN_COUNT,
  ): array {
    if ($rowCount < static::ROW_COUNT || $columnCount < static::COLUMN_COUNT) {
      throw new InvalidArgumentException(message: 'Invalid board size');
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
   * @param int $_rowCount
   * @param int $_columnCount
   * @param int $_gridBase
   * @return void 
   */
  public function __construct(
    private array $_coordinates = [],
    private int $_rowCount = Board::ROW_COUNT,
    private int $_columnCount = Board::COLUMN_COUNT,
    private int $_gridBase = Board::GRID_BASE,
  ) {
  }

  /**
   *
   * @return int
   */
  public function getRowCount(): int
  {
    return $this->_rowCount;
  }

  /**
   *
   * @return int
   */
  public function getColumnCount(): int
  {
    return $this->_columnCount;
  }

  /**
   *
   * @param int $value
   * @return void
   */
  public function setRowCount(int $value): void
  {
    $this->_rowCount = $value;
  }

  /**
   *
   * @param int $value
   * @return void
   */
  public function setColumnCount(int $value): void
  {
    $this->_columnCount = $value;
  }

  /**
   *
   * @param int $value
   * @return void
   */
  public function setGridBase(int $value): void
  {
    $this->_gridBase = $value;
  }

  /**
   *
   * @param \TicTacToe\Game $game
   * @return void
   */
  public function setGame(Game $game): void
  {
    $this->_game = $game;
  }

  /**
   *
   * @param null|int $x
   * @param null|int $y
   * @return \TicTacToe\Coordinate[][]
   */
  public function getCoordinates(): array
  {
    return $this->_coordinates;
  }

  /**
   *
   * @param \TicTacToe\Coordinate $coordinate
   * @return void
   */
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

  /**
   *
   * @return string
   */
  public function render(): string
  {
    $result = '<div class="board">';

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

    return $result . '</div>';
  }
}
