<?php

declare(strict_types=1);

namespace App\Enums;

enum GameStatus: int
{
    case WIN = 0;
    case LOSE = 1;
    case IN_PROGRESS = 2;
}