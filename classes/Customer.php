<?php

namespace classes;

class Customer extends User
{
    public function makeOrder()
    {
        echo 'Заказ оформлен';
    }
}