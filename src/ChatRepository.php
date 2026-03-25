<?php
declare(strict_types=1);

final class ChatRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function createMessage(string $username, string $message): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO messages (username, message) VALUES (:username, :message)'
        );

        $stmt->execute([
            ':username' => $username,
            ':message' => $message,
        ]);
    }

    public function getRecentMessages(int $limit = 50): array
    {
        $limit = max(1, min($limit, 100));

        $stmt = $this->pdo->query(
            "SELECT id, username, message, created_at
             FROM messages
             ORDER BY id DESC
             LIMIT {$limit}"
        );

        $messages = $stmt->fetchAll();

        return array_reverse($messages);
    }
}
