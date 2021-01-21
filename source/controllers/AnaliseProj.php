<?php


namespace Source\controllers;


use Source\models\AnaliseDoProjeto;
use Source\models\Project;
use Source\models\ProjectAnalyzer;
use Source\models\User;
use Source\models\UserArea;
use Source\models\UserGroup;
use Source\support\SendMail;

require_once("../../vendor/autoload.php");
require_once('../../config.php');
require_once(DBAPI);

class AnaliseProj
{
    public function save($idprojeto, $area, $observacao, $motivorejeicao, $aprovado, $analisador)
    {
        $to = '';

        $query = "select top 1 A.* from AnalisadorProjeto as A,AnalisadorProjeto as B 
        where A.status = 0 and B.status = 1 and A.sequencia > B.sequencia 
        and a.idprojeto = b.idprojeto and A.idprojeto = $idprojeto";

        $analisadores = find_query($query);

        //var_dump($query);

        if (!empty($analisadores)) {
            /**
             * quando a melhoria é aprovada e existe proximo aprovador.
             */

            foreach ($analisadores as $analis) {
                $this->idanalisadores = $analis['id'];
            }

            $analise = new AnaliseDoProjeto();
            $analise->analisador = $analisador;
            $analise->observacao = $observacao;
            $analise->motivorejeicao = $motivorejeicao;
            $analise->aprovado = $aprovado;
            $analise->idAnalisador = $this->idanalisadores;
            $analise->save();


            if (strtolower($aprovado) == 'sim') {
                $improvement = (new ProjectAnalyzer())->findById($this->idanalisadores);
                $improvement->status = 1;
                $improvement->save();


                $send = new SendMail();
                $improvement = new ProjectAnalyzer();
                $analisador = $improvement->find("idprojeto = $idprojeto and status = 0", "top 1",
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

                    $melhoria = new Project();
                    $mel = $melhoria->findById($idprojeto);
                    $mel->Status = 2;
                    $mel->save();

                    $group = new UserGroup();
                    $usergroup = $group->find("idgrupo = $mel->idGrupo")->fetch(true);

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
                                    <td>' . utf8_decode('Caro Grupo Seu Projeto, N°:' . sprintf('%08d', $idprojeto) . '. 
                                    foi aprovado, entre no sistema para ver as informações sobre ele.') . '</td>
                                  ';

                    $send->disparaEmail($to, $menssagem, "Projeto Aprovado");
                } else {
                    $menssagem = '
                                    <tr>
                                    <td style="text-align: center;">Aviso</td>
                                    </tr>
                                    <tr style="text-align: center;">
                                    <td>' . utf8_decode('Caro Analisador foi  Incluido um novo Projeto, N°:' . sprintf('%08d',
                                $idprojeto) . '. 
                                    Entre no sistema para analisar e enviar para o fluxo de aprovação') . '</td>
                                  ';

                    $send->disparaEmail($to, $menssagem, "Novo Projeto Incluido");
                }


                header("location: index.php");
            } else {
                /**
                 * Entra aqui quando recusa a melhoria
                 */
                $improvement = (new ProjectAnalyzer())->findById($this->idanalisadores);
                $improvement->status = 2;
                $improvement->save();


                $analise = new AnaliseDoProjeto();
                $analise->analisador = $analisador;
                $analise->observacao = $observacao;
                $analise->motivorejeicao = $motivorejeicao;
                $analise->aprovado = $aprovado;
                $analise->idAnalisador = $this->idanalisadores;
                $analise->save();


                $send = new SendMail();

                $melhoria = (new Project())->findById($idprojeto);
                $melhoria->Status = 4;
                $melhoria->save();

                $group = new UserGroup();
                $usergroup = $group->find("idgrupo = $melhoria->idGrupo")->fetch(true);

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
                                    <td>' . utf8_decode('Caro Grupo Seu Projeto, N°:' . sprintf('%08d', $idprojeto) . '.
                                    foi recusado, entre no sistema para ver as informações sobre ele.') . '</td>
                                  ';

                if (!empty($to)) {
                    $send->disparaEmail($to, $menssagem, "Projeto recusado");
                    //header("location: index.php");
                } else {
                    echo $to;
                    // header("location: index.php");
                }
            }


        } else {
            /**
             * quando aprova a melhoria e não localiza uma seqyencia.
             */
            $analisadores = new ProjectAnalyzer();
            $nalise = $analisadores->find("idprojeto = $idprojeto and status = 0 and sequencia = 1 and idarea = $area ")->fetch(true);

            if (!empty($nalise)) {
                /**
                 * quando a melhoria identifica que era o primeiro analisador a avaliar
                 */
                foreach ($nalise as $value) {
                    $this->idanalisadores = $value->id;
                }

                if (strtolower($aprovado) == 'sim') {
                    $improvement = (new ProjectAnalyzer())->find("idprojeto = $idprojeto and status = 0 and sequencia = 1 and idarea = $area ")->fetch();
                    $improvement->status = 1;
                    $improvement->save();


                    $analise = new AnaliseDoProjeto();
                    $analise->analisador = $analisador;
                    $analise->observacao = $observacao;
                    $analise->motivorejeicao = $motivorejeicao;
                    $analise->aprovado = $aprovado;
                    $analise->idAnalisador = $this->idanalisadores;
                    $analise->save();


                    $analisadores = find_query($query);
                    if (empty($analisadores)) {
                        $send = new SendMail();

                        $melhoria = new Project();
                        $mel = $melhoria->findById($idprojeto);
                        $mel->Status = 2;
                        $mel->save();
                        var_dump($idprojeto);
                        echo '<br>';
                        var_dump($mel->data());

                        $group = new UserGroup();
                        $usergroup = $group->find("idgrupo = $mel->idGrupo")->fetch(true);

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
                                    <td>' . utf8_decode('Caro Grupo Seu Projeto, N°:' . sprintf('%08d', $idprojeto) . '. 
                                    foi aprovado, entre no sistema para ver as informações sobre ele.') . '</td>
                                  ';

                        $send->disparaEmail($to, $menssagem, "Projeto Aprovado");
                        header("location: index.php");
                    } else {
                        $send = new SendMail();
                        $improvement = new ProjectAnalyzer();
                        $analisador = $improvement->find("idprojeto = $idprojeto and status = 0", "top 1",
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
                                    <td>' . utf8_decode('Caro Analisador foi  Incluido um novo Projeto, N°:' . sprintf('%08d',
                                    $idprojeto) . '. 
                                    Entre no sistema para analisar e enviar para o fluxo de aprovação') . '</td>
                                  ';

                        $send->disparaEmail($to, $menssagem, "Novo Projeto Incluido");
                        header("location: index.php");
                    }

                } else {
                    /**
                     * Entra aqui quando recusa a melhoria
                     */


                    $improvement = (new ProjectAnalyzer())->findById($this->idanalisadores);
                    $improvement->status = 2;
                    $improvement->save();

                    $send = new SendMail();


                    $analise = new AnaliseDoProjeto();
                    $analise->analisador = $analisador;
                    $analise->observacao = $observacao;
                    $analise->motivorejeicao = $motivorejeicao;
                    $analise->aprovado = $aprovado;
                    $analise->idAnalisador = $this->idanalisadores;
                    $analise->save();


                    $melhoria = new Project();
                    $mel = $melhoria->findById($idprojeto);
                    $mel->Status = 4;
                    $mel->save();

                    $group = new UserGroup();
                    $usergroup = $group->find("idgrupo = $mel->idGrupo")->fetch(true);

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
                                    <td>' . utf8_decode('Caro Grupo Seu Projeto, N°:' . sprintf('%08d', $idprojeto) . '. 
                                    foi recusado, entre no sistema para ver as informações sobre ele.') . '</td>
                                  ';

                    if (!empty($to)) {
                        $send->disparaEmail($to, $menssagem, "Projeto recusado");
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
                $improvement = (new ProjectAnalyzer())->findById($area);
                $improvement->status = 1;
                $improvement->save();


                $analise = new AnaliseDoProjeto();
                $analise->analisador = $analisador;
                $analise->observacao = $observacao;
                $analise->motivorejeicao = $motivorejeicao;
                $analise->aprovado = $aprovado;
                $analise->idAnalisador = $this->idanalisadores;
                $analise->save();


                $send = new SendMail();

                $melhoria = new Project();
                $mel = $melhoria->findById($idprojeto);
                $mel->Status = 2;
                $mel->save();

                $group = new UserGroup();
                $usergroup = $group->find("idgrupo = $mel->idGrupo")->fetch(true);

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
                                    <td>' . utf8_decode('Caro Grupo Seu Projeto, N°:' . sprintf('%08d', $idprojeto) . '. 
                                    foi aprovado, entre no sistema para ver as informações sobre ele.') . '</td>
                                  ';

                $send->disparaEmail($to, $menssagem, "Projeto Aprovado");


                header("location: index.php");
            }
        }
    }

}
