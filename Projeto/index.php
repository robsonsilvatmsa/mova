<?php
require_once('../config.php');
require_once("../vendor/autoload.php");
require_once("functions.php");
abresessao();

use Projeto\functions;
use Source\models\Project;
use Source\models\UserGroup;
use Source\models\TableEficaciaProjeto;

$idgrupo = $_SESSION['idgrupo'];
$function = new functions();

$usergroup = new UserGroup();
$user = $usergroup->find("idgrupo = $idgrupo")->fetch(true);

$function = new functions();

$Project = new Project();
$bloq = "";
$projetos = $Project->find("idGrupo = $idgrupo")->fetch(true);

if (!empty($projetos))
    foreach ($projetos as $projeto) {
        if ($projeto->Status == 0 || $projeto->Status == 1 || $projeto->Status == 2) {
            $group = (new \Source\models\Group())->findById($idgrupo);
            if ($group->multiproj == 1) {
                $bloq = "";
            } else {
                $bloq = "disabled";
            }
        }
    }

$total = 0;
//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Melhoria';
$_SESSION['codprovisorio'] = uniqid();
?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Cadastro de Projetos</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Projeto</span></li>
            </ul>
            <p class="sidebar-right-toggle"></p>
        </div>

    </header>

    <section class="panel">

        <header class="panel-heading">
            <div class="panel-actions">

            </div>
            <h2 class="panel-title">Projeto</h2>
        </header>
        <div class="panel-body">
            <a type="button" href="<?= BASEURL ?>projeto/inclusao"
               class="mb-xs mt-xs mr-xs btn btn-primary" <?= $bloq ?> >Projeto</a>
        </div>
    </section>
    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">

            </div>

            <h2 class="panel-title">Projetos</h2>
        </header>
        <div class="panel-body">
            <div class="table-striped">
                <table class="table table-bordered table-striped mb-md" id="datatable-default">
                    <thead>
                    <tr>
                        <th>Número Projeto</th>
                        <th>Descrição</th>
                        <th>Data Inclusão</th>
                        <th>Status</th>
                        <th>Valor Projeto (Por Integrante)</th>
                        <th>Valor Total Projeto</th>
                        <th>Eficaz</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($projetos): ?>
                        <?php foreach ($projetos as $value): ?>
                            <tr>
                                <td><?= sprintf('%08d', $value->id); ?></td>
                                <td><?= $value->Descricao; ?></td>
                                <td><?= date_format(date_create($value->DataInicio), "d/m/Y"); ?></td>
                                <td>
                                    <?php
                                    $status = $value->Status;
                                    if ($status == 0) {
                                        echo "Enviado para Analise";
                                    } elseif ($status == 1) {
                                        echo "Em Analise";
                                    } elseif ($status == 2) {
                                        echo "Aprovado";
                                    } elseif ($status == 3) {
                                        echo "Implantado";
                                    } elseif ($status == 4) {
                                        echo "Rejeitado";
                                    } elseif ($value->Status == 5) {
                                        echo "Avaliada Equipe Mova";
                                    } elseif ($value->Status == 6) {
                                        echo "Auditado Equipe Mova";
                                    }
                                    ?>
                                </td>
                                <td><?php
                                    $total = 0;
                                    $eficacia = (new TableEficaciaProjeto())->find("idprojeto = $value->id")->fetch();
                                    if (!empty($eficacia->aprovado)){
                                        if($eficacia->aprovado == "Sim") {
                                            if (!empty($user))
                                                $total = count($user);
                                            if ($total >= 3) {
                                                echo "R$ " . number_format($value->ValorProjeto / $total, 2, ",", ".");
                                            } else {
                                                echo "R$ " . number_format($value->ValorProjeto / 3, 2, ",", ".");
                                            }
                                        }else{
                                            echo "R$ 0,00";
                                        }
                                    }else{
                                        echo "R$ 0,00";
                                    }
                                    ?></td>
                                <td><?php
                                        if (!empty($eficacia->aprovado)){
                                            if($eficacia->aprovado == "Sim") {
                                                echo "R$ " . number_format($value->ValorProjeto, 2, ",", ".");
                                            }else{
                                                echo "R$ 0,00";
                                            }
                                        }else{
                                            echo "R$ 0,00";
                                        }
                                    ?></td>
                                <td>
                                    <?php
                                    $eficacia = (new TableEficaciaProjeto())->find("idprojeto = $value->id")->fetch(true);
                                    if ($eficacia) {
                                        foreach ($eficacia as $eficaz) {
                                            echo $eficaz->aprovado;
                                        }
                                    } else {
                                        echo "Não Avaliado";
                                    }
                                    ?>
                                </td>
                                <td class="actions">
                                    <a href="<?= BASEURL ?>Projeto/View/index.php?id=<?= $value->id ?>"
                                       class="delete-row" data-toggle="tooltip" title="Visualizar Projeto"><i
                                                class="fa fa-eye"></i></a>
                                    <?php if ($status == 2): ?>
                                        <a href="<?= BASEURL ?>Projeto/edit.php?id=<?= $value->id ?>"
                                           data-toggle="tooltip"
                                           title="Editar Projeto">
                                            <i class="fa fa-pencil"></i></a>
                                    <?php endif; ?>
                                    <?php if ($status == 2): ?>
                                        <a href="<?= BASEURL ?>Projeto/finish.php?id=<?= $value->id ?>"
                                           data-toggle="tooltip"
                                           title="Finalizar Projeto">
                                            <i class="fa fa-check-square"></i></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
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
<?php include(FOOTER_TEMPLATE); ?>
