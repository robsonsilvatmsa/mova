<?php


namespace Source\models;


use CoffeeCode\DataLayer\DataLayer;

class TableArea extends DataLayer
{
    public function __construct()
    {
        parent::__construct("Area", ["description_area"], "id", false);
    }
}
