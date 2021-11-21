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
    public static function boardCreator(): array;
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
    public static function boardCreator($boardSize = SmallBoard::SIZE): array
    {
        $boardLayout = [];
        for ($xq = 0; $xq < $boardSize; $xq++) {
            array_push($boardLayout, []);
            for ($yq = 0; $yq < $boardSize; $yq++) {
                array_push($boardLayout[$xq], null);
            }
        }
        return $boardLayout;
    }
}

abstract class BaseBoard implements Renderable, Winnerable
{
    abstract public static function render(
        int $boardSize,
        SmallBoard $layout,
        int $columCount,
        int $rowCount
    ): string;
}

class Board extends BaseBoard
{
    public static function render(
        int $boardSize,
        SmallBoard $layout,
        int $columnCount = Board::DEFAULT_COLUMN_COUNT,
        int $rowCount = Board::DEFAULT_ROW_COUNT
    ): string {
        $result = "<div class=\"board\" style=\"--column-count: {$columnCount}; --row-count: {$rowCount}\">\n";

        $result .= $boardSize;
        $cells = SmallBoard::boardCreator($boardSize);
        $cellUnit = floor($rowCount / count($cells));
        $gridRowStart = 1;
        $gridColumnStart = 1;
        $gridRows = [];
        $gridColumns = [];

        foreach ($cells as $c => $cell) {
            array_push($gridRows, [$gridRowStart, $gridRowStart + ($cellUnit)]);
            $gridRowStart = $gridRowStart + $cellUnit;
        }

        foreach ($gridRows as $r => $row) {
            array_push($gridColumns, [$gridColumnStart, $gridColumnStart + $cellUnit]);
            $gridColumnStart = $gridColumnStart + $cellUnit;
        }


        foreach ($cells as $x => $cell) {
            foreach ($gridColumns as $y => $value) {
                [$rowStart, $rowEnd] = $gridRows[$x];
                [$columnStart, $columnEnd] = $gridColumns[$y];
                $gridArea = implode('/', [$rowStart, $columnStart, $rowEnd, $columnEnd]);
                $result .= "<div class=\"cell\" style=\"grid-area: {$gridArea}\"></div>";
            }
        }
        echo 'Rows: ' . count($gridRows);
        echo ' Columns: ' . count($gridColumns) . '<br>';
        echo 'Unit: ' . $cellUnit;

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
    <?php echo Board::render(
        12,
        new SmallBoard
    );  ?>
</body>

</html>