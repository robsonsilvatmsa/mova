<?php


namespace Source\models;


use CoffeeCode\DataLayer\DataLayer;

class ProjectAnalyzer extends DataLayer
{
    public function __construct()
    {
        parent::__construct("AnalisadorProjeto", ["idprojeto", "idarea", "sequencia"], "id", false);
    }
}