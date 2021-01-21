<?php


namespace Source\models;


use CoffeeCode\DataLayer\DataLayer;

class AbrangenciaProjeto extends DataLayer
{
    public function __construct()
    {
        parent::__construct("AbrangenciaProjeto", ["idarea", "idprojeto"], "id", false);
    }
}