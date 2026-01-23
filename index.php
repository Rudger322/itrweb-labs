<?php

require 'vendor/autoload.php';

use App\ValueObject\UUID;
use repository\CommentsRepositoryInterface;
use repository\PostsRepositoryInterface;
use src\Article;
use src\Comment;

$pdo = new PDO('sqlite:' . __DIR__ . '/database.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$commentsRepo = new CommentsRepositoryInterface($pdo);
$postsRepo = new PostsRepositoryInterface($pdo);

$postUuid = new UUID('post-1');
$userUuid = new UUID('user-1');

$post = new Article($postUuid, $userUuid, 'Заголовок', 'Текст');
$postsRepo->save($post);

$foundPost = $postsRepo->get($postUuid);
var_dump($foundPost);

$comment = new Comment(
    new UUID('comment-1'),
    $postUuid,
    $userUuid,
    'Комментарий'
);
$commentsRepo->save($comment);

var_dump($commentsRepo->get(new UUID('comment-1')));