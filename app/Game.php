<?php

namespace App;

use App\Enums\GameStatus;

final class Game
{
    private const int MAX_ERRORS = 6;
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
            $input = mb_strtoupper(readline("\nНачнем игру?\nВведите Да[Д] или Нет[Н]: "));

            if ($input === 'Д') {
                $this->initialize();
                $this->play();
            } elseif ($input === 'Н') {
                break;
            } else {
                echo "Неизвестная команда\n";
            }
        } while (true);

        echo "Игра завершена\n";
    }

    private function initialize(): void
    {
        $this->word = mb_strtoupper(Words::getRandomOne());
        $this->guessWord = implode(array_fill(0, mb_strlen($this->word), '*'));
        $this->errorCount = 0;
        $this->gameStatus = GameStatus::IN_PROGRESS;
    }

    private function play(): void
    {
        do {
            $this->printGuessWord();

            $playerInput = mb_strtoupper(readline("Введите символ: "));

            if (str_contains($this->word, $playerInput)) {
                $this->updateGuessWord($playerInput);
            } else {
                $this->errorCount++;
            }

            $this->checkStatus();

        } while ($this->gameStatus === GameStatus::IN_PROGRESS);
    }

    private function checkStatus(): void
    {
        if ($this->errorCount === self::MAX_ERRORS) {
            $this->gameStatus = GameStatus::LOSE;
            echo "\nВы проиграли!\n";
        }

        if (strcmp($this->word, $this->guessWord) === 0) {
            $this->gameStatus = GameStatus::WIN;
            echo "\nВы победили!\n";
        }
    }

    private function updateGuessWord(string $symbol): void
    {
        $indexes = [];
        $lastPos = 0;

        while (($lastPos = mb_strpos($this->word, $symbol, $lastPos)) !== false) {
            $indexes[] = $lastPos;
            $lastPos = $lastPos + mb_strlen($symbol);
        }

        foreach ($indexes as $index) {
            $this->guessWord = substr_replace($this->guessWord, $symbol, $index);
        }
    }

    private function printGuessWord(): void
    {
        echo $this->guessWord . "\n";
    }
}