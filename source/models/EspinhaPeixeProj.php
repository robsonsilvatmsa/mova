<?php


namespace Source\models;


use CoffeeCode\DataLayer\DataLayer;

class EspinhaPeixeProj extends DataLayer
{
    public function __construct()
    {
        parent::__construct("EspinhaPeixeProj", ["causa", "categoria", "efeito", "idprojeto"], "id", false);
    }
}