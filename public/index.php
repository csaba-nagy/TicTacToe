<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

if (DEV) {
    (new Whoops\Run())->pushHandler(new Whoops\Handler\PrettyPageHandler())->register();
}

try {
    (new TicTacToe\App())->run();
} catch (Throwable $error) {
    if (DEV) {
        throw $error;
    }

    echo $error->getMessage();
}
