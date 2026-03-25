<?php
declare(strict_types=1);

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function isLoggedIn(): bool
{
    return isset($_SESSION['username']) && trim((string) $_SESSION['username']) !== '';
}

function requireLogin(): void
{
    if (!isLoggedIn()) {
        Response::json(['error' => 'Unauthorized'], 401);
    }
}

function currentUsername(): string
{
    return trim((string) ($_SESSION['username'] ?? ''));
}

function cleanUsername(string $username): string
{
    $username = trim($username);
    $username = preg_replace('/\s+/', ' ', $username) ?? '';
    return substr($username, 0, 50);
}

function cleanMessage(string $message): string
{
    $message = trim($message);
    $message = preg_replace('/\s+/', ' ', $message) ?? '';
    return substr($message, 0, 500);
}
