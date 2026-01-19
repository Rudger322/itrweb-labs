<?php

namespace classes;

class DigitalProduct extends Product
{
    public function calculateFinalPrice($amount = 1): float
    {
        $finalPrice = ($this->basePrice / 2) * $amount;
        $this->addRevenue($finalPrice);

        return $finalPrice;
    }
}