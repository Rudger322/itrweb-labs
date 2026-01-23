<?php

namespace repository;

use exception\NotFoundException;
use PDO;
use src\article;
use App\ValueObject\UUID;

class PostsRepositoryInterface
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(Article $post): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO posts (uuid, author_uuid, title, text)
             VALUES (:uuid, :author_uuid, :title, :text)'
        );

        $stmt->execute([
            ':uuid' => (string)$post->getUuid(),
            ':author_uuid' => (string)$post->getAuthorUuid(),
            ':title' => $post->getTitle(),
            ':text' => $post->getText(),
        ]);
    }

    public function get(UUID $uuid): Article
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM posts WHERE uuid = :uuid'
        );
        $stmt->execute([
            ':uuid' => (string)$uuid
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            throw new NotFoundException('Post not found');
        }

        return new Article(
            new UUID($row['uuid']),
            new UUID($row['author_uuid']),
            $row['title'],
            $row['text']
        );
    }

    public function delete(UUID $uuid): void
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM posts WHERE uuid = :uuid'
        );
        $stmt->execute(['uuid' => (string)$uuid]);

        if ($stmt->rowCount() === 0) {
            throw new NotFoundException('Post not found');
        }
    }
}