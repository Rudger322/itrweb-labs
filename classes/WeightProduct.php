<?php

namespace classes;

class WeightProduct extends Product
{
    public function calculateFinalPrice($weightKg): float
    {
        $finalPrice = $this->basePrice * $weightKg;
        $this->addRevenue($finalPrice);

        return $finalPrice;
    }
}