<?php


namespace Source\models;

use CoffeeCode\DataLayer\DataLayer;

class TableEficaciaMelhoria extends DataLayer
{
    public function __construct()
    {
        parent::__construct("EficaciaMelhoria", ["aprovado", "parecer", "idmelhoria"], "id", false);
    }
}