<?php

namespace classes;

class Admin extends User
{
    public function deleteProduct(Product $product)
    {
        echo 'Товар удалён администратором';
    }
}