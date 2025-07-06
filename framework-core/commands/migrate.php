<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Migration.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

Database::init();
$pdo = Database::get();

foreach (glob(__DIR__ . '/../../app/migrations/*.php') as $path) {
    require_once $path;

    $className = basename($path, '.php'); 

    if (class_exists($className)) {
        echo "Running migration: $className\n";
        $migration = new $className($pdo);
        $migration->up();
    }
}