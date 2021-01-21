<?php


namespace Source\models;

use CoffeeCode\DataLayer\DataLayer;



class ImprovementAnalyzer extends DataLayer
{
    public function __construct()
    {
        parent::__construct("AnalisadorMelhoria", ["idarea", "idmelhoria", "sequencia"], "id", false);
    }
}
