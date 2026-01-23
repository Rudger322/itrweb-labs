<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Http\Actions\AddPostLike;
use App\ValueObject\UUID;

// PDO
$pdo = new PDO('sqlite:' . __DIR__ . '/../storage/db.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Репозитории (предполагается, что SQLiteUsersRepository и SQLitePostsRepository есть)
$usersRepo = new \App\Repository\UserRepositoryInterface($pdo);
$postsRepo = new \repository\PostsRepositoryInterface($pdo);
$likesRepo = new \repository\LikesRepositoryInterface($pdo, 'post_likes');

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($method === 'POST' && $path === '/posts/like') {
    $data = json_decode(file_get_contents('php://input'), true);

    $action = new AddPostLike($likesRepo, $usersRepo, $postsRepo);
    $result = $action->handle($data);

    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}