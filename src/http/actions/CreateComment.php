<?php

namespace App\Http\Actions;

use App\Repository\UserRepositoryInterface;
use App\ValueObject\UUID;
use repository\CommentsRepositoryInterface;
use src\Comment;

class CreateComment
{
    private $commentsRepository;
    private $usersRepository;

    public function __construct(
        CommentsRepositoryInterface $commentsRepository,
        UserRepositoryInterface $usersRepository
    ) {
        $this->commentsRepository = $commentsRepository;
        $this->usersRepository = $usersRepository;
    }

    public function handle(array $data): array
    {
        if (
            empty($data['author_uuid']) ||
            empty($data['post_uuid']) ||
            empty($data['text'])
        ) {
            throw new InvalidArgumentException('Missing required fields');
        }

        try {
            $authorUuid = new UUID($data['author_uuid']);
            $postUuid   = new UUID($data['post_uuid']);
        } catch (\Exception $e) {
            throw new InvalidArgumentException('Invalid UUID format');
        }

        // Проверяем, что пользователь существует
        $this->usersRepository->get($authorUuid);

        $comment = new Comment(
            UUID::random(),
            $postUuid,
            $authorUuid,
            $data['text']
        );

        $this->commentsRepository->save($comment);

        return [
            'status' => 'success',
            'comment_uuid' => (string)$comment->getUuid()
        ];
    }
}