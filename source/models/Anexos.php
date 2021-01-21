<?php


namespace Source\models;

use CoffeeCode\DataLayer\DataLayer;



class Anexos extends DataLayer
{
    public function __construct()
    {
        parent::__construct("Anexos", ["idProvisorio"],"id",false);
    }
}
