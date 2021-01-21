<?php

require_once('../../config.php');
require_once("../../vendor/autoload.php");

use Source\controllers\AprovadoresMelhoria;
use Source\models\Melhoria;

$function = new AprovadoresMelhoria();
abresessao();
$melhoria = new Melhoria();
$group = new \Source\models\Group();
//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Aprovadores';

$melhorias = $melhoria->find("status = 0")->fetch(true);

?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Cadastro de Sequência de Aprovação Melhorias</h2>
        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Cadastro de Sequência de Aprovação Melhorias</span></li>
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

            <h2 class="panel-title">Cadastro de Sequência de Aprovação</h2>

        </header>
        <div class="panel-body">
            <div class="table-striped">
                <table class="table table-bordered table-striped mb-md" id="datatable-default">
                    <thead>
                    <tr>
                        <th>Código Melhoria</th>
                        <th>Descrição Melhoria</th>
                        <th>Grupo</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($melhorias): ?>
                        <?php foreach ($melhorias as $mel): ?>
                            <tr>
                                <td><?= sprintf('%08d', $mel->id); ?></td>
                                <td><?= $mel->Descricao ?></td>
                                <td><?php
                                    $grupo = $group->findById($mel->IdGrupo);
                                    echo $grupo->name_group;
                                    ?></td>
                                <td><a href="<?= BASEURL ?>cadastros/aprovadoresmelhoria/add.php?id=<?= $mel->id ?>"><i
                                                class="fa fa-pencil" data-toggle="tooltip"
                                                title="Adicionar Aprovadores!"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </div>

    </section>
</section>
<?php include(FOOTER_TEMPLATE); ?>
