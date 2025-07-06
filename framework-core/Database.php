<?php

class Database {
    private static ?PDO $pdo = null;

    public static function init(): void {
        self::$pdo = new PDO(
            'mysql:host=' . $_ENV['MYSQL_HOST'] . ';dbname=' . $_ENV['MYSQL_DATABASE'],  
            $_ENV['MYSQL_USER'], 
            $_ENV['MYSQL_PASSWORD']
        );
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function get(): PDO {
        return self::$pdo;
    }
}