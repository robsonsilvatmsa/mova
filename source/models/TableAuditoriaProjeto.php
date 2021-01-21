<?php


namespace Source\models;


use CoffeeCode\DataLayer\DataLayer;

class TableAuditoriaProjeto extends DataLayer
{
    public function __construct()
    {
        parent::__construct("AuditoriaProjeto", ["aprovado"], "id", false);
    }
}