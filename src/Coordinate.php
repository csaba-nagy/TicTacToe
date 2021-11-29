<?php

declare(strict_types=1);

namespace TicTacToe;

class Coordinate
{
  /**
   *
   * @param int $_x
   * @param int $_y
   * @param null|string $_value
   * @return void
   */
  public function __construct(
    private int $_x,
    private int $_y,
    private ?string $_value = null,
  ) {
  }

  /**
   *
   * @return int
   */
  public function getX(): int
  {
    return $this->_x;
  }

  /**
   *
   * @return int
   */
  public function getY(): int
  {
    return $this->_y;
  }

  /**
   *
   * @param string $value
   * @return void
   */
  public function setValue(string $value): void
  {
    $this->_value = $value;
  }

  /**
   *
   * @return null|string
   */
  public function getValue(): ?string
  {
    return $this->_value;
  }
}
