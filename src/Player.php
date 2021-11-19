<?php

declare(strict_types=1);

namespace TicTacToe;

class Player
{
  public const X = '❌';

  public const O = '⭕';

  private Board $_board;
  private Game $_game;

  public function __construct(
    private string $_sign,
  ) {
  }

  public function isX(): bool
  {
    return $this->_sign === self::X;
  }

  public function setGame(Game $game): void
  {
    $this->_game = $game;
  }

  public function setBoard(Board $board): void
  {
    $this->_board = $board;
  }

  public function getSign(): string
  {
    return $this->_sign;
  }

  public function selectField(Coordinate $coordinate): void
  {
    if ($this->_game->isOver()) {
      throw new \Exception(message: 'Game is over');
    }

    // Prevent cheating.
    if (!$this->_isCurrentPlayer()) {
      throw new \Exception(message: 'It is not your turn');
    }

    $coordinate->setValue(value: $this->_sign);
    $this->_board->selectField(coordinate: $coordinate);
  }

  private function _isCurrentPlayer(): bool
  {
    return $this->_game->getCurrentPlayer() === $this;
  }
}
