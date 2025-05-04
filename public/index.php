<?php

declare(strict_types=1);

use App\Game;

require_once __DIR__ . '/../vendor/autoload.php';

echo "Добро пожаловать в игру \"Виселица\"!" . PHP_EOL;

(new Game())->start();
