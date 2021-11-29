<?php

declare(strict_types=1);

namespace TicTacToe;

use Exception;

class Player
{
  public const X = '❌';

  public const O = '⭕';

  private Board $_board;
  private Game $_game;

  /**
   *
   * @param string $_sign
   * @return void
   */
  public function __construct(
    private string $_sign,
  ) {
  }

  /**
   *
   * @return bool
   */
  public function isX(): bool
  {
    return $this->_sign === self::X;
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
   * @param \TicTacToe\Board $board
   * @return void
   */
  public function setBoard(Board $board): void
  {
    $this->_board = $board;
  }

  /**
   *
   * @return string
   */
  public function getSign(): string
  {
    return $this->_sign;
  }

  /**
   *
   * @param \TicTacToe\Coordinate $coordinate
   * @return void
   * @throws \Exception
   */
  public function selectField(Coordinate $coordinate): void
  {
    if ($this->_game->isOver()) {
      throw new Exception(message: 'Game is over');
    }

    // Prevent cheating.
    if (!$this->_isCurrentPlayer()) {
      throw new Exception(message: 'It is not your turn');
    }

    $coordinate->setValue(value: $this->_sign);
    $this->_board->selectField(coordinate: $coordinate);
  }

  /**
   *
   * @return bool
   */
  private function _isCurrentPlayer(): bool
  {
    return $this->_game->getCurrentPlayer() === $this;
  }
}
