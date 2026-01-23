<?php

namespace src;

class User
{
    public $uuid;
    public $firstName;
    public $lastName;

    public function __construct($id, $firstName, $lastName)
    {
        $this->uuid = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }
}