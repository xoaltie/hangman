<?php

namespace App;

final class Words
{
    private static ?Words $instance = null;
    private static array $list;

    private function __construct()
    {
        try {
            self::$list = $this->getFromFile();
        }
        catch (\Exception $exception){
            exit("Файл конфигурации не найден, игра остановлена." . PHP_EOL . "Обратитесь к администратору." .PHP_EOL);
        }
    }

    public static function getInstance(): Words
    {
        if (self::$instance === null) {
            self::$instance = new Words();
        }

        return self::$instance;
    }

    /**
     * @return array<int, string>
     * @throws \Exception
     */
    private function getFromFile(): array
    {
        $path = __DIR__ . '/../resources/words_list.txt';

        if (!file_exists($path)){
            throw new \Exception("Файл по пути \"{$path}\" не найден!" . PHP_EOL);
        }

        return file($path, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
    }

    public static function getRandomOne(): string
    {
        return self::$list[array_rand(self::$list)];
    }
}