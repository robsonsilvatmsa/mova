<?php
require_once('../../config.php');
require_once("../../vendor/autoload.php");

use Source\models\ImprovementAnalyzer;
use Source\controllers\AnalisarMelhoria;
use Source\models\Melhoria;
use Source\models\UserArea;

$analyzer = new ImprovementAnalyzer();
$function = new AnalisarMelhoria();
$area = new UserArea();
abresessao();
$idusu = $_SESSION['idusuario'];


$areas = $area->find("idusuario = $idusu")->fetch(true);
$ids = '';
if (!empty($areas))
    foreach ($areas as $are) {
        $idarea = $are->idarea;
    }

if (!empty($idarea)) {
    $analisadores = find_query("select A.* from AnalisadorMelhoria as A,AnalisadorMelhoria as B 
where A.status = 0 and B.status = 1 and A.sequencia > B.sequencia 
and a.idmelhoria = b.idmelhoria and A.idarea = $idarea");
}
if (empty($analisadores)) {
    if (!empty($idarea))
        $analisar = $analyzer->find("sequencia = 1 and idarea = $idarea and status = 0")->fetch(true);
    if (!empty($analisar)) {
        foreach ($analisar as $anali) {
            if (!empty($ids)) {
                $ids .= ',';
                $ids .= $anali->idmelhoria;
            } else {
                $ids .= $anali->idmelhoria;
            }
            $seq = $anali->sequencia;
        }
    }

} else {
    foreach ($analisadores as $analis) {
        if (!empty($ids)) {
            $ids .= ',';
            $ids .= $analis['idmelhoria'];
        } else {
            $ids .= $analis['idmelhoria'];
        }
        $seq = $analis['sequencia'];
    }
}

$melhoria = new Melhoria();
$mel = $melhoria->find("id in ($ids)")->fetch(true);
//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Melhoria';

?>


<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Analise de Melhorias</h2>
        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Analise de Melhorias</span></li>
            </ul>
            <p class="sidebar-right-toggle"></p>
        </div>
    </header>
    <section class="panel">

        <header class="panel-heading">
            <div class="panel-actions">
                <a href="#" class="fa fa-caret-down"></a>
                <a href="#" class="fa fa-times"></a>
            </div>

            <h2 class="panel-title">Analise de Melhorias</h2>

        </header>
        <div class="panel-body">
            <div class="table-striped">
                <table class="table table-bordered table-striped mb-md" id="datatable-default">
                    <thead>
                    <tr>
                        <th>N° Melhoria</th>
                        <th>Descrição</th>
                        <th>Grupo</th>
                        <th>Status</th>
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
                                    if ($value->status = 0) {
                                        echo "Enviado para Analise";
                                    } elseif ($value->status = 1) {
                                        echo "Em Analise";
                                    } elseif ($value->status = 2) {
                                        echo "Aprovada";
                                    } elseif ($value->status = 3) {
                                        echo "Implantada";
                                    } elseif ($value->status = 4) {
                                        echo "Rejeitada";
                                    }
                                    ?>
                                </td>
                                <td class="actions">
                                    <a href="<?= BASEURL ?>Melhoria/Analise/edit.php?id=<?= $value->id ?>&area=<?= $idarea; ?>&seq=<?= $seq ?>"
                                       data-toggle="tooltip"
                                       title="Analisar Melhoria">
                                        <i class="fa fa-file-text-o"></i></a>
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
