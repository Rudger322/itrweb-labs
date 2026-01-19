<?php

namespace classes;

class Cart
{
    protected $products = [];

    public function addProduct(Product $product)
    {
        $this->products[] = $product;
    }

    public function getTotalPrice(): float
    {
        $total = 0;

        foreach ($this->products as $product) {
            $total += $product->getPrice();
        }

        return $total;
    }
}
