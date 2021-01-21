<?php


namespace Source\models;


use CoffeeCode\DataLayer\DataLayer;

class Project extends DataLayer
{
    public function __construct()
    {
        parent::__construct("Project", ["idGrupo", "idArea", "idFoco", "Descricao", "SolucaoProposta",
            "GrupoExecuta", "NecessitaInvestimento", "DataInicio"], "id", false);
    }
}
