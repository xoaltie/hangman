<?php

declare(strict_types=1);

use App\Game;

require_once __DIR__ . '/../vendor/autoload.php';

echo "Добро пожаловать в игру \"Виселица\"!\n";
$input = readline("Хотите начать игру?\nНажмите Да[Y] или Нет[N]\n");

if (strtoupper($input) === 'Y') {
    $game = Game::getInstance();

    $game->start();
}