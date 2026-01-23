<?php

namespace src;

class Comment
{
    public $uuid;
    public $authorId;
    public $articleId;
    public $text;

    public function __construct($id, $authorId, $articleId, $text)
    {
        $this->uuid = $id;
        $this->authorId = $authorId;
        $this->articleId = $articleId;
        $this->text = $text;
    }
}
