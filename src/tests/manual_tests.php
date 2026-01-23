<?php

use App\ValueObject\UUID;
use exception\NotFoundException;
use repository\CommentsRepositoryInterface;
use repository\PostsRepositoryInterface;
use src\Article;
use src\Comment;

require __DIR__ . 'vendor\autoload.php';

function assertTrue($condition, $message)
{
    if ($condition) {
        echo "[OK] $message\n";
    } else {
        echo "[FAIL] $message\n";
        exit(1);
    }
}

function assertEquals($expected, $actual, $message)
{
    assertTrue($expected === $actual, $message);
}

$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec("
    CREATE TABLE posts (
        uuid TEXT PRIMARY KEY,
        author_uuid TEXT,
        title TEXT,
        text TEXT
    )
");

$pdo->exec("
    CREATE TABLE comments (
        uuid TEXT PRIMARY KEY,
        post_uuid TEXT,
        author_uuid TEXT,
        text TEXT
    )
");

echo "\n=== POSTS TESTS ===\n";

$postsRepo = new PostsRepositoryInterface($pdo);

$post = new Article(
    new UUID('post-1'),
    new UUID('user-1'),
    'Test title',
    'Test text'
);

/* статья сохраняется */
$postsRepo->save($post);
$count = $pdo->query('SELECT COUNT(*) FROM posts')->fetchColumn();
assertEquals(1, $count, 'Post saved');

/* статья находится по UUID */
$foundPost = $postsRepo->get(new UUID('post-1'));
assertEquals('Test title', $foundPost->getTitle(), 'Post found by UUID');

/* выбрасывается исключение */
try {
    $postsRepo->get(new UUID('unknown'));
    assertTrue(false, 'Exception should be thrown');
} catch (NotFoundException $e) {
    assertTrue(true, 'Exception thrown if post not found');
}

echo "\n=== COMMENTS TESTS ===\n";

$commentsRepo = new CommentsRepositoryInterface($pdo);

$comment = new Comment(
    new UUID('comment-1'),
    new UUID('post-1'),
    new UUID('user-1'),
    'Comment text'
);

/* комментарий сохраняется */
$commentsRepo->save($comment);
$count = $pdo->query('SELECT COUNT(*) FROM comments')->fetchColumn();
assertEquals(1, $count, 'Comment saved');

/* комментарий находится по UUID */
$foundComment = $commentsRepo->get(new UUID('comment-1'));
assertEquals('Comment text', $foundComment->getText(), 'Comment found by UUID');

/* выбрасывается исключение */
try {
    $commentsRepo->get(new UUID('unknown'));
    assertTrue(false, 'Exception should be thrown');
} catch (NotFoundException $e) {
    assertTrue(true, 'Exception thrown if comment not found');
}

echo "\n=== DOMAIN TESTS ===\n";

/* UUID */
$uuid = new UUID('abc');
assertEquals('abc', (string)$uuid, 'UUID to string');

/* Post getters */
assertEquals('Test text', $post->getText(), 'Post text getter');

/* Comment getters */
assertEquals('Comment text', $comment->getText(), 'Comment text getter');