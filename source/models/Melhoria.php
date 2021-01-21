<?php


namespace Source\models;

use CoffeeCode\DataLayer\DataLayer;




class Melhoria extends DataLayer
{
    public function __construct()
    {
        parent::__construct("Melhoria", ["Descricao", "SolucaoProposta", "DataInicio", "IdGrupo", "IdFoco", "IdAreaImplantada", "GrupoExecuta", "NecessitaInvestimento"], "id", false);
    }
}
