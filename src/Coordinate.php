<?php

declare(strict_types=1);

namespace TicTacToe;

class Coordinate
{
  public function __construct(
    private int $_x,
    private int $_y,
    private ?string $_value = null,
  ) {
  }

  public function getX(): int
  {
    return $this->_x;
  }

  public function getY(): int
  {
    return $this->_y;
  }

  public function setValue(string $value): void
  {
    $this->_value = $value;
  }

  public function getValue(): ?string
  {
    return $this->_value;
  }
}
