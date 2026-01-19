<?php

require_once 'autoload.php';

use Users\User;
use Articles\Article;
use Comments\Comment;

$user = new User(1, 'Иван', 'Иванов');
$article = new Article(1, $user->id, 'Заголовок', 'Текст статьи');
$comment = new Comment(1, $user->id, $article->id, 'Комментарий');

var_dump($user, $article, $comment);