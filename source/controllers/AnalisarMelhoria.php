<?php


namespace Source\controllers;


use Source\models\AnaliseDaMelhoria;
use Source\models\ImprovementAnalyzer;
use Source\models\Melhoria;
use Source\models\User;
use Source\models\UserArea;
use Source\models\UserGroup;
use Source\support\SendMail;

require_once("../../vendor/autoload.php");
require_once('../../config.php');
require_once(DBAPI);

class AnalisarMelhoria
{
    /**
     * @param $idmelhoria
     * @param $area
     * @param $observacao
     * @param $motivorejeicao
     * @param $aprovado
     * @param $analisador
     * classe para efetuar as regras de negocio para analise da melhoria.
     *
     * status da aprovação
     * 0=>Pendente
     * 1=>Aprovado
     * 2=>Rejeitado
     *
     * status da melhoria
     * 0=>Aguardando Adm
     * 1=>Em Analise
     * 2=>Aprovado
     * 3=>Finalizado
     * 4=>Rejeitado
     */
    private $idanalisadores;

    public function save($idmelhoria, $area, $observacao, $motivorejeicao, $aprovado, $analisador)
    {
        $to = '';

        $query = "select top 1 A.* from AnalisadorMelhoria as A,AnalisadorMelhoria as B 
        where A.status = 0 and B.status = 1 and A.sequencia > B.sequencia 
        and a.idmelhoria = b.idmelhoria and  A.idmelhoria = $idmelhoria";

        $analisadores = find_query($query);

        //var_dump($query);

        if (!empty($analisadores)) {
            /**
             * quando a melhoria é aprovada e existe proximo aprovador.
             */

            foreach ($analisadores as $analis) {
                $this->idanalisadores = $analis['id'];
            }
            try {
                $analise = new AnaliseDaMelhoria();
                $analise->analisador = $analisador;
                $analise->observacao = $observacao;
                $analise->motivorejeicao = $motivorejeicao;
                $analise->aprovado = $aprovado;
                $analise->idAnalisador = $this->idanalisadores;
                $analise->save();
            } catch (Exception $e) {
                var_dump($e->getMessage());
            }

            if (strtolower($aprovado) == 'sim') {
                $improvement = (new ImprovementAnalyzer())->findById($this->idanalisadores);
                $improvement->status = 1;
                $improvement->save();


                $send = new SendMail();
                $improvement = new ImprovementAnalyzer();
                $analisador = $improvement->find("idmelhoria = $idmelhoria and status = 0", "top 1",
                    "idarea")->fetch(true);
                foreach ($analisador as $item) {
                    $idarea = $item->idarea;
                }

                $tabelaarea = new UserArea();

                $tableare = $tabelaarea->find(" idarea = $idarea")->fetch(true);

                $user = new User();

                foreach ($tableare as $memb) {
                    $users = $user->findById($memb->idusuario);

                    if (!empty($to)) {
                        $to .= ',';
                        $to .= $users->email;
                    } else {
                        $to = $users->email;
                    }
                }
                $analisadores = find_query($query);
                if (empty($analisadores)) {
                    $send = new SendMail();

                    $melhoria = new Melhoria();
                    $mel = $melhoria->findById($idmelhoria);
                    $mel->status = 2;
                    $mel->save();

                    $group = new UserGroup();
                    $usergroup = $group->find("idgrupo = $mel->IdGrupo")->fetch(true);

                    $user = new User();

                    foreach ($usergroup as $memb) {
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
                                    <td>' . utf8_decode('Caro Grupo Sua Melhoria, N°:' . sprintf('%08d', $idmelhoria) . '. 
                                    foi aprovada, entre no sistema para ver as informações sobre ela.') . '</td>
                                  ';

                    $send->disparaEmail($to, $menssagem, "Melhoria Aprovada");
                }

                $menssagem = '
                                    <tr>
                                    <td style="text-align: center;">Aviso</td>
                                    </tr>
                                    <tr style="text-align: center;">
                                    <td>' . utf8_decode('Caro Analisador foi  Incluido uma nova Melhoria, N°:' . sprintf('%08d',
                            $idmelhoria) . '. 
                                    Entre no sistema para analisar e enviar para o fluxo de aprovação') . '</td>
                                  ';

                $send->disparaEmail($to, $menssagem, "Nova Melhoria Incluida");

                header("location: index.php");
            } else {
                /**
                 * Entra aqui quando recusa a melhoria
                 */
                $improvement = (new ImprovementAnalyzer())->findById($this->idanalisadores);
                $improvement->status = 2;
                $improvement->save();


                try {
                    $analise = new AnaliseDaMelhoria();
                    $analise->analisador = $analisador;
                    $analise->observacao = $observacao;
                    $analise->motivorejeicao = $motivorejeicao;
                    $analise->aprovado = $aprovado;
                    $analise->idAnalisador = $this->idanalisadores;
                    $analise->save();
                } catch (Exception $e) {
                    var_dump($e->getMessage());
                }

                $send = new SendMail();

                $melhoria = new Melhoria();
                $mel = $melhoria->findById($idmelhoria);
                $mel->status = 4;
                $mel->save();

                $group = new UserGroup();
                $usergroup = $group->find("idgrupo = $mel->IdGrupo")->fetch(true);

                var_dump($usergroup);

                $user = new User();

                foreach ($usergroup as $memb) {
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
                                    <td>' . utf8_decode('Caro Grupo Sua Melhoria, N°:' . sprintf('%08d', $idmelhoria) . '.
                                    foi recusada, entre no sistema para ver as informações sobre ela.') . '</td>
                                  ';

                if (!empty($to)) {
                    $send->disparaEmail($to, $menssagem, "Melhoria recusada");
                    header("location: index.php");
                } else {
                    echo $to;
                    header("location: index.php");
                }
            }


        } else {
            /**
             * quando aprova a melhoria e não localiza uma seqyencia.
             */
            $analisadores = new ImprovementAnalyzer();
            $nalise = $analisadores->find("idmelhoria = $idmelhoria and status = 0 and sequencia = 1 and idarea = $area ")->fetch(true);

            if (!empty($nalise)) {
                /**
                 * quando a melhoria identifica que era o primeiro analisador a avaliar
                 */
                foreach ($nalise as $value) {
                    $this->idanalisadores = $value->id;
                }

                if (strtolower($aprovado) == 'sim') {
                    $improvement = (new ImprovementAnalyzer())->find("idmelhoria = $idmelhoria and status = 0 and sequencia = 1 and idarea = $area ")->fetch();
                    $improvement->status = 1;
                    $improvement->save();

                    try {
                        $analise = new AnaliseDaMelhoria();
                        $analise->analisador = $analisador;
                        $analise->observacao = $observacao;
                        $analise->motivorejeicao = $motivorejeicao;
                        $analise->aprovado = $aprovado;
                        $analise->idAnalisador = $this->idanalisadores;
                        $analise->save();
                    } catch (Exception $e) {
                        var_dump($e->getMessage());
                    }

                    $analisadores = find_query($query);
                    if (empty($analisadores)) {
                        $send = new SendMail();

                        $melhoria = new Melhoria();
                        $mel = $melhoria->findById($idmelhoria);
                        $mel->status = 2;
                        $mel->save();

                        $group = new UserGroup();
                        $usergroup = $group->find("idgrupo = $mel->IdGrupo")->fetch(true);

                        $user = new User();

                        foreach ($usergroup as $memb) {
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
                                    <td>' . utf8_decode('Caro Grupo Sua Melhoria, N°:' . sprintf('%08d', $idmelhoria) . '. 
                                    foi aprovada, entre no sistema para ver as informações sobre ela.') . '</td>
                                  ';

                        $send->disparaEmail($to, $menssagem, "Melhoria Aprovada");
                    }


                    $send = new SendMail();
                    $improvement = new ImprovementAnalyzer();
                    $analisador = $improvement->find("idmelhoria = $idmelhoria and status = 0", "top 1",
                        "idarea")->fetch(true);
                    foreach ($analisador as $item) {
                        $idarea = $item->idarea;
                    }

                    $tabelaarea = new UserArea();

                    $tableare = $tabelaarea->find(" idarea = $idarea")->fetch(true);

                    $user = new User();

                    foreach ($tableare as $memb) {
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
                                    <td>' . utf8_decode('Caro Analisador foi  Incluido uma nova Melhoria, N°:' . sprintf('%08d',
                                $idmelhoria) . '. 
                                    Entre no sistema para analisar e enviar para o fluxo de aprovação') . '</td>
                                  ';

                    $send->disparaEmail($to, $menssagem, "Nova Melhoria Incluida");
                    header("location: index.php");

                } else {
                    /**
                     * Entra aqui quando recusa a melhoria
                     */


                    $improvement = (new ImprovementAnalyzer())->findById($this->idanalisadores);
                    $improvement->status = 2;
                    $improvement->save();

                    $send = new SendMail();

                    try {
                        $analise = new AnaliseDaMelhoria();
                        $analise->analisador = $analisador;
                        $analise->observacao = $observacao;
                        $analise->motivorejeicao = $motivorejeicao;
                        $analise->aprovado = $aprovado;
                        $analise->idAnalisador = $this->idanalisadores;
                        $analise->save();
                    } catch (Exception $e) {
                        var_dump($e->getMessage());
                    }


                    $melhoria = new Melhoria();
                    $mel = $melhoria->findById($idmelhoria);
                    $mel->status = 4;
                    $mel->save();

                    $group = new UserGroup();
                    $usergroup = $group->find("idgrupo = $mel->IdGrupo")->fetch(true);

                    $user = new User();

                    foreach ($usergroup as $memb) {
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
                                    <td>' . utf8_decode('Caro Grupo Sua Melhoria, N°:' . sprintf('%08d', $idmelhoria) . '. 
                                    foi recusada, entre no sistema para ver as informações sobre ela.') . '</td>
                                  ';

                    if (!empty($to)) {
                        $send->disparaEmail($to, $menssagem, "Melhoria recusada");
                        header("location: index.php");
                    } else {
                        echo $to;
                        header("location: index.php");
                    }

                }
            } else {
                /**
                 * quando não existe mais aprovadores e a melhoria foi aprovada atualiza o status e envia para o grupo.
                 */
                $improvement = (new ImprovementAnalyzer())->findById($area);
                $improvement->status = 1;
                $improvement->save();

                try {
                    $analise = new AnaliseDaMelhoria();
                    $analise->analisador = $analisador;
                    $analise->observacao = $observacao;
                    $analise->motivorejeicao = $motivorejeicao;
                    $analise->aprovado = $aprovado;
                    $analise->idAnalisador = $this->idanalisadores;
                    $analise->save();
                } catch (Exception $e) {
                    var_dump($e->getMessage());
                }

                $send = new SendMail();

                $melhoria = new Melhoria();
                $mel = $melhoria->findById($idmelhoria);
                $mel->status = 2;
                $mel->save();

                $group = new UserGroup();
                $usergroup = $group->find("idgrupo = $mel->IdGrupo")->fetch(true);

                $user = new User();

                foreach ($usergroup as $memb) {
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
                                    <td>' . utf8_decode('Caro Grupo Sua Melhoria, N°:' . sprintf('%08d', $idmelhoria) . '. 
                                    foi aprovada, entre no sistema para ver as informações sobre ela.') . '</td>
                                  ';

                $send->disparaEmail($to, $menssagem, "Melhoria Aprovada");


                header("location: index.php");
            }
        }


    }
}
