<?php

namespace classes;

class Review
{
    protected $user;
    protected $product;
    protected $rating;
    protected $comment;

    public function __construct(User $user, Product $product, $rating, $comment)
    {
        $this->user = $user;
        $this->product = $product;
        $this->rating = $rating;
        $this->comment = $comment;
    }

    public function getRating(): int
    {
        return $this->rating;
    }
}