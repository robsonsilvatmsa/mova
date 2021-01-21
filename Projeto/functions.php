<?php

namespace Projeto;

use DateTimeZone;
use Source\models\Anexos;
use Source\models\EspinhaPeixeProj;
use Source\models\Porques;
use Source\models\Project;

require_once('../config.php');
require_once(DBAPI);

/**
 * class functions
 * para declarar as funções a
 * serem utilizadas para cadastrar um usuário
 *
 * @author robson.silva
 */
class functions
{

    private $now;

    public function update(
        $idprojeto,
        $idanexo,

        $ModePresentation,
        $causa,
        $categoria,
        $efeito,
        $pq1,
        $pq2,
        $pq3,
        $pq4,
        $pq5,
        $causaraiz,
        $actiontaken
    ) {
        $project = (new Project())->findById($idprojeto);


        $project->ModoCausaRaiz = $ModePresentation;
        $project->actiontaken = $actiontaken;
        $project->save();

        $anexos = new Anexos();
        $anex = $anexos->find("idProvisorio = '$idanexo'")->fetch(true);

        foreach ($anex as $anexo) {
            $idanx = $anexo->id;
            $anx = (new Anexos())->findById($idanx);
            $anx->idProvisorio = $idprojeto;
            $anx->save();
        }

        if ($ModePresentation == "espinha") {
            $espin = (new EspinhaPeixeProj())->find("idprojeto = $project->id ")->fetch(true);

            if (empty($espin)) {
                for ($a = 0; $a <= count($causa) - 1; $a++) {
                    $espinha = new EspinhaPeixeProj();
                    $espinha->causa = $causa[$a];
                    $espinha->categoria = $categoria[$a];
                    $espinha->efeito = $efeito;
                    $espinha->idprojeto = $project->id;
                    $espinha->save();
                }
            }
        } elseif ($ModePresentation == "porques") {
            $por = (new Porques())->find("idprojeto = $project->id")->fetch(true);
            if (empty($por)) {
                $porque = new Porques();
                $porque->primeiropq = $pq1;
                $porque->segundopq = $pq2;
                $porque->terceiropq = $pq3;
                $porque->quartopq = $pq4;
                $porque->quintopq = $pq5;
                $porque->causaraiz = $causaraiz;
                $porque->idprojeto = $project->id;
                $porque->save();
            }
        }

        header("location: index.php");
    }

    public function finalizar($id, $idanexo, $resultado)
    {
        $now = date_create('now', new DateTimeZone('America/Sao_Paulo'));
        $project = (new Project())->findById($id);
        $project->ResultadoObtido = $resultado;
        $project->Status = 3;
        $project->DataConclusao = date_format($now, 'Y-m-d');
        $project->save();

        $anexos = new Anexos();
        $anex = $anexos->find("idProvisorio = '$idanexo'")->fetch(true);
        if (!empty($anex)) {
            foreach ($anex as $anexo) {
                $idanx = $anexo->id;
                $anx = (new Anexos())->findById($idanx);
                $anx->idProvisorio = $id;
                $anx->save();
            }
        }
        header("location: index.php");
    }

}
