<?php

namespace Melhoria\inclusao;

use Source\models\Anexos;
use Source\models\Group;
use Source\models\Melhoria;
use Source\models\AbrangenciaMelhoria;
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

    public function salvar($descricao, $solucao, $idgrupo, $idfoco, $idareaimplantada, $grupoexecuta, $necessitainvestimento,
                           $datainicio, $valorinvestimento, $idanexo, $idabrangencia)
    {
        $to = '';
        $mel = new Melhoria();
        $mel->Descricao = $descricao;
        $mel->SolucaoProposta = $solucao;
        $mel->DataInicio = $datainicio;
        $mel->IdGrupo = $idgrupo;
        $mel->IdFoco = $idfoco;
        $mel->IdAreaImplantada = $idareaimplantada;
        $mel->GrupoExecuta = $grupoexecuta;
        $mel->NecessitaInvestimento = $necessitainvestimento;
        $mel->ValorInvestimento = $valorinvestimento;
        $mel->IdAnexo = $idanexo;
        $mel->status = 0;
        $mel->save();


        for ($i = 0; $i <= count($idabrangencia) - 1; $i++) {
            if ($idabrangencia[$i] == $idareaimplantada) {
                continue;
            } else {
                $abrang = new AbrangenciaMelhoria();
                $abrang->idarea = $idabrangencia[$i];
                $abrang->idmelhoria = $mel->id;
                $abrang->save();
            }
        }

        $anexos = new Anexos();
        $anex = $anexos->find("idProvisorio = '$idanexo'")->fetch(true);
        foreach ($anex as $anexo) {
            $idanx = $anexo->id;
            $anx = (new Anexos())->findById($idanx);
            $anx->idProvisorio = $mel->id;
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
<tr>
<td style="text-align: center;">Aviso</td>
</tr>
<tr style="text-align: center;">
<td>' . utf8_decode('Caro Administrador foi  Incluido uma nova Melhoria, N°:' . sprintf('%08d', $mel->id) . '. 
Entre no sistema para analisar e enviar para o fluxo de aprovação') . '</td>
';


        $enviar->disparaEmail($to, $menssagem, "Nova Melhoria Incluida");

        header("location: /movadev/melhoria");

    }

}
