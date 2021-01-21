<?php
require_once('../config.php');
require_once("../vendor/autoload.php");
require_once("functions.php");
abresessao();

use Melhoria\functions;
use Source\models\UserGroup;
use Source\models\Group;
use Source\models\TableEficaciaMelhoria;

$idgrupo = $_SESSION['idgrupo'];
$function = new functions();

$usergroup = new UserGroup();
$user = $usergroup->find("idgrupo = $idgrupo")->fetch(true);

$melhoria = new \Source\models\Melhoria();


$mel = $melhoria->find("idgrupo = $idgrupo")->fetch(true);

//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Melhoria';
$_SESSION['codprovisorio'] = uniqid();
?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Cadastro de Melhoria</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Melhoria</span></li>
            </ul>
            <p class="sidebar-right-toggle"></p>
        </div>

    </header>

    <section class="panel">

        <header class="panel-heading">
            <div class="panel-actions">


            </div>
            <h2 class="panel-title">Melhoria</h2>
        </header>
        <div class="panel-body">
            <a type="button" href="<?= BASEURL ?>melhoria/inclusao"
               class="mb-xs mt-xs mr-xs btn btn-primary">Melhoria</a>
        </div>
    </section>
    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">

            </div>

            <h2 class="panel-title">Melhorias</h2>
        </header>
        <div class="panel-body">
            <div class="table-striped">
                <table class="table table-bordered table-striped mb-md" id="datatable-default">
                    <thead>
                    <tr>
                        <th>Número Melhoria</th>
                        <th>Descrição</th>
                        <th>Data Inclusão</th>
                        <th>Status</th>
                        <th>Valor Melhoria (Por Integrante)</th>
                        <th>Valor Total Melhoria</th>
                        <th>Eficaz</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($mel): ?>
                        <?php foreach ($mel as $value): ?>
                            <tr>
                                <td><?= sprintf('%08d', $value->id); ?></td>
                                <td><?= $value->Descricao; ?></td>
                                <td><?= date_format(date_create($value->DataInicio), "d/m/Y"); ?></td>
                                <td>
                                    <?php
                                    $status = $value->status;
                                    if ($status == 0) {
                                        echo "Enviado para Analise";
                                    } elseif ($status == 1) {
                                        echo "Em Analise";
                                    } elseif ($status == 2) {
                                        echo "Aprovada";
                                    } elseif ($status == 3) {
                                        echo "Implantada";
                                    } elseif ($status == 4) {
                                        echo "Rejeitada";
                                    } elseif ($value->status == 5) {
                                        echo "Avaliado Comitê Mova";
                                    }
                                    ?>
                                </td>
                                <td><?php
                                    $total = 0;
                                    $eficacia = (new TableEficaciaMelhoria())->find("idmelhoria = $value->id")->fetch();
                                   if (!empty($eficacia->aprovado)){
                                    if($eficacia->aprovado == "Sim") {
                                        if (!empty($user))
                                            $total = count($user);
                                        if ($total >= 3) {
                                            echo "R$ " . number_format($value->ValorMelhoria / $total, 2, ",", ".");
                                        } else {
                                            echo "R$ " . number_format($value->ValorMelhoria / 3, 2, ",", ".");
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
                                           echo "R$ " . number_format($value->ValorMelhoria, 2, ",", ".");
                                        }else{
                                            echo "R$ 0,00";
                                        }
                                    }else{
                                        echo "R$ 0,00";
                                    }
                                    ?></td>
                                <td>
                                    <?php
                                    $eficacia = (new TableEficaciaMelhoria())->find("idmelhoria = $value->id")->fetch(true);

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
                                    <a href="<?= BASEURL ?>Melhoria/View/index.php?id=<?= $value->id ?>"
                                       class="delete-row" data-toggle="tooltip" title="Visualizar Melhoria"><i
                                                class="fa fa-eye"></i></a>
                                    <?php if ($status == 0): ?>
                                        <a href="<?= BASEURL ?>Melhoria/edit.php?id=<?= $value->id ?>"
                                           data-toggle="tooltip"
                                           title="Editar Melhoria">
                                            <i class="fa fa-pencil"></i></a>
                                    <?php endif; ?>
                                    <?php if ($status == 2): ?>
                                        <a href="<?= BASEURL ?>Melhoria/finish.php?id=<?= $value->id ?>"
                                           data-toggle="tooltip"
                                           title="Finalizar Melhoria">
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
