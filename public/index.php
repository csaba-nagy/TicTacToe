<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

if (DEV) {
    (new Whoops\Run())->pushHandler(new Whoops\Handler\PrettyPageHandler())->register();
}

try {
    $app = new TicTacToe\App();

    $app->run();
} catch (Throwable $th) {
    if (DEV) {
        throw $th;
    }

    echo $th->getMessage();
}
