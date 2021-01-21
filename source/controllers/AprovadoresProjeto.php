<?php


namespace Source\controllers;

use Source\models\Project;
use Source\models\ProjectAnalyzer;
use Source\models\User;

use Source\models\UserArea;
use Source\support\SendMail;

require_once("../../vendor/autoload.php");
require_once('../../config.php');
require_once(DBAPI);

class AprovadoresProjeto
{
    public function save($idprojeto, $idarea, $sequencia)
    {
        for ($i = 0; $i <= count($idarea) - 1; $i++) {
            $analisar = new ProjectAnalyzer();
            $analisar->idprojeto = $idprojeto;
            $analisar->idarea = $idarea[$i];
            $analisar->sequencia = $sequencia[$i];
            $analisar->status = "0";
            $analisar->save();
        }


        $project = (new Project())->findById($idprojeto);
        $project->Status = 1;
        $project->save();
        var_dump($project);

        $enviar = new SendMail();

        $member = new UserArea();

        $user = new User();

        $members = $member->find("idarea = $idarea[0]")->fetch(true);

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
            <tr>
            <td style="text-align: center;">Aviso</td>
            </tr>
            <tr style="text-align: center;">
            <td>' . utf8_decode('Caro Analisador foi  Incluido uma nova Melhoria, N°:' . sprintf('%08d', $idprojeto) . '. 
            Entre no sistema para analisar e enviar para o fluxo de aprovação') . '</td>
            ';


        $enviar->disparaEmail($to, $menssagem, "Nova Melhoria Incluida");

        header("location: index.php");

    }

    public function update($idprojeto, $idarea, $sequencia, $id)
    {
        for ($i = 0; $i <= count($idarea) - 1; $i++) {

            $ids = $id[$i];

            if (!empty($ids)) {
                $analisar = (new ProjectAnalyzer())->findById($ids);
            } else {
                $analisar = new ProjectAnalyzer();
            }

            $analisar->idprojeto = $idprojeto;
            $analisar->idarea = $idarea[$i];
            $analisar->sequencia = $sequencia[$i];
            $analisar->status = "0";
            $analisar->save();
        }


        $project = (new Project())->findById($idprojeto);
        $project->Status = 1;
        $project->save();
        var_dump($project);

        $enviar = new SendMail();

        $member = new UserArea();

        $user = new User();

        $members = $member->find("idarea = $idarea[0]")->fetch(true);

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
            <tr>
            <td style="text-align: center;">Aviso</td>
            </tr>
            <tr style="text-align: center;">
            <td>' . utf8_decode('Caro Analisador foi  Incluido uma nova Melhoria, N°:' . sprintf('%08d', $idprojeto) . '. 
            Entre no sistema para analisar e enviar para o fluxo de aprovação') . '</td>
            ';


        $enviar->disparaEmail($to, $menssagem, "Nova Melhoria Incluida");

        header("location: projetoemanalise.php");

    }

    public function delete($id)
    {
        $analise = (new ProjectAnalyzer())->findById($id);
        $analise->destroy();
    }
}
