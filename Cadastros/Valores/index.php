<?php
require_once('../../config.php');
require_once("../../vendor/autoload.php");

use Source\models\TableValores;
use Source\controllers\Valores;
use Source\models\Focus;

$function = new Valores();
abresessao();


$tablevalores = new TableValores();

$valores = $tablevalores->find()->fetch(true);

//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Melhoria';
$_SESSION['codprovisorio'] = uniqid();
?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Ajuste de Valores</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Valores</span></li>
            </ul>
            <p class="sidebar-right-toggle"></p>
        </div>

    </header>


    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">

            </div>

            <h2 class="panel-title">Valores</h2>
        </header>
        <div class="panel-body">
            <div class="table-striped">
                <table class="table table-bordered table-striped mb-md" id="datatable-default">
                    <thead>
                    <tr>
                        <th>Descrição dos Valores</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($valores): ?>
                        <?php foreach ($valores as $value): ?>
                            <tr>

                                <td>
                                    <?php

                                    if (!empty($value->idfoco)) {
                                        echo $focus = ((new Focus())->findById($value->idfoco))->focus_description;
                                    } else {
                                        echo $value->descricao;
                                    }

                                    ?>


                                </td>

                                <td class="actions">

                                    <a href="<?= BASEURL ?>Cadastros/Valores/edit.php?id=<?= $value->id ?>"
                                       data-toggle="tooltip"
                                       title="Editar Melhoria">
                                        <i class="fa fa-pencil"></i></a>
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
