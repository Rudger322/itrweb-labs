<?php

namespace repository;

use App\ValueObject\UUID;
use PDO;
use src\Like;

class LikesRepositoryInterface
{
    private $pdo;

    private $table;

    public function __construct(PDO $pdo, string $table = 'post_likes')
    {
        $this->pdo = $pdo;
        $this->table = $table;
    }

    public function save(Like $like): void
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO {$this->table} (uuid, post_uuid, user_uuid)
             VALUES (:uuid, :post_uuid, :user_uuid)"
        );

        try {
            $stmt->execute([
                ':uuid' => (string)$like->getUuid(),
                ':post_uuid' => (string)$like->getPostUuid(),
                ':user_uuid' => (string)$like->getUserUuid(),
            ]);
        } catch (\PDOException $e) {
            // SQLite unique constraint: code may differ; проще — проверить текст ошибки
            if (strpos($e->getMessage(), 'UNIQUE') !== false) {
                throw new \RuntimeException('Already liked', 0, $e);
            }
            throw $e;
        }
    }

    public function getByPostUuid(UUID $postUuid): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM {$this->table} WHERE post_uuid = :post_uuid"
        );
        $stmt->execute([':post_uuid' => (string)$postUuid]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $likes = [];
        foreach ($rows as $row) {
            $likes[] = new Like(
                new UUID($row['uuid']),
                new UUID($row['post_uuid']),
                new UUID($row['user_uuid'])
            );
        }

        return $likes;
    }
}
