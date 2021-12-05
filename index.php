<?php

declare(strict_types=1);
require __DIR__ . '/vendor/autoload.php';
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

    public static function isEquals(array $items, string $sign, int $length): bool
    {
        $filteredItems = array_filter(
            array: $items,
            callback: function ($item) use ($sign) {
                return $item === $sign;
            }
        );
        return count($filteredItems) === $length;
    }

    public static function hasWinner(array $board, string $sign, int $length = 3): bool
    {
        $elements = [
            'leftToRightDiagonal' => [],
            'rightToLeftDiagonal' => []
        ];
        // foreach ($board as $rowIndex => $cell) {
        //     $elements['rows'][] = $cell;
        //     foreach ($cell as $cellIndex => $value) {
        //         $elements['cols'][$cellIndex][] = $value;
        //         if ($rowIndex === $cellIndex) $elements['leftToRightDiagonal'][] = $value;
        //         if ($rowIndex + $cellIndex === $length - 1) $elements['rightToLeftDiagonal'][] = $value;
        //     }
        // }
        array_map(
            callback: function (array $row) use ($board, $elements, $length, $sign) {
                return array_map(
                    callback: function (int $rowIndex) use ($board, $row, $length, $elements, $sign) {
                        $elements['leftToRightDiagonal'][] = $row[$rowIndex];
                        $elements['rightToLeftDiagonal'][] = $row[$length - 1 - $rowIndex];

                        // check horizontally
                        if (Board::isEquals($row, $sign, $length)) return true;

                        // check vertically
                        $column = array_map(
                            callback: function ($columnIndex) use ($board, $rowIndex) {
                                return $board[$rowIndex][$columnIndex];
                            },
                            array: $row
                        );

                        if (Board::isEquals($column, $sign, $length)) return true;

                        return false;
                    },
                    array: array_keys($row)
                );
            },
            array: $board
        );
        print_r($elements);
        if (Board::isEquals($elements['leftToRightDiagonal'], 'X', 3)) {
            return true;
        } else if (Board::isEquals($elements['rightToLeftDiagonal'], 'X', 3)) {
            return  true;
        } else {
            return false;
        }
    }

    /**
     * 
     * @param string[][] $items 
     * @return bool 
     */
    public static function _hasWinner(array $items, string $sign, int $length = 3): bool
    {
        // TODO: 2. move to class - [$this, 'hasTrue']
        $hasTrue = fn (bool $item) => $item === true;

        $hasRowWinner = array_filter(
            array_map(
                fn (array $item) => self::isEquals($item, $sign, $length),
                $items
            ),
            $hasTrue
        );
        
        if ($hasRowWinner) {
            return true;
        }

        $hasColumnWinner = array_filter(
            array_map(
                fn (int $rowIndex) => self::isEquals(array_map(fn (array $row) => $row[$rowIndex], $items), $sign, $length),
                array_keys($items)
            ),
            $hasTrue
        );
        
        if ($hasColumnWinner) {
            return true;
        }
        
        // TODO: 1: create diagonal logic
        // $diagonal = [];
        // map array items, check rows and columns (column pairs: 0-2, 1-1, 2-0)
        $hasDiagonalWinner = false;

        // dd(array_filter($columnItems, $hasTrue), $items);

        return $hasDiagonalWinner;
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
// $board = [
//     ['X', '01', '02'],
//     ['10', 'X', '12'],
//     ['20', '21', 'X'],
// ];
// echo Board::hasWinner($board, 'X', 3);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <title>TicTacToe</title>
</head>

<body>
    <!-- <?php echo Board::render(
                12,
                new SmallBoard
            );  ?> -->
    <?php
    // echo Board::hasWinner($board = [
    //     ['X', '01', '02'],
    //     ['10', 'X', '12'],
    //     ['20', '21', 'X'],
    // ], 'X', 3);
    Board::_hasWinner([
        ['X', 'O', 'X'],
        ['O', 'O', 'O'],
        ['O', 'O', 'O']
    ], 'O');
    ?>
</body>

</html>
