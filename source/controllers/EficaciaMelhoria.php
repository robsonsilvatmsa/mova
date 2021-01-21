<?php


namespace Source\controllers;

use Source\models\AbrangenciaMelhoria;
use Source\models\TableEficaciaMelhoria;
use Source\models\Melhoria;
use Source\models\TableValores;


require_once("../../vendor/autoload.php");
require_once('../../config.php');
require_once(DBAPI);


class EficaciaMelhoria
{
    public function save($aprovado, $parecer, $respostas, $idmel)
    {
        $soma = 0;
        $valor = 0;
        $eficacia = new TableEficaciaMelhoria();
        $eficacia->aprovado = $aprovado;
        $eficacia->parecer = $parecer;
        $eficacia->idmelhoria = $idmel;
        if (count($respostas) >= 4) {
            $eficacia->ResultadoMel = $respostas[0];
            $eficacia->ResultadoGrupo = $respostas[1];
            $eficacia->Abrangencia = $respostas[2];
            $eficacia->Inovacao = $respostas[3];


            if ($respostas[0] == "Sim") {
                $soma = 20;
            }
            if ($respostas[1] == "Sim") {
                $soma = $soma + 40;
            }
            if ($respostas[2] == "Sim") {
                $soma = $soma + 20;
            }
            if ($respostas[3] == "Sim") {
                $soma = $soma + 20;
            }
        } else {
            $eficacia->avaliacao = $respostas;
        }
        $eficacia->save();

        if($aprovado == 'Sim'){
            $valores = new TableValores();

            if ($soma > 60) {

                $valor = $valores->findById(7)->valor;
            }

            $valor = $valor + $valores->findById(1)->valor;

            $abr = new AbrangenciaMelhoria();

            $qtdabrangida = count($abr->find("idmelhoria = $idmel")->fetch(true));

            if ($qtdabrangida == 2) {

                $valor = $valor + $valores->findById(2)->valor;
            } elseif ($qtdabrangida >= 3) {
                $valor = $valor + $valores->findById(2)->valor;
                $valor = $valor + $valores->findById(3)->valor;
            }
        }elseif ($aprovado == 'Não'){
            $valor = 0;
        }

        $melhoria = (new Melhoria())->findById($idmel);
        $melhoria->ValorMelhoria = $valor;
        $melhoria->status = 5;
        $melhoria->save();

        header("location: index.php");

    }

}