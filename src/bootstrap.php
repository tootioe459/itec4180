<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$appConfig = require dirname(__DIR__) . '/config/app.php';
$pdo = require dirname(__DIR__) . '/config/database.php';

require_once dirname(__DIR__) . '/src/helpers.php';
require_once dirname(__DIR__) . '/src/Response.php';
require_once dirname(__DIR__) . '/src/ChatRepository.php';
