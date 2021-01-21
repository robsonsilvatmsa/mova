<?php

namespace Melhoria;

use DateTimeZone;

use Source\models\Anexos;
use Source\models\Group;
use Source\models\Melhoria;
use Source\models\AbrangenciaMelhoria;
use Source\models\User;
use Source\models\UserGroup;
use Source\support\SendMail;

require_once("../vendor/autoload.php");
require_once('../config.php');
require_once(DBAPI);


/**
 * class functions
 * para declarar as funções a
 * serem utilizadas para cadastrar um usuário
 * @author robson.silva
 */
class functions
{

    public function update($idmelhoria, $idanexo, $rdbinvestimento, $txtinvestimento)
    {
        $melhoria = (new Melhoria())->findById($idmelhoria);
        $melhoria->NecessitaInvestimento = $rdbinvestimento;
        $melhoria->ValorInvestimento = $txtinvestimento;
        $melhoria->save();


        $anexos = new Anexos();
        $anex = $anexos->find("idProvisorio = '$idanexo'")->fetch(true);
        foreach ($anex as $anexo) {
            $idanx = $anexo->id;
            $anx = (new Anexos())->findById($idanx);
            $anx->idProvisorio = $idmelhoria;
            $anx->save();

        }
        header("location: index.php");
    }

    public function finalizar($idmelhoria, $idanexo, $txtResultado)
    {
        $now = date_create('now', new DateTimeZone('America/Sao_Paulo'));
        $melhoria = (new Melhoria())->findById($idmelhoria);
        $melhoria->ResultadoObtido = $txtResultado;
        $melhoria->status = 3;
        $melhoria->DataEncerramento = date_format($now, 'Y-m-d');
        $melhoria->save();


        $anexos = new Anexos();
        $anex = $anexos->find("idProvisorio = '$idanexo'")->fetch(true);
        if (!empty($anex)) {
            foreach ($anex as $anexo) {
                $idanx = $anexo->id;
                $anx = (new Anexos())->findById($idanx);
                $anx->idProvisorio = $idmelhoria;
                $anx->save();

            }
        }
        header("location: index.php");
    }

}
