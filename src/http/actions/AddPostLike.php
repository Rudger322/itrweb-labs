<?php

namespace App\Http\Actions;

use App\Repository\UserRepositoryInterface;
use App\ValueObject\UUID;
use repository\LikesRepositoryInterface;
use repository\PostsRepositoryInterface;
use src\Like;

class AddPostLike
{
    private $likesRepo;
    private $usersRepo;
    private $postsRepo;

    public function __construct(
        LikesRepositoryInterface $likesRepo,
        UserRepositoryInterface $usersRepo,
        PostsRepositoryInterface $postsRepo
    ) {
        $this->likesRepo = $likesRepo;
        $this->usersRepo = $usersRepo;
        $this->postsRepo = $postsRepo;
    }

    public function handle(array $data): array
    {
        if (empty($data['post_uuid']) || empty($data['user_uuid'])) {
            return ['status' => 'error', 'message' => 'Required fields missing'];
        }

        try {
            $postUuid = new UUID($data['post_uuid']);
            $userUuid = new UUID($data['user_uuid']);
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Invalid UUID format'];
        }

        // Проверяем существование пользователя и поста
        try {
            $this->usersRepo->get($userUuid);
        } catch (\Throwable $e) {
            return ['status' => 'error', 'message' => 'User not found'];
        }

        try {
            $this->postsRepo->get($postUuid);
        } catch (\Throwable $e) {
            return ['status' => 'error', 'message' => 'Post not found'];
        }

        // сгенерировать UUID для лайка
        $likeId = new UUID(bin2hex(random_bytes(16)));

        $like = new Like($likeId, $postUuid, $userUuid);

        try {
            $this->likesRepo->save($like);
        } catch (\RuntimeException $e) {
            // дубликат
            return ['status' => 'error', 'message' => 'Already liked'];
        }

        return ['status' => 'success', 'like_uuid' => (string)$likeId];
    }
}