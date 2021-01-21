<?php
require_once('../../config.php');
require_once("../../vendor/autoload.php");

use Source\controllers\Foco;
use Source\models\Focus;

$foco = new Foco();

$function = new Focus();
$focus = $function->find()->fetch(true);
abresessao();


//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Cadastro';
?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Cadastro Foco</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Cadastro Foco</span></li>
            </ul>
            <p class="sidebar-right-toggle"></p>
        </div>

    </header>

    <section class="panel">

        <header class="panel-heading">
            <div class="panel-actions">

            </div>

            <h2 class="panel-title">Cadastro Foco</h2>

        </header>
        <div class="panel-body">
            <a type="button" href="<?= BASEURL ?>/Cadastros/Foco/add.php" class="mb-xs mt-xs mr-xs btn btn-primary">Novo
                Foco</a>
        </div>

    </section>

    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">

            </div>

            <h2 class="panel-title">Foco</h2>
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
                    <?php if ($focus): ?>
                        <?php foreach ($focus as $value): ?>
                            <tr>
                                <td class="center"><?= $value->focus_description; ?></td>
                                <td class="actions center">
                                    <a href="<?= BASEURL ?>cadastros/Foco/edit.php?id=<?= $value->id ?>"><i
                                                class="fa fa-pencil" data-toggle="tooltip" title="Editar Foco!"></i></a>
                                    <a href="<?= BASEURL ?>cadastros/Foco/delete.php?id=<?= $value->id ?>"
                                       class="delete-row" data-toggle="tooltip" title="Deletar Foco!"><i
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
