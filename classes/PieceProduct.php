<?php

namespace classes;

class PieceProduct extends Product
{
    public function calculateFinalPrice($quantity): float
    {
        $finalPrice = $this->basePrice * $quantity;
        $this->addRevenue($finalPrice);

        return $finalPrice;
    }
}