<?php

namespace App;

final class HangmanDrawing
{
    private static ?HangmanDrawing $instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): HangmanDrawing
    {
        if (self::$instance === null) {
            self::$instance = new HangmanDrawing();
        }

        return self::$instance;
    }

    public static function stageOne(): void
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

        echo $hangman;
    }

    public static function stageTwo(): void
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

        echo $hangman;
    }

    public static function stageThree(): void
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

        echo $hangman;
    }

    public static function stageFour(): void
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

        echo $hangman;
    }

    public static function stageFive(): void
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

        echo $hangman;
    }

    public static function stageMax(): void
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

        echo $hangman;
    }
}