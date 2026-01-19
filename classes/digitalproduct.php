<?php

namespace classes;

class DigitalProduct extends Product
{
    protected $downloadLink;

    public function __construct($id, $name, $price, $description, $downloadLink)
    {
        parent::__construct($id, $name, $price, $description);
        $this->downloadLink = $downloadLink;
    }

    public function getDownloadLink(): string
    {
        return $this->downloadLink;
    }
}