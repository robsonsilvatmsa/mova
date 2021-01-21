<?php

namespace Cadastros\grupos;
require_once("../../vendor/autoload.php");

use DateTimeZone;
use Source\models\Group;
use Source\models\UserGroup;

require_once('../../config.php');
require_once(DBAPI);

/**
 * class functions
 * para declarar as funções a
 * serem utilizadas para cadastrar um grupo
 * e adicionar os mesmos.
 * e deletar quando necessário
 * @author robson.silva
 */
class functions
{
    private $fim;

    public function __construct()
    {

    }

    public function index()
    {

    }

    public function grupos()
    {
        $consulta = find_all("Grupo");
        return $consulta;
    }

    public function count($id)
    {
        $count = find_query("select count(id) result from usuariogrupo where idgrupo = $id");
        if ($count > 0) {
            foreach ($count as $ctn)
                return $ctn['result'];
        } else {
            return 0;
        }
    }


    public function save()
    {

        if (!empty($_POST['namegroup'])) {

            $descricao = "'" . $_POST['namegroup'] . "'";
            $grupo = new Group();
            $nomegrupo = $grupo->find("name_group = $descricao")->fetch(true);

            if (!empty($nomegrupo)) {

                echo '<script language="javascript">';
                echo "alert('Nome do Grupo Existente Escolha outro!!!!');";  //not showing an alert box.
                echo "javascript:window . location = 'add.php';</script > ";

            } else {
                $group["name_group"] = $_POST['namegroup'];
                $group["created"] = date_format(date_create('now', new DateTimeZone('America/Sao_Paulo')), "Y - m - d");
                $group["multiproj"] = 0;
                save("Grupo", $group);

                $consultagrupo = find_query("select max(id) as id from Grupo");

                foreach ($consultagrupo as $gr) {
                    $idgrupo = $gr['id'];
                }

                if (!empty($_POST['idmember1'])) {
                    $usuariogrupo['idgrupo'] = $idgrupo;
                    $usuariogrupo['idusuario'] = $_POST['idmember1'];
                    $usuariogrupo["date_include"] = date_format(date_create('now', new DateTimeZone('America/Sao_Paulo')), "Y - m - d");
                    save("usuariogrupo", $usuariogrupo);

                    $acesso["idseguranca"] = 3;
                    $acesso["idusuarios"] = $_POST['idmember1'];
                    $acesso["ativo"] = 1;

                    save("acessos", $acesso);

                }
                if (!empty($_POST['idmember2'])) {
                    $usuariogrupo['idgrupo'] = $idgrupo;
                    $usuariogrupo['idusuario'] = $_POST['idmember2'];
                    $usuariogrupo["date_include"] = date_format(date_create('now', new DateTimeZone('America/Sao_Paulo')), "Y - m - d");
                    save("usuariogrupo", $usuariogrupo);
                    $acesso["idseguranca"] = 3;
                    $acesso["idusuarios"] = $_POST['idmember2'];
                    $acesso["ativo"] = 1;
                    save("acessos", $acesso);
                }
                if ($_POST['idmember3'] <> '') {
                    $usuariogrupo['idgrupo'] = $idgrupo;
                    $usuariogrupo['idusuario'] = $_POST['idmember3'];
                    $usuariogrupo["date_include"] = date_format(date_create('now', new DateTimeZone('America/Sao_Paulo')), "Y - m - d");
                    save("usuariogrupo", $usuariogrupo);
                    $acesso["idseguranca"] = 3;
                    $acesso["idusuarios"] = $_POST['idmember3'];
                    $acesso["ativo"] = 1;
                    save("acessos", $acesso);
                }
                if ($_POST['idmember4'] <> '') {
                    $usuariogrupo['idgrupo'] = $idgrupo;
                    $usuariogrupo['idusuario'] = $_POST['idmember4'];
                    $usuariogrupo["date_include"] = date_format(date_create('now', new DateTimeZone('America/Sao_Paulo')), "Y - m - d");
                    save("usuariogrupo", $usuariogrupo);
                    $acesso["idseguranca"] = 3;
                    $acesso["idusuarios"] = $_POST['idmember4'];
                    $acesso["ativo"] = 1;
                    save("acessos", $acesso);
                }
                if ($_POST['idmember5'] <> '') {
                    $usuariogrupo['idgrupo'] = $idgrupo;
                    $usuariogrupo['idusuario'] = $_POST['idmember5'];
                    $usuariogrupo["date_include"] = date_format(date_create('now', new DateTimeZone('America/Sao_Paulo')), "Y - m - d");
                    save("usuariogrupo", $usuariogrupo);
                    $acesso["idseguranca"] = 3;
                    $acesso["idusuarios"] = $_POST['idmember5'];
                    $acesso["ativo"] = 1;
                    save("acessos", $acesso);
                }
                if ($_POST['idmember6'] <> '') {
                    $usuariogrupo['idgrupo'] = $idgrupo;
                    $usuariogrupo['idusuario'] = $_POST['idmember6'];
                    $usuariogrupo["date_include"] = date_format(date_create('now', new DateTimeZone('America/Sao_Paulo')), "Y - m - d");
                    save("usuariogrupo", $usuariogrupo);
                    $acesso["idseguranca"] = 3;
                    $acesso["idusuarios"] = $_POST['idmember6'];
                    $acesso["ativo"] = 1;
                    save("acessos", $acesso);
                }

                header("location: index.php");
            }
        }
    }


    public function deletegroup($id)
    {
        $this->fim = false;
        $group = new Group();
        $groups = $group->findById($id);

        $user = new UserGroup;

        /** @var TYPE_NAME $usgorup */
        $usgorup = $user->find("idgrupo = $id")->fetch(true);


        foreach ($usgorup as $users) {
            $users->destroy();
            $this->fim = true;
        }

        if ($this->fim == true) {
            $groups->destroy();
        }
        return true;

    }

    public function adduser(string $iduser, string $idgroup)
    {
        $usuariogrupo['idgrupo'] = $idgroup;
        $usuariogrupo['idusuario'] = $iduser;
        $usuariogrupo["date_include"] = date_format(date_create('now', new DateTimeZone('America/Sao_Paulo')), "Y - m - d");


        $acesso["idseguranca"] = 3;
        $acesso["idusuarios"] = $iduser;
        $acesso["ativo"] = 1;

        save("acessos", $acesso);

        save("usuariogrupo", $usuariogrupo);
        header("location: edit.php?id=$idgroup");

    }

    public function editname($idgroup, $name_group)
    {
        $namegroup["name_group"] = $name_group;

        update("grupo", $idgroup, $namegroup);
        header("location: index.php");

    }

    public function deleteusuario($iduser)
    {
        $usergroup = new UserGroup;

        $usersgorup = $usergroup->findById($iduser);
        $usersgorup->destroy();

        return true;
    }

    public function liberamulti($id, $multiproj)
    {
        $group = (new Group())->findById($id);
        $group->multiproj = $multiproj;
        $group->save();

        //var_dump($group);

    }
}
