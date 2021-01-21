<?php


namespace Source\models;


use CoffeeCode\DataLayer\DataLayer;

/**
 * Class Focus
 * @package Source\models
 */
class Focus extends DataLayer
{
    public function __construct()
    {
        parent::__construct("Foco",["focus_description"],"id",false);
    }

}
