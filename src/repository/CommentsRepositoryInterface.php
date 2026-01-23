<?php

namespace repository;

use exception\NotFoundException;
use PDO;
use src\Comment;
use App\ValueObject\UUID;

class CommentsRepositoryInterface
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(Comment $comment): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO comments (uuid, post_uuid, author_uuid, text)
             VALUES (:uuid, :post_uuid, :author_uuid, :text)'
        );

        $stmt->execute([
            ':uuid' => (string)$comment->getUuid(),
            ':post_uuid' => (string)$comment->getPostUuid(),
            ':author_uuid' => (string)$comment->getAuthorUuid(),
            ':text' => $comment->getText(),
        ]);
    }

    public function get(UUID $uuid): Comment
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM comments WHERE uuid = :uuid'
        );
        $stmt->execute([
            ':uuid' => (string)$uuid
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            throw new NotFoundException('Comment not found');
        }

        return new Comment(
            new UUID($row['uuid']),
            new UUID($row['post_uuid']),
            new UUID($row['author_uuid']),
            $row['text']
        );
    }
}