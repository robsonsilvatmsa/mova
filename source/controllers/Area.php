<?php


namespace Source\controllers;

use Source\models\TableArea;
use Source\models\UserArea;


require_once("../../vendor/autoload.php");
require_once('../../config.php');
require_once(DBAPI);

/**
 * Class Area
 * @package Source\controllers
 * salva, edita e exclui as areas do mova que também são utilizadas para aprovar as melhorias e projetos.
 */

class Area
{

    private $fim;


    public function __construct()
    {
    }

    public function save($description, $iduser)
    {
        $area = new TableArea();
        $area->description_area = $description;
        $area->save();


        for ($i = 0; $i <= count($iduser) - 1; $i++) {
            $userarea = new UserArea();
            $userarea->idarea = $area->id;
            $userarea->idusuario = $iduser[$i];
            $userarea->save();
        }

        header("location:index.php");

    }

    public function deleteusuario($iduser)
    {
        $usergroup = new UserArea();

        $usersgorup = $usergroup->findById($iduser);
        $usersgorup->destroy();

        return true;
    }

    public function saveuser($idarea, $iduser)
    {
        $userarea = new UserArea();
        $userarea->idarea = $idarea;
        $userarea->idusuario = $iduser;
        $userarea->save();

        header("location: edit.php?id=$idarea");
    }

    public function editname($idarea, $description)
    {
        $focus = (new TableArea())->findById($idarea);
        $focus->description_area = $description;
        $focus->save();
        header("location: index.php");
    }

    public function deletearea($id)
    {
        $this->fim = false;
        $group = new TableArea();
        $groups = $group->findById($id);

        $user = new UserArea();

        /** @var TYPE_NAME $usgorup */
        $usgorup = $user->find("idarea=$id")->fetch(true);


        foreach ($usgorup as $users) {
            $users->destroy();
            $this->fim = true;
        }

        if ($this->fim == true) {
            $groups->destroy();
        }
        return true;

    }
}
