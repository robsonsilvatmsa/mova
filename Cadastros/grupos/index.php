<?php
require_once('../../config.php');
require_once("functions.php");
require_once("../../vendor/autoload.php");

use Cadastros\grupos\functions;
use \Source\models\Group;

$function = new functions();

$model = new Group();

$groups = $model->find()->fetch(true);


abresessao();



//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Cadastro';
?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Cadastro de Grupos</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Cadastro de Grupos</span></li>
            </ul>
            <p class="sidebar-right-toggle"></p>
        </div>

    </header>

    <section class="panel">

        <header class="panel-heading">
            <div class="panel-actions">

            </div>

            <h2 class="panel-title">Cadastro de Grupos</h2>

        </header>
        <div class="panel-body">
            <a type="button" href="<?= BASEURL ?>Cadastros/grupos/add.php" class="mb-xs mt-xs mr-xs btn btn-primary">Novo
                Grupo</a>
        </div>

    </section>

    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">

            </div>

            <h2 class="panel-title">Grupos</h2>
        </header>
        <div class="panel-body">
            <div class="table-striped">
                <table class="table table-bordered table-striped mb-md" id="datatable-default">
                    <thead>
                    <tr>

                        <th class="center">Nome</th>
                        <th class="center">Data</th>
                        <th class="center">Numero de Integrantes</th>
                        <th class="center">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($groups): ?>
                        <?php foreach ($groups as $value): ?>
                            <tr>
                                <td class="center"><?= $value->name_group; ?></td>
                                <td class="center"><?= date_format(date_create($value->created), "d/m/Y"); ?></td>
                                <td class="center"><?= $function->count($value->id); ?></td>
                                <td class="actions center">
                                    <a href="<?= BASEURL ?>cadastros/grupos/edit.php?id=<?= $value->id ?>"
                                       data-toggle="tooltip" title="Ajustar Usuários"><i class="fa fa-user"></i></a>
                                    <a href="<?= BASEURL ?>cadastros/grupos/editname.php?id=<?= $value->id ?>"
                                       data-toggle="tooltip" title="Editar Nome"><i class="fa fa-pencil"></i></a>
                                    <a href="<?= BASEURL ?>cadastros/grupos/delete.php?id=<?= $value->id ?>"
                                       class="delete-row" data-toggle="tooltip" title="Deletar Grupo!"><i
                                                class="fa fa-trash-o"></i></a>
                                    <a href="<?= BASEURL ?>cadastros/grupos/liberamultproj.php?id=<?= $value->id ?>&multi=1"
                                       class="delete-row" data-toggle="tooltip" title="Liberar mais de um projeto!"><i
                                                class="fa fa-check-square-o"></i></a>
                                    <a href="<?= BASEURL ?>cadastros/grupos/liberamultproj.php?id=<?= $value->id ?>&multi=0"
                                       class="delete-row" data-toggle="tooltip" title="Bloquear mais de um projeto"><i
                                                class="fa fa-ban"></i></a>
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
