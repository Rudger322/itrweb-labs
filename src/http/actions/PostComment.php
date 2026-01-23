<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Http\Actions\CreateComment;
use App\Repository\UserRepositoryInterface;
use repository\CommentsRepositoryInterface;

$pdo = new PDO('sqlite:' . __DIR__ . '/../storage/db.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$method = $_SERVER['REQUEST_METHOD'];
$path   = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($method === 'POST' && $path === '/posts/comment') {
    $data = json_decode(file_get_contents('php://input'), true);

    try {
        $action = new CreateComment(
            new CommentsRepositoryInterface($pdo),
            new UserRepositoryInterface($pdo)
        );

        $response = $action->handle($data);

        http_response_code(200);
        echo json_encode($response);
    } catch (\Throwable $e) {
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
    }
}
