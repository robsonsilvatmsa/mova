<?php


namespace Source\controllers;
require_once("../../vendor/autoload.php");

use DateTimeZone;
use Source\models\TableValores;

require_once('../../config.php');
require_once(DBAPI);

class Valores
{
    public function update($valor, $idfoco, $id)
    {

        $valores = (new TableValores())->findById($id);
        $valores->valor = $valor;
        if (!empty($idfoco)) {
            $valores->idfoco = $idfoco;
        }
        $valores->save();

        header("location: index.php");

    }
}