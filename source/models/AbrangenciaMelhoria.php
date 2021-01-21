<?php


namespace Source\models;

use CoffeeCode\DataLayer\DataLayer;



class AbrangenciaMelhoria extends DataLayer
{

    public function __construct()
    {
        parent::__construct("AbrangenciaMelhoria", ["idarea","idmelhoria"], "id", false);
    }
}
