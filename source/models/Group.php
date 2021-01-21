<?php


namespace Source\models;

//require_once('../../config.php');

use CoffeeCode\DataLayer\DataLayer;

class Group extends DataLayer
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("Grupo", ["name_group"], "id", false);
    }
}
