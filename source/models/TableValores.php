<?php


namespace Source\models;


use CoffeeCode\DataLayer\DataLayer;

class TableValores extends DataLayer
{
    public function __construct()
    {
        parent::__construct("Valores", ["valor"], "id", false);
    }
}