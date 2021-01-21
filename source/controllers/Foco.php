<?php


namespace Source\controllers;
require_once("../../vendor/autoload.php");

use DateTimeZone;
use Source\models\Focus;

require_once('../../config.php');
require_once(DBAPI);
//require_once ('../models/Focus.php');


/**
 * Controlador para a area foco onde irá gravar editar
 * e excluir os itens.
 *
 * @author robson.silva
 */
class Foco
{
    /**
     * Foco constructor.
     */
    public function __construct()
    {
    }

    public function grupos()
    {
        $consulta = find_all("Foco");
        return $consulta;
    }

    public function count($id)
    {
        $count = find_query("select * from grupos where id = $id");
        return $count;
    }

    /**
     * função salvar um novo foco na tabela
     */
    public function save($name)
    {
        $focus = new Focus();
        $focus->focus_description = $name;
        $focus->save();
        header("location: index.php");
    }

    public function updatefoco(string $idfoco, string $focusdescription)
    {
        $focus = (new Focus())->findById($idfoco);
        $focus->focus_description = $focusdescription;
        $focus->save();
        header("location: index.php");
    }

    public function deletefoco($id)
    {
        $this->fim = false;
        $group = new Focus();
        $groups = $group->findById($id);
        $groups->destroy();

        return true;

    }

}
