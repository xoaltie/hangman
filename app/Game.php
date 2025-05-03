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
            $input = mb_strtoupper(readline(PHP_EOL . "Начнем игру?" . PHP_EOL . "Введите Да[Д] или Нет[Н]: "));

            if ($input === 'Д') {
                $this->initialize();
                $this->play();
            } elseif ($input === 'Н') {
                break;
            } else {
                echo "Неизвестная команда" . PHP_EOL;
            }
        } while (true);

        echo "Игра завершена" . PHP_EOL;
    }

    private function initialize(): void
    {
        $this->word = mb_strtoupper(Words::getRandomOne());
        $this->guessWord = implode(array_fill(0, mb_strlen($this->word), '*'));
        $this->errorCount = 0;
        $this->gameStatus = GameStatus::IN_PROGRESS;
        $this->playerInputHistory = [];
    }

    private function play(): void
    {
        do {
            $this->printGuessWord();
            $this->printGameStats();

            $playerInput = mb_strtoupper(readline(PHP_EOL . "Введите символ: "));

            if (!$this->validatePlayerInput($playerInput)) {
                $this->printValidationError("Некорректный символ" . PHP_EOL);
                continue;
            }

            if (!$this->validateRepeatInput($playerInput)) {
                $this->printValidationError("Вы уже вводили этот символ" . PHP_EOL);
                continue;
            }

            if (str_contains($this->word, $playerInput)) {
                $this->updateGuessWord($playerInput);
            } else {
                $this->errorCount++;
            }

            $this->updateInputHistory($playerInput);
            $this->printHangman();
            $this->checkStatus();

        } while ($this->gameStatus === GameStatus::IN_PROGRESS);

        $this->printGameResult();
    }

    private function checkStatus(): void
    {
        if ($this->errorCount === self::MAX_ERRORS) {
            $this->gameStatus = GameStatus::LOSE;
        }

        if (strcmp($this->word, $this->guessWord) === 0) {
            $this->gameStatus = GameStatus::WIN;
        }
    }

    private function updateGuessWord(string $symbol): void
    {
        $word = mb_str_split($this->word);
        $guessWord = mb_str_split($this->guessWord);

        foreach ($word as $key => $value) {
            if ($value === $symbol) {
                $guessWord[$key] = $value;
            }
        }

        $this->guessWord = implode("", $guessWord);
    }

    private function printGuessWord(): void
    {
        echo $this->guessWord . PHP_EOL;
    }

    private function printGameResult(): void
    {
        if ($this->gameStatus === GameStatus::WIN) {
            $this->printGuessWord();
            echo PHP_EOL . "Вы победили!" . PHP_EOL;
        }

        if ($this->gameStatus === GameStatus::LOSE) {
            echo PHP_EOL . "Вы проиграли!" . PHP_EOL;
        }
    }

    private function updateInputHistory(string $playerInput): void
    {
        $this->playerInputHistory[] = $playerInput;
    }

    private function printPlayerInputHistory(): void
    {
        echo "Использованные буквы: " . implode(" ", $this->playerInputHistory);
    }

    private function printPlayerErrors(): void
    {
        echo "Кол-во ошибок: " . $this->errorCount;
    }

    private function printGameStats(): void
    {
        $this->printPlayerErrors();
        echo "\t";
        $this->printPlayerInputHistory();
    }

    private function validatePlayerInput(string $input): bool
    {
        return !(mb_strlen($input) > 1);
    }

    private function printValidationError(string $message): void
    {
        echo $message;
    }

    private function validateRepeatInput(string $input): bool
    {
        return !(in_array($input, $this->playerInputHistory));
    }

    private function printHangman(): void
    {
        switch ($this->errorCount) {
            case 1:
                echo $this->hangmanOneError();
                break;
            case 2:
                echo $this->hangmanTwoError();
                break;
            case 3:
                echo $this->hangmanThreeError();
                break;
            case 4:
                echo $this->hangmanFourError();
                break;
            case 5:
                echo $this->hangmanFiveError();
                break;
            case self::MAX_ERRORS:
                echo $this->hangmanMaxError();
                break;
        }
    }

    private function hangmanOneError(): string
    {
        $hangman = "  __________" . PHP_EOL
            . " |         |" . PHP_EOL
            . " |         |" . PHP_EOL
            . " |" . PHP_EOL
            . " |" . PHP_EOL
            . " |" . PHP_EOL
            . " |" . PHP_EOL
            . " |" . PHP_EOL
            . " |" . PHP_EOL
            . "/|\\" . PHP_EOL . PHP_EOL;

        return $hangman;
    }

    private function hangmanTwoError(): string
    {
        $hangman = "  __________" . PHP_EOL
            . " |         |" . PHP_EOL
            . " |         |" . PHP_EOL
            . " |         O" . PHP_EOL
            . " |" . PHP_EOL
            . " |" . PHP_EOL
            . " |" . PHP_EOL
            . " |" . PHP_EOL
            . " |" . PHP_EOL
            . "/|\\" . PHP_EOL . PHP_EOL;

        return $hangman;
    }

    private function hangmanThreeError(): string
    {
        $hangman = "  __________" . PHP_EOL
            . " |         |" . PHP_EOL
            . " |         |" . PHP_EOL
            . " |         O" . PHP_EOL
            . " |        /|" . PHP_EOL
            . " |         |" . PHP_EOL
            . " | " . PHP_EOL
            . " |" . PHP_EOL
            . " |" . PHP_EOL
            . "/|\\" . PHP_EOL . PHP_EOL;

        return $hangman;
    }

    private function hangmanFourError(): string
    {
        $hangman = "  __________" . PHP_EOL
            . " |         |" . PHP_EOL
            . " |         |" . PHP_EOL
            . " |         O" . PHP_EOL
            . " |        /|\\" . PHP_EOL
            . " |         |" . PHP_EOL
            . " |" . PHP_EOL
            . " |" . PHP_EOL
            . " |" . PHP_EOL
            . "/|\\" . PHP_EOL . PHP_EOL;

        return $hangman;
    }

    private function hangmanFiveError(): string
    {
        $hangman = "  __________" . PHP_EOL
            . " |         |" . PHP_EOL
            . " |         |" . PHP_EOL
            . " |         O" . PHP_EOL
            . " |        /|\\" . PHP_EOL
            . " |         |" . PHP_EOL
            . " |        /" . PHP_EOL
            . " |" . PHP_EOL
            . " |" . PHP_EOL
            . "/|\\" . PHP_EOL . PHP_EOL;

        return $hangman;
    }

    private function hangmanMaxError(): string
    {
        $hangman = "  __________" . PHP_EOL
            . " |         |" . PHP_EOL
            . " |         |" . PHP_EOL
            . " |         O" . PHP_EOL
            . " |        /|\\" . PHP_EOL
            . " |         |" . PHP_EOL
            . " |        / \\" . PHP_EOL
            . " |" . PHP_EOL
            . " |" . PHP_EOL
            . "/|\\" . PHP_EOL . PHP_EOL;

        return $hangman;
    }
}