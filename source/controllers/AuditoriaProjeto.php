<?php


namespace Source\controllers;

use Source\models\Project;
use Source\models\TableAuditoriaProjeto;

require_once("../../vendor/autoload.php");
require_once('../../config.php');
require_once(DBAPI);


class AuditoriaProjeto
{
    public function save($aprovado, $parecer, $respostas, $idproj)
    {
        $auditoria = new TableAuditoriaProjeto();
        $auditoria->aprovado = $aprovado;
        $auditoria->parecer = $parecer;
        $auditoria->avaliacao = $respostas;
        $auditoria->idprojeto = $idproj;

        $projeto = (new Project())->findById($idproj);
        $projeto->Status = 6;
        $projeto->save();

        header("location: index.php");
    }
}