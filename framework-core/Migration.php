<?php

abstract class Migration {

    abstract public function up();
    abstract public function down();

    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Execute raw SQL
     */
    protected function execute(string $sql): void {
        $this->pdo->exec($sql);
    }

    public function createTable(string $tableName, array $columns, ?string $additional = '') {
        $sql = "CREATE TABLE IF NOT EXISTS `$tableName` (\n" .
           implode(",\n", $columns) .
           ($additional ? ",\n$additional" : '') .
           "\n)";

           $this->execute($sql);
    }
}