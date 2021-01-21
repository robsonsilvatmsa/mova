<?php


namespace Source\models;


use CoffeeCode\DataLayer\DataLayer;

class Porques extends DataLayer
{
    public function __construct()
    {
        parent::__construct("[5PorquesProjeto]", ["primeiropq", "segundopq", "terceiropq",
            "causaraiz", "idprojeto"], "id", false);
    }
}