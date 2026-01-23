<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Http\Actions\CreateComment;
use App\ValueObject\UUID;
use exception\NotFoundException;
use src\User;

function ok($msg) { echo "[OK] $msg\n"; }
function fail($msg) { echo "[FAIL] $msg\n"; exit(1); }

$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec("
    CREATE TABLE users (
        uuid TEXT PRIMARY KEY,
        name TEXT,
        surname TEXT,
        username TEXT
    );
    CREATE TABLE comments (
        uuid TEXT PRIMARY KEY,
        post_uuid TEXT,
        author_uuid TEXT,
        text TEXT
    );
");

$usersRepo = new \App\Repository\UserRepositoryInterface($pdo);
$commentsRepo = new \repository\CommentsRepositoryInterface($pdo);

$user = new User(new UUID('user-1'), 'Ivan', 'Ivanov', 'ivan');
$usersRepo->save($user);

$action = new CreateComment($commentsRepo, $usersRepo);

/* Успешный ответ */
$response = $action->handle([
    'author_uuid' => 'user-1',
    'post_uuid' => 'post-1',
    'text' => 'Hello'
]);

isset($response['status']) ? ok('Success response') : fail('No success');

/* Неверный UUID */
try {
    $action->handle([
        'author_uuid' => '!!!',
        'post_uuid' => 'post-1',
        'text' => 'Text'
    ]);
    fail('Invalid UUID not detected');
} catch (InvalidArgumentException $e) {
    ok('Invalid UUID detected');
}

/* Пользователь не найден */
try {
    $action->handle([
        'author_uuid' => 'unknown',
        'post_uuid' => 'post-1',
        'text' => 'Text'
    ]);
    fail('User not found not detected');
} catch (NotFoundException $e) {
    ok('User not found');
}

/* Недостаточно данных */
try {
    $action->handle([
        'author_uuid' => 'user-1'
    ]);
    fail('Missing data not detected');
} catch (InvalidArgumentException $e) {
    ok('Missing data detected');
}