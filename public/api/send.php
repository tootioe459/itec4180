<?php
declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/src/bootstrap.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::json(['error' => 'Method not allowed'], 405);
}

$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput ?: '{}', true);

$message = cleanMessage((string) ($data['message'] ?? ''));

if ($message === '') {
    Response::json(['error' => 'Message cannot be empty'], 422);
}

$repository = new ChatRepository($pdo);
$repository->createMessage(currentUsername(), $message);

Response::json([
    'success' => true,
]);
