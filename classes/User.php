<?php

namespace classes;

class User
{
    protected $id;
    protected $name;
    protected $email;

    public function __construct($id, $name, $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
