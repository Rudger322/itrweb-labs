<?php

namespace classes;

abstract class Product
{
    protected $name;
    protected $basePrice;
    protected $revenue = 0;

    public function __construct($name, $basePrice)
    {
        $this->name = $name;
        $this->basePrice = $basePrice;
    }

    abstract public function calculateFinalPrice($amount): float;

    protected function addRevenue($sum)
    {
        $this->revenue += $sum;
    }

    public function getRevenue(): float
    {
        return $this->revenue;
    }
}