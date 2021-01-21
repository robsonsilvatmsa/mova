<?php


namespace Source\models;
use CoffeeCode\DataLayer\DataLayer;

require_once("../../vendor/autoload.php");


class UserArea extends DataLayer
{
public function __construct()
{
    parent::__construct("AprovadoresArea", ["idusuario","idarea"], "id", false);
}
}
