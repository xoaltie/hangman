<?php

namespace App;

use App\Enums\GameStatus;

final class Game
{
    private static ?Game $instance = null;
    private string $word;
    private string $guessWord;
    private int $errorCount;
    private GameStatus $gameStatus;
    private array $playerInputHistory;

    private function __construct()
    {
    }

    public static function getInstance(): Game
    {
        if (self::$instance === null) {
            self::$instance = new Game();
        }

        return self::$instance;
    }

    public function start(): void
    {
        Words::getInstance();

        do {
            $input = strtoupper(readline("Начнем игру?\nВведите Да[Y] или Нет[N]: \n"));

            if ($input === 'Y'){
                $this->initialize();
                $this->play();
            }
            elseif ($input === 'N'){
                break;
            }
            else{
                echo "Неизвестная команда\n";
            }
        } while (true);

        echo "Игра завершена\n";
    }

    private function initialize(): void
    {
        $this->word = Words::getRandomOne();
        $this->guessWord = implode(array_fill(0, strlen($this->word), '*'));
        $this->errorCount = 0;
        $this->gameStatus = GameStatus::IN_PROGRESS;
    }

    private function play(): void
    {
        do {
            $playerInput = readline();

            if (str_contains(strtoupper($this->word), strtoupper($playerInput))) {

            } else {
                $this->errorCount++;
            }

            $this->checkStatus();

        } while ($this->gameStatus === GameStatus::IN_PROGRESS);
    }

    private function checkStatus(): void
    {
        if ($this->errorCount === 6) {
            $this->gameStatus = GameStatus::LOSE;
            return;
        }

        if (strcmp($this->word, $this->guessWord) === 0) {
            $this->gameStatus = GameStatus::WIN;
        }
    }
}