<?php


namespace Source\controllers;

use Source\models\Project;
use Source\models\TableValores;
use Source\models\AbrangenciaProjeto;
use Source\models\TableEficaciaProjeto;


require_once("../../vendor/autoload.php");
require_once('../../config.php');
require_once(DBAPI);


class EficaciaProjeto
{
    public function save($aprovado, $parecer, $respostas, $idproj)
    {
        $soma = 0;
        $valor = 0;
        $eficacia = new TableEficaciaProjeto();
        $eficacia->aprovado = $aprovado;
        $eficacia->parecer = $parecer;
        $eficacia->idprojeto = $idproj;

        if (count($respostas) >= 7) {
            $eficacia->ProblemaClaro = $respostas[0];
            $eficacia->MetodoAnaliseCausaRaiz = $respostas[1];
            $eficacia->CausaRaizElimina = $respostas[2];
            $eficacia->ProjetoDesenvolvidoGrupo = $respostas[3];
            $eficacia->ResultadoPossuiImpacto = $respostas[4];
            $eficacia->ProjetoTrouxeRetorno = $respostas[5];
            $eficacia->SolicaoPropostaInovadora = $respostas[6];


            if ($respostas[0] == "Sim") {
                $soma = 5;
            }
            if ($respostas[1] == "Sim") {
                $soma = $soma + 5;
            }
            if ($respostas[2] == "Sim") {
                $soma = $soma + 10;
            }
            if ($respostas[3] == "Sim") {
                $soma = $soma + 40;
            }
            if ($respostas[4] == "Sim") {
                $soma = $soma + 20;
            }
            if ($respostas[5] == "Sim") {
                $soma = $soma + 10;
            }
            if ($respostas[6] == "Sim") {
                $soma = $soma + 10;
            }
        } else {
            $eficacia->avaliacao = $respostas;
        }
        $eficacia->save();


        if ($aprovado == 'Sim') {
            $valores = new TableValores();
            if ($soma > 60) {

                $valor = $valores->findById(6)->valor;
            }

            $valor = $valor + $valores->findById(4)->valor;


            $abr = new AbrangenciaProjeto();

            $qtdabrangida = count($abr->find("idprojeto = $idproj")->fetch(true));

            if ($qtdabrangida == 2) {

                $valor = $valor + $valores->findById(2)->valor;
            } elseif ($qtdabrangida >= 3) {
                $valor = $valor + $valores->findById(2)->valor;
                $valor = $valor + $valores->findById(3)->valor;
            }
        $projeto = (new Project())->findById($idproj);


        $value = $valores->find("idfoco = $projeto->idFoco")->fetch(true);
        foreach ($value as $item)

            if ($item->idfoco == $projeto->idFoco) {
                $valor = $valor + $item->valor;
            }
        } elseif ($aprovado == 'Não') {
            $valor = 0;
        }
        $projeto = (new Project())->findById($idproj);
        $projeto->ValorProjeto = $valor;
        $projeto->Status = 5;
        $projeto->save();

        header("location: index.php");
    }
}