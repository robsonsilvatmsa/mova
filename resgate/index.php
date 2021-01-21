<?php
require_once('../config.php');
require_once("../vendor/autoload.php");

use Source\controllers\ResgateMelhoria;
use Source\models\Group;
use Source\models\UserGroup;
use Source\models\User;
use Source\models\Melhoria;
use Source\models\Project;

$group = (new Group())->find()->fetch(true);

$resgate = new ResgateMelhoria();

$user = new User();

function descMelhoria($grupoid)
{
    $melhoria = new  Melhoria();
    return $melhoria->find("IdGrupo = $grupoid and status = 5 and resgatado < 1 or IdGrupo = $grupoid and status = 5 and resgatado is null")->fetch();
}

function descProjetos($grupoid)
{
    $projeto = new  Project();
    return $projeto->find("IdGrupo = $grupoid and status = 5 and resgatado < 1 or IdGrupo = $grupoid and status = 5 and resgatado is null  or IdGrupo = $grupoid status = 6 and resgatado < 1 or IdGrupo = $grupoid and status = 6 and resgatado is null")->fetch();
}

abresessao();
$_SESSION['menu'] = '';
?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Resgate Melhoria e Projeto</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Resgate Melhoria e Projeto</span></li>
            </ul>
            <p class="sidebar-right-toggle"></p>
        </div>

    </header>

    <section class="panel">

        <header class="panel-heading">
            <div class="panel-actions">

            </div>
            <h2 class="panel-title">Exportar dados para RH</h2>

        </header>
        <div class="panel-body">
            <a type="button" href="exportarcsv.php"
               class="mb-xs mt-xs mr-xs btn btn-primary">Exportar</a>

            <a type="button" href="resgatados.php"
               class="mb-xs mt-xs mr-xs btn btn-primary">Valores resgatados</a>

            <a type="button" href="resgatar.php"
               class="mb-xs mt-xs mr-xs btn btn-success">Resgatar Valores</a>
        </div>
    </section>
    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">

            </div>

            <h2 class="panel-title">Dados para o Resgate</h2>
        </header>
        <div class="panel-body">
            <div class="table-striped">
                <table class="table table-bordered table-striped mb-md" id="datatable-default">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Matricula</th>
                        <th>Grupo</th>
                        <th>Valor Projeto (Por Integrante)</th>
                        <th>Valor Total Grupo</th>
                        <th>Descrição valores</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($group): ?>
                        <?php foreach ($group as $grupo): ?>
                            <?php $UserGroup = (new UserGroup())->find("idgrupo = $grupo->id")->fetch(true); ?>

                            <?php if ($UserGroup): ?>
                                <?php $total = count($UserGroup);
                                if ($total < 3) {
                                    $total = 3;
                                }
                                ?>
                                <?php foreach ($UserGroup as $usergroup): ?>
                                    <?php if ((($resgate->melhoria($grupo->id) + $resgate->projeto($grupo->id)))): ?>
                                        <?php $valor = ($resgate->melhoria($grupo->id) + $resgate->projeto($grupo->id));
                                        $valoCada = $valor / $total;
                                        ?>
                                        <tr>
                                            <td><?= $usu = ($user->findById($usergroup->idusuario))->nome; ?></td>
                                            <td><?= $matricula = ($user->findById($usergroup->idusuario))->matricula; ?></td>
                                            <td><?= $grupo->name_group ?></td>
                                            <td><?= number_format(($valoCada), 2, ",", ".") ?></td>
                                            <td><?= number_format(($valor), 2, ",", "."); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-primary"
                                                        onclick="modal('<?= $usu ?>', <?= $matricula ?>,'<?= $grupo->name_group ?>', '<?= number_format(($valoCada), 2, ",", ".") ?>', '<?= $grupo->id ?>')"
                                                        data-toggle="modal" data-target="#exampleModal">
                                                    Ver detalhes
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <td colspan="10">
                            Não existe dados a listar
                        </td>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <header class="panel-heading">
                <div class="panel-actions">

                </div>

                <h2 class="panel-title">Dados Resgatados</h2>
            </header>
            <div class="table-striped">
                <table class="table table-bordered table-striped mb-md" id="datatable-default">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Matricula</th>
                        <th>Grupo</th>
                        <th>Valor Projeto (Por Integrante)</th>
                        <th>Valor Total Grupo</th>
                        <th>Descrição valores</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    //verifica se existe grupo
                    if ($group): ?>
                        <?php foreach ($group as $grupo): ?>
                            <?php
                            //retorna id do usuario, id do grupo, e data de inclusão do grupo expecificado.
                            $UserGroup = (new UserGroup())->find("idgrupo = $grupo->id")->fetch(true);
                            ?>
                            <?php if ($UserGroup): ?>
                                <?php $total = count($UserGroup);
                                if ($total < 3) {
                                    $total = 3;
                                }
                                ?>
                                <?php foreach ($UserGroup as $usergroup): ?>
                                    <?php
                                    //verifica se retorna valores na soma de valores de resgate melhoria + resgate projeto
                                    if ((($resgate->melhoriaResgatado($grupo->id) + $resgate->projetoResgatado($grupo->id)))): ?>
                                        <?php $valor = ($resgate->melhoriaResgatado($grupo->id) + $resgate->projetoResgatado($grupo->id));
                                        $valoCada = $valor / $total;
                                        ?>
                                        <tr>
                                            <td><?= $usu = ($user->findById($usergroup->idusuario))->nome; ?></td>
                                            <td><?= $matricula = ($user->findById($usergroup->idusuario))->matricula; ?></td>
                                            <td><?= $grupo->name_group ?></td>
                                            <td><?= number_format(($valoCada), 2, ",", ".") ?></td>
                                            <td><?= number_format(($valor), 2, ",", "."); ?></td>
                                            <td>
                                                <a class="btn btn-primary" href="detalhesResgatados.php?idgrupo=<?= $grupo->id ?>&nome=<?= $usu ?>&matricula=<?= $matricula ?>">
                                                    Ver detalhes
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <td colspan="10">
                            Não existe dados a listar
                        </td>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</section>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Valores para Resgate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row" style="border-style: solid; border-width: 1px; font-size: 20px; padding: 5px">
                    <div class="col-2 col-sm-1">Nome</div>
                    <div class="col-2 col-sm-5" id='nome'><b></b></div>
                    <div class="col-4 col-sm-2">Matricula</div>
                    <div class="col-6 col-sm-4" id="matricula"><b></b></div>
                </div>
                <div id="tblmelhorias">
                    <table class="table table-sm" id="melhorias">
                        <fildset>
                            <legend><h3 align="center">Melhoria</h3></legend>
                            <thead>
                            <tr style="color: #6c757d; font-size: 15px; background-color: #f2f1f1">
                                <th scope="col">Numero da Melhoria</th>
                                <th scope="col">Nome da Melhoria</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Data da Conclusão</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr id="trMelhoria">

                            </tr>
                            </tbody>
                        </fildset>
                    </table>
                </div>
                <div id="tblprojetos">
                    <table class="table table-sm" id="projetos">
                        <fildset>
                            <legend><h3 align="center">Projeto</h3></legend>
                            <thead>
                            <tr style="color: #6c757d; font-size: 15px; background-color: #f2f1f1">
                                <th scope="col">Numero do Projeto</th>
                                <th scope="col">Nome do Projeto</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Data da Conclusão</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr id="trProjeto">
                            </tr>
                            </tbody>
                        </fildset>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Fecha Modal -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function dataAtualFormatada() {
            var data = new Date(),
                dia = data.getDate().toString(),
                diaF = (dia.length == 1) ? '0' + dia : dia,
                mes = (data.getMonth() + 1).toString(), //+1 pois no getMonth Janeiro começa com zero.
                mesF = (mes.length == 1) ? '0' + mes : mes,
                anoF = data.getFullYear();
            return diaF + "/" + mesF + "/" + anoF;
        }

        function modal(user, matricula, grupo, valorcada, idgrupo) {
            console.log(user, matricula, grupo, valorcada, idgrupo);
            $.ajax({
                type: "GET",
                url: 'http://portal.tmsa.ind.br/mova/source/models/resgataValores.php?idgrupo=' + idgrupo,
                dataType: 'json',
                success: function (data) {
                    $('#nome').text(user);
                    $('#matricula').text(matricula);
                    console.log(data);
                    var qtdegrupo = data['qtdeGrupo'].length;

                    if (data['melhoria'] == "") {
                        $("#tblmelhorias").remove();
                    }else {
                        $.each(data['melhoria'], function (key, item) {
                            $('#melhorias').append("<tr class='trMelhoria' style='font-weight: unset; font-size: 15px'><th>" + ("00000000" + item.id).slice(-8) + "</th><th>" + item.Descricao + "</th><th>R$ " + (item.ValorMelhoria / qtdegrupo) + ",00</th><th>" + dataAtualFormatada(item.DataEncerramento) + "<th></tr>");
                        });
                    }
                    if (data['projeto'] == "") {
                        $("#tblprojetos").remove();
                    } else {
                        $.each(data['projeto'], function (key, item) {
                            $('#projetos').append("<tr class='trProjeto' style='font-weight: unset; font-size: 15px'><th>" + ("00000000" + item.id).slice(-8) + "</th><th>" + item.Descricao + "</th><th>R$ " + (item.ValorProjeto / qtdegrupo) + ",00</th><th>" + dataAtualFormatada(item.DataConclusao) + "<th></tr>");
                        });
                    }
                }
            });
        }

        $(document).ready(function () {
            $('#exampleModal').on('hidden.bs.modal', function () {
                $('.trProjeto').each(function () {
                    $('.trProjeto').remove();
                });
                $('.trMelhoria').each(function () {
                    $('.trMelhoria').remove();
                });
            });
        });

    </script>

    <?php include(FOOTER_TEMPLATE); ?>
