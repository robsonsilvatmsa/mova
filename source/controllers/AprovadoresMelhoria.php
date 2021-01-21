<?php


namespace Source\controllers;

use Source\models\ImprovementAnalyzer;
use Source\models\Melhoria;
use Source\models\User;

use Source\models\UserArea;
use Source\support\SendMail;

require_once("../../vendor/autoload.php");
require_once('../../config.php');
require_once(DBAPI);

class AprovadoresMelhoria
{
    /**
     * @param $idmelhoria
     * @param $idarea
     * @param $sequencia
     * cadastra os analisadores das melhorias(Fluxo de Aprovação).
     */

    public function save($idmelhoria, $idarea, $sequencia)
    {

        for ($i = 0; $i <= count($sequencia); $i++) {
            $Analyzer = new ImprovementAnalyzer();
            $Analyzer->idmelhoria = $idmelhoria;
            $Analyzer->idarea = $idarea[$i];
            $Analyzer->sequencia = $sequencia[$i];
            $Analyzer->status = 0;
            $Analyzer->save();
        }

        var_dump($Analyzer);

        $enviar = new SendMail();

        $member = new UserArea();

        $melhoria = (new Melhoria())->findById($idmelhoria);
        $melhoria->status = 1;
        $melhoria->save();

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
<td>' . utf8_decode('Caro Analisador foi  Incluido uma nova Melhoria, N°:' . sprintf('%08d', $idmelhoria) . '. 
Entre no sistema para analisar e enviar para o fluxo de aprovação') . '</td>
';


        $enviar->disparaEmail($to, $menssagem, "Nova Melhoria Incluida");

        header("location: index.php");
    }

    public function update($idmelhoria, $idarea, $sequencia, $id)
    {


        for ($i = 0; $i <= count($sequencia) - 1; $i++) {
            $ids = $id[$i];

            if (!empty($ids)) {
                $Analyzer = (new ImprovementAnalyzer())->findById($ids);
            } else {
                $Analyzer = new ImprovementAnalyzer();
            }

            $Analyzer->idmelhoria = $idmelhoria;
            $Analyzer->idarea = $idarea[$i];
            $Analyzer->sequencia = $sequencia[$i];
            $Analyzer->status = 0;
            $Analyzer->save();
        }

        var_dump($Analyzer);

        $enviar = new SendMail();

        $member = new UserArea();

        $melhoria = (new Melhoria())->findById($idmelhoria);
        $melhoria->status = 1;
        $melhoria->save();

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
<td>' . utf8_decode('Caro Analisador foi  Incluido uma nova Melhoria, N°:' . sprintf('%08d', $idmelhoria) . '. 
Entre no sistema para analisar e enviar para o fluxo de aprovação') . '</td>
';


        $enviar->disparaEmail($to, $menssagem, "Nova Melhoria Incluida");
        header("location: melhoriasemanalise.php");
    }

    public function delete($id)
    {
        $analise = (new ImprovementAnalyzer())->findById($id);
        $analise->destroy();
    }
}
