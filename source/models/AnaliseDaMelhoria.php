<?php


namespace Source\models;


use CoffeeCode\DataLayer\DataLayer;

class AnaliseDaMelhoria extends DataLayer
{
    public function __construct()
    {
        parent::__construct("AnaliseDaMelhoria", ["analisador", "aprovado"], "id", false);
    }
}
