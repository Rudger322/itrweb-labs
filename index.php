<?php

use classes\DigitalProduct;
use classes\PieceProduct;
use classes\WeightProduct;

require_once 'classes/Product.php';
require_once 'classes/DigitalProduct.php';
require_once 'classes/PieceProduct.php';
require_once 'classes/WeightProduct.php';

$ebook = new DigitalProduct('PHP Book', 1000);
echo $ebook->calculateFinalPrice(1);

echo "\n";

$phone = new PieceProduct('Smartphone', 20000);
echo $phone->calculateFinalPrice(2);

echo "\n";

$apples = new WeightProduct('Apples', 120);
echo $apples->calculateFinalPrice(1.5);


echo $ebook->getRevenue();
echo $phone->getRevenue();
echo $apples->getRevenue();
