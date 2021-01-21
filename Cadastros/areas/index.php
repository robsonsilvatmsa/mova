<?php
require_once('../../config.php');
require_once("../../vendor/autoload.php");

use Source\controllers\Area;
use Source\models\TableArea;

$function = new Area();
$area = new TableArea();
$areas = $area->find()->fetch(true);
abresessao();

//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Cadastro';
?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Cadastro de Areas</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Cadastro de Areas</span></li>
            </ul>
            <p class="sidebar-right-toggle"></p>
        </div>

    </header>

    <section class="panel">

        <header class="panel-heading">
            <div class="panel-actions">


            </div>

            <h2 class="panel-title">Cadastro de Areas</h2>

        </header>
        <div class="panel-body">
            <a type="button" href="<?= BASEURL ?>/Cadastros/areas/add.php" class="mb-xs mt-xs mr-xs btn btn-primary">Nova
                Área</a>
        </div>

    </section>

    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">


            </div>

            <h2 class="panel-title">Áreas</h2>
        </header>
        <div class="panel-body">
            <div class="table-striped">
                <table class="table table-bordered table-striped mb-md" id="datatable-default">
                    <thead>
                    <tr>

                        <th class="center">Nome</th>

                        <th class="center">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($areas): ?>
                        <?php foreach ($areas as $value): ?>
                            <tr>
                                <td class="center"><?= $value->description_area; ?></td>

                                <td class="actions center">
                                    <a href="<?= BASEURL ?>cadastros/areas/edit.php?id=<?= $value->id ?>"><i
                                                class="fa fa-user" data-toggle="tooltip"
                                                title="Editar Usuário!"></i></a>
                                    <a href="<?= BASEURL ?>cadastros/areas/editdescription.php?id=<?= $value->id ?>"><i
                                                class="fa fa-pencil" data-toggle="tooltip"
                                                title="Editar Nome Área!"></i></a>
                                    <a href="<?= BASEURL ?>cadastros/areas/delete.php?id=<?= $value->id ?>"
                                       class="delete-row" data-toggle="tooltip" title="Deletar Área!"><i
                                                class="fa fa-trash-o"></i></a>
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
