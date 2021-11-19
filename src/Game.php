<?php

declare(strict_types=1);

namespace TicTacToe;

class Game
{
  public const DEFAULT_LINE_LENGTH = 3;

  private ?Player $_currentPlayer = null;
  private Board $_board;
  private ?Player $_winner = null;

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

    $game->setLineLength($lineLength);
    $game->setBoard(board: $board);

    $playerO->setGame(game: $game);
    $playerX->setGame(game: $game);

    return $game;
  }

  public function __construct(
    private ?Player $_playerX = null,
    private ?Player $_playerO = null,
    private int $_lineLength = Game::DEFAULT_LINE_LENGTH,
  ) {
    // Always 'X' starts the game.
    $this->_currentPlayer = $_playerX;
  }

  public function setLineLength(int $value): void
  {
    if ($value < Game::DEFAULT_LINE_LENGTH) {
      throw new \InvalidArgumentException(
        message: 'Line length must be at least ' . Game::DEFAULT_LINE_LENGTH . '.',
      );
    }

    if ($value > $this->_board->getRowCount() || $value > $this->_board->getColumnCount()) {
      throw new \InvalidArgumentException(
        message: 'Line length must be at least as large as the board.',
      );
    }

    $this->_lineLength = $value;
  }

  public function getPlayerX(): ?Player
  {
    return $this->_playerX;
  }

  public function getPlayerO(): ?Player
  {
    return $this->_playerO;
  }

  public function isOver(): bool
  {
    return $this->_winner !== null;
  }

  public function getWinner(): ?Player
  {
    return $this->_winner;
  }

  public function setBoard(Board $board): void
  {
    $board->setGame(game: $this);

    $this->_board = $board;
  }

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

  public function getCurrentPlayer(): Player
  {
    return $this->_currentPlayer;
  }

  public function switchPlayer(): void
  {
    $this->_currentPlayer = $this->_currentPlayer->isX() ? $this->_playerO : $this->_playerX;
  }

  public function setWinner(Player $player): void
  {
    $this->_winner = $player;
  }

  public function checkWinner(Player $player): bool
  {
    $diagonal = [
      'left' => [],
      'right' => [],
    ];

    foreach ($this->_board->getCoordinates() as $x => $row) {
      if ($this->_isEqualValues(coordinates: $this->_mapCoordinateValues(coordinates: $row))) {
        return $this->_currentPlayer === $player;
      }

      $vertical = [];

      foreach ($row as $y => $coordinate) {
        $vertical[] = $this->_board->getCoordinates()[$y][$x];
      }

      if ($this->_isEqualValues(coordinates: $this->_mapCoordinateValues(coordinates: $vertical))) {
        return $this->_currentPlayer === $player;
      }

      $diagonal['left'][] = $row[$x];
      $diagonal['right'][] = $row[$this->_board->getColumnCount() - $x - 1];
    }

    ['left' => $left, 'right' => $right] = $diagonal;

    if ($this->_isEqualValues(coordinates: $this->_mapCoordinateValues(coordinates: $left))) {
      return $this->_currentPlayer === $player;
    }

    if ($this->_isEqualValues(coordinates: $this->_mapCoordinateValues(coordinates: $right))) {
      return $this->_currentPlayer === $player;
    }

    return false;
  }

  public function addHistory(array $history): void
  {
    foreach ($history as ['player' => $player, 'coordinates' => $coordinates]) {
      $this->addHistoryItem($player, $coordinates);
    }
  }

  public function addHistoryItem(Player $player, array $coordinates): void
  {
    $player->selectField(coordinate: new Coordinate(_x: $coordinates[0], _y: $coordinates[1]));
  }

  private function _isEqualValues(array $coordinates): bool
  {
    $items = array_filter(array: $coordinates);

    return count(value: $items) === $this->_lineLength
      && count(value: array_unique(array: $items)) === 1;
  }

  private function _mapCoordinateValues(array $coordinates): array
  {
    return array_map(fn (Coordinate $coordinates) => $coordinates->getValue(), $coordinates);
  }
}
