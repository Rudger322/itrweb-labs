<?php

namespace src;

class Article
{
    public $uuid;
    public $authorId;
    public $title;
    public $text;

    public function __construct($id, $authorId, $title, $text)
    {
        $this->uuid = $id;
        $this->authorId = $authorId;
        $this->title = $title;
        $this->text = $text;
    }
}
