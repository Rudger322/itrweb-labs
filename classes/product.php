<?php

namespace classes;

class Product
{
    protected $id;
    protected $name;
    protected $price;
    protected $description;

    public function __construct($id, $name, $price, $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getInfo(): string
    {
        return $this->name . ': ' . $this->price . ' ₽';
    }
}