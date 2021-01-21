<?php

namespace Projeto\inclusao;

use Source\models\AbrangenciaProjeto;
use Source\models\Anexos;
use Source\models\EspinhaPeixeProj;
use Source\models\Group;
use Source\models\Porques;
use Source\models\Project;
use Source\models\User;
use Source\models\UserGroup;
use Source\support\SendMail;

require_once("../../vendor/autoload.php");
require_once('../../config.php');
require_once(DBAPI);

/**
 * class functions
 * para declarar as funções a
 * serem utilizadas para cadastrar um usuário
 * @author robson.silva
 */
class functions
{

    private $now;

    public function save($idGroup, $idArea, $idFocus, $Description, $Solution, $GroupExecute, $NecessaryInvestment,
                         $DateInitial, $ValueInvestment, $idanexo, $idabrangencia)
    {
        $project = new Project();

        $project->idGrupo = $idGroup;
        $project->idArea = $idArea;
        $project->idFoco = $idFocus;
        $project->Descricao = $Description;
        $project->SolucaoProposta = $Solution;
        $project->GrupoExecuta = $GroupExecute;
        $project->NecessitaInvestimento = $NecessaryInvestment;
        $project->DataInicio = $DateInitial;
        $project->Status = "0";
        $project->ValorInvestimento = $ValueInvestment;
        $project->save();


        for ($i = 0; $i <= count($idabrangencia) - 1; $i++) {
            $abrang = new AbrangenciaProjeto();
            $abrang->idarea = $idabrangencia[$i];
            $abrang->idprojeto = $project->id;
            $abrang->save();
        }

        $anexos = new Anexos();
        $anex = $anexos->find("idProvisorio = '$idanexo'")->fetch(true);
        foreach ($anex as $anexo) {
            $idanx = $anexo->id;
            $anx = (new Anexos())->findById($idanx);
            $anx->idProvisorio = $project->id;
            $anx->save();
            var_dump($anx);
        }


        $enviar = new SendMail();

        $member = new UserGroup();
        $group = new Group();

        $user = new User();

        $grupo = $group->find("name_group like 'Admin%'")->fetch(true);

        foreach ($grupo as $gr)
            $members = $member->find("idgrupo = $gr->id")->fetch(true);


        foreach ($members as $memb) {
            $users = $user->findById($memb->idusuario);

            if (!empty($to)) {
                $to .= ',';
                $to .= $users->email;
            } else {
                $to = $users->email;
            }
        }

        $menssagem = '
            <tr><td style="text-align: center;">Aviso</td></tr>
            <tr style="text-align: center;">
            <td>' . utf8_decode('Caro Administrador foi  Incluido um novo Projeto, N°:'
                . sprintf('%08d', $project->id) . '. 
            Entre no sistema para analisar e enviar para o fluxo de aprovação') . '</td>';


        $enviar->disparaEmail($to, $menssagem, "Novo Projeto Incluido");
        header("location: /movadev/Projeto");
    }

}