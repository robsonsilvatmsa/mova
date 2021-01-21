<?php


namespace Source\models;


use CoffeeCode\DataLayer\DataLayer;


class UserGroup extends DataLayer
{
    public function __construct()
    {
        parent::__construct("usuariogrupo", ["idgrupo","idusuario"]);
    }
}