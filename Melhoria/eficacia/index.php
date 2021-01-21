<?php
require_once('../../config.php');
require_once("../../vendor/autoload.php");

use Source\models\ImprovementAnalyzer;
use Source\controllers\EficaciaMelhoria;
use Source\models\Melhoria;
use Source\models\UserArea;
use Source\models\Group;

$analyzer = new ImprovementAnalyzer();
$function = new EficaciaMelhoria();
$area = new UserArea();
abresessao();
$idusu = $_SESSION['idusuario'];


$melhoria = new Melhoria();
$mel = $melhoria->find("status = 3")->fetch(true);
//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Melhoria';

?>


<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Analise de Eficácia da Melhorias</h2>
        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Analise de Eficácia da Melhorias</span></li>
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
            <h2 class="panel-title">Analise de Eficácia da Melhorias</h2>
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
                                <td><?= $group = ((new Group())->findById($value->IdGrupo))->name_group ?></td>
                                <td>
                                    <?php
                                    if ($value->status == 0) {
                                        echo "Enviado para Analise";
                                    } elseif ($value->status == 1) {
                                        echo "Em Analise";
                                    } elseif ($value->status == 2) {
                                        echo "Aprovada";
                                    } elseif ($value->status == 3) {
                                        echo "Implantada";
                                    } elseif ($value->status == 4) {
                                        echo "Rejeitada";
                                    } elseif ($value->status == 5) {
                                        echo "Avaliado Comitê Mova";
                                    }
                                    ?>
                                </td>
                                <td class="actions">
                                    <a href="<?= BASEURL ?>Melhoria/eficacia/edit.php?id=<?= $value->id ?>"
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
