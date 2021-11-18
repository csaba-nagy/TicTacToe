<?php

declare(strict_types=1);

interface Renderable
{
    public const DEFAULT_CELL_COUNT = 9;
    public const DEFAULT_COLUMN_COUNT = 12;
    public const DEFAULT_ROW_COUNT = 12;
}

interface Winnerable
{
    public static function checkWinner(
        array $cells,
        Player $player
    ): bool;
}

interface BoardLayout
{
}

class Player
{
    public $sign;

    public function __construct(string $sign)
    {
        $this->sign = $sign;
    }
}

class PlayerX extends Player
{
    public function __construct(string $sign = 'X')
    {
        parent::__construct($sign);
    }
}

class PlayerO extends Player
{
    public function __construct(string $sign = 'O')
    {
        parent::__construct($sign);
    }
}

class SmallBoard implements BoardLayout
{
    public const SIZE = 3;
}

abstract class BaseBoard implements Renderable, Winnerable
{
    abstract public static function render(
        array $cells,
        SmallBoard $layout,
        int $columCount,
        int $rowCount
    ): string;
}

class Board extends BaseBoard
{
    public static function render(
        array $cells,
        SmallBoard $layout,
        int $columnCount = Board::DEFAULT_COLUMN_COUNT,
        int $rowCount = Board::DEFAULT_ROW_COUNT
    ): string {
        $result = "<div class=\"board\" style=\"--column-count: {$columnCount}; --row-count: {$rowCount}\">\n";

        $result .= $layout::SIZE;

        $cellUnit = $rowCount / count($cells);
        $gridStart = 1;

        $gridRows = [
            [$gridStart, $gridStart + $cellUnit],
            [$gridStart + $cellUnit, $gridStart + ($cellUnit * 2)],
            [$gridStart + ($cellUnit * 2), $gridStart + ($cellUnit * 3)]
        ];

        $gridColumns = [
            [$gridStart, $gridStart + $cellUnit],
            [$gridStart + $cellUnit, $gridStart + ($cellUnit * 2)],
            [$gridStart + ($cellUnit * 2), $gridStart + ($cellUnit * 3)]
        ];

        foreach ($cells as $x => $cell) {
            foreach ($gridColumns as $y => $value) {
                [$rowStart, $rowEnd] = $gridRows[$x];
                [$columnStart, $columnEnd] = $gridColumns[$y];
                $gridArea = implode('/', [$rowStart, $columnStart, $rowEnd, $columnEnd]);
                $result .= "<div class=\"cell\" style=\"grid-area: {$gridArea}\"></div>";
            }
        }

        return $result . "</div>\n";
    }

    public static function checkWinner(
        array $cells,
        Player $player
    ): bool {
        // Logic ...

        return true;
    }
}

// echo 'The winner is ' . Board::checkWinner([], new PlayerX) ? 'X' ? 'O';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>TicTacToe</title>
</head>

<body>
    <?php echo Board::render([
        [null, null, null],
        [null, null, null],
        [null, null, null]
    ], new SmallBoard); ?>
</body>

</html>