<?php

namespace classes;

class PhysicalProduct extends Product
{
    protected $weight;

    public function __construct($id, $name, $price, $description, $weight)
    {
        parent::__construct($id, $name, $price, $description);
        $this->weight = $weight;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }
}