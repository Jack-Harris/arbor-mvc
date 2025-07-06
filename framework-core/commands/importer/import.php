<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../../framework-core/Database.php';
require_once __DIR__ . '/../../../app/services/JSONImporter.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();

Database::init();

$importer = new JSONImporter(__DIR__ . '/school_messages_filtered_10k.json');
$importer->import();