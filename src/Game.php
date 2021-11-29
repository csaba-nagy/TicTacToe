<?php

declare(strict_types=1);

namespace TicTacToe;

use Exception;
use InvalidArgumentException;

class Game
{
  public const DEFAULT_LINE_LENGTH = 3;

  private ?Player $_currentPlayer = null;
  private Board $_board;
  private ?Player $_winner = null;

  /**
   *
   * @param int $rowCount
   * @param int $columnCount
   * @param int $gridBase
   * @param int $lineLength
   * @return static
   * @throws \InvalidArgumentException
   */
  public static function setup(
    int $rowCount = Board::ROW_COUNT,
    int $columnCount = Board::COLUMN_COUNT,
    int $gridBase = Board::GRID_BASE,
    int $lineLength = Game::DEFAULT_LINE_LENGTH,
  ): static {
    $board = new Board(
      _coordinates: Board::generateCoordinates(
        rowCount: $rowCount,
        columnCount: $columnCount,
      ),
      _gridBase: $gridBase,
    );

    $playerO = new Player(_sign: Player::O);
    $playerX = new Player(_sign: Player::X);

    $playerO->setBoard(board: $board);
    $playerX->setBoard(board: $board);

    $game = new static(_playerX: $playerX, _playerO: $playerO);

    $game->setBoard(board: $board);
    $game->setLineLength(value: $lineLength);

    $playerO->setGame(game: $game);
    $playerX->setGame(game: $game);

    return $game;
  }

  /**
   *
   * @param null|\TicTacToe\Player $_playerX
   * @param null|\TicTacToe\Player $_playerO
   * @param int $_lineLength
   * @return void
   */
  public function __construct(
    private ?Player $_playerX = null,
    private ?Player $_playerO = null,
    private int $_lineLength = Game::DEFAULT_LINE_LENGTH,
  ) {
    // Always 'X' starts the game.
    $this->_currentPlayer = $_playerX;
  }

  /**
   *
   * @param int $value
   * @return void
   * @throws \InvalidArgumentException
   */
  public function setLineLength(int $value): void
  {
    if ($value < Game::DEFAULT_LINE_LENGTH) {
      throw new InvalidArgumentException(
        message: 'Line length must be at least ' . Game::DEFAULT_LINE_LENGTH . '.',
      );
    }

    if ($value > $this->_board->getRowCount() || $value > $this->_board->getColumnCount()) {
      throw new InvalidArgumentException(
        message: 'Line length must be at least as large as the board.',
      );
    }

    $this->_lineLength = $value;
  }

  /**
   *
   * @return null|\TicTacToe\Player
   */
  public function getPlayerX(): ?Player
  {
    return $this->_playerX;
  }

  /**
   *
   * @return null|\TicTacToe\Player
   */
  public function getPlayerO(): ?Player
  {
    return $this->_playerO;
  }

  /**
   *
   * @return bool
   */
  public function isOver(): bool
  {
    return $this->_winner !== null;
  }

  public function getWinner(): ?Player
  {
    return $this->_winner;
  }

  /**
   *
   * @param \TicTacToe\Board $board
   * @return void
   */
  public function setBoard(Board $board): void
  {
    $board->setGame(game: $this);

    $this->_board = $board;
  }

  /**
   *
   * @return void
   */
  public function play(): void
  {
    /**
     * The game can be played. Check game status before playing.
     */
    if ($this->isOver()) {
      echo "<h3>The winner is {$this->getWinner()->getSign()}</h3>";
    }

    echo $this->_board->render();
  }

  /**
   *
   * @return \TicTacToe\Player
   */
  public function getCurrentPlayer(): Player
  {
    return $this->_currentPlayer;
  }

  /**
   *
   * @return void
   */
  public function switchPlayer(): void
  {
    $this->_currentPlayer = $this->_currentPlayer->isX() ? $this->_playerO : $this->_playerX;
  }

  /**
   *
   * @param \TicTacToe\Player $player
   * @return void
   */
  public function setWinner(Player $player): void
  {
    $this->_winner = $player;
  }

  /**
   *
   * @param \TicTacToe\Player $player
   * @return bool
   */
  public function checkWinner(Player $player): bool
  {
    $left = [];
    $right = [];
    $isCurrentPlayer = $this->_currentPlayer === $player;

    /**
     * Example grid: 3×3
     *
     * 0,0 | 0,1 | 0,2
     * 1,0 | 1,1 | 1,2
     * 2,0 | 2,1 | 2,2
     */
    foreach ($this->_board->getCoordinates() as $x => $row) {
      if ($this->_areCoordinatesEqual(coordinates: $row)) {
        return $isCurrentPlayer; // 0,0 | 0,1 | 0,2 => from left to right horizontally
      }

      $column = array_map(
        callback: fn (int $y) => $this->_board->getCoordinates()[$y][$x],
        array: array_keys(array: $row),
      );

      if ($this->_areCoordinatesEqual(coordinates: $column)) {
        return $isCurrentPlayer; // 0,0 | 1,0 | 2,0 => from top to bottom vertically
      }

      $left[] = $row[$x];
      $right[] = $row[$this->_board->getColumnCount() - $x - 1];
    }

    if ($this->_areCoordinatesEqual(coordinates: $left)) {
      return $isCurrentPlayer; // 0,0 | 1,1 | 2,2 => from top left to bottom right diagonally
    }

    if ($this->_areCoordinatesEqual(coordinates: $right)) {
      return $isCurrentPlayer; // 0,2 | 1,1 | 2,0 => from top right to bottom left diagonally
    }

    return false;
  }

  /**
   *
   * @param array $history
   * @return void
   * @throws \Exception
   */
  public function addHistory(array $history): void
  {
    foreach ($history as ['player' => $player, 'coordinates' => $coordinates]) {
      $this->addHistoryItem($player, $coordinates);
    }
  }

  /**
   *
   * @param \TicTacToe\Player $player
   * @param int[] $coordinates
   * @return void
   * @throws \Exception
   */
  public function addHistoryItem(Player $player, array $coordinates): void
  {
    $player->selectField(coordinate: new Coordinate(_x: $coordinates[0], _y: $coordinates[1]));
  }

  /**
   *
   * @param (string|null)[] $coordinates
   * @return bool
   */
  private function _areValuesEqualWithLength(array $coordinates): bool
  {
    $items = array_filter(array: $coordinates);

    return count(value: $items) === $this->_lineLength
      && count(value: array_unique(array: $items)) === 1;
  }

  /**
   *
   * @param \TicTacToe\Coordinate[] $coordinates
   * @return (string|null)[]
   */
  private function _mapCoordinateValues(array $coordinates): array
  {
    return array_map(fn (Coordinate $coordinates) => $coordinates->getValue(), $coordinates);
  }

  /**
   *
   * @param \TicTacToe\Coordinate[] $coordinates
   * @return bool
   */
  private function _areCoordinatesEqual(array $coordinates): bool
  {
    return $this->_areValuesEqualWithLength(
      coordinates: $this->_mapCoordinateValues(coordinates: $coordinates),
    );
  }
}
