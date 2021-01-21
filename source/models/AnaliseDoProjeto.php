<?php


namespace Source\models;


use CoffeeCode\DataLayer\DataLayer;

class AnaliseDoProjeto extends DataLayer
{
    public function __construct()
    {
        parent::__construct("AnaliseDoProjeto", ["analisador", "aprovado"], "id", false);
    }
}