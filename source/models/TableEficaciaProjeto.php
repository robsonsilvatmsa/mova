<?php


namespace Source\models;


use CoffeeCode\DataLayer\DataLayer;

class TableEficaciaProjeto extends DataLayer
{
    public function __construct()
    {
        parent::__construct("EficaciaProjeto", ["aprovado", "parecer"], "id", false);
    }
}