<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once 'src\User.php';
require_once 'src\Article.php';
require_once 'src\Comment.php';

use src\User;
use src\Article;
use src\Comment;

$user = new User(1, 'Иван', 'Иванов');
$article = new Article(1, 1, 'Тест', 'Текст');
$comment = new Comment(1, 1, 1, 'Комментарий');

echo 'Автозагрузка работает<br>';

var_dump($user, $article, $comment);