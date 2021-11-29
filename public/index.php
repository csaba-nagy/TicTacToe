<?php

use TicTacToe\Board;
use TicTacToe\Game;

require_once __DIR__ . '/../vendor/autoload.php';

(new Whoops\Run)->pushHandler(handler: new Whoops\Handler\PrettyPageHandler)->register();

/**
 * Game can be configured to use a specific board and line length.
 */
$game = Game::setup(
  rowCount: Board::ROW_COUNT,
  columnCount: Board::COLUMN_COUNT,
  gridBase: Board::GRID_BASE,
  lineLength: Game::DEFAULT_LINE_LENGTH,
);

/**
 *
 * Here can add previous moves to the game.
 */
$game->addHistory(history: [
  ['player' => $game->getPlayerX(), 'coordinates' => [0, 0]],
  ['player' => $game->getPlayerO(), 'coordinates' => [2, 2]],
  ['player' => $game->getPlayerX(), 'coordinates' => [1, 0]],
  ['player' => $game->getPlayerO(), 'coordinates' => [2, 1]],
]);

/**
 * Individual moves can be added to the game.
 */
$game->addHistoryItem($game->getPlayerX(), [2, 0]);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tic Tac Toe</title>
  <link rel="stylesheet" href="./styles/main.css">
</head>

<body>
  <div class="game">
    <?php $game->play() ?>
  </div>
</body>

</html>