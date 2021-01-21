<?php
require_once('../../config.php');
require_once("../../vendor/autoload.php");

use Source\controllers\Area;
use Source\models\TableArea;
use Source\models\UserArea;
use Source\models\User;

$function = new Area();
$area = new TableArea();

$user = new User();

$userarea = new UserArea();

$areas = $area->findById($_GET['id']);
$usersgorup = $userarea->find("idarea=$areas->id")->fetch(true);

abresessao();
$now = date_create('now', new DateTimeZone('America/Sao_Paulo'));
//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Cadastro';
?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="<?= BASEURL ?>Cadastros/areas/buscarcolaboradores.js"></script>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Editar Cadastro de Áreas</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Editar Cadastro de Áreas</span></li>
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

            <h2 class="panel-title">Incluir Usuário a Área</h2>

        </header>
        <div class="panel-body">
            <a type="button" href="<?= BASEURL ?>/Cadastros/areas/adduser.php?id=<?= $areas->id; ?>"
               class="mb-xs mt-xs mr-xs btn btn-primary">Novo
                Usuário</a>
            <a type="button" href="<?= BASEURL ?>/Cadastros/areas/" class="mb-xs mt-xs mr-xs btn btn-danger">Voltar
            </a>
        </div>

    </section>

    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">
                <a href="#" class="fa fa-caret-down"></a>
                <a href="#" class="fa fa-times"></a>
            </div>

            <h2 class="panel-title"> Área: <?= $areas->description_area; ?></h2>
        </header>
        <div class="panel-body">
            <div class="table-striped">
                <table class="table table-bordered table-striped mb-md" id="datatable-default">
                    <thead>
                    <tr>

                        <th class="center">Nome Integrante</th>

                        <th class="center">Area</th>
                        <th class="center">Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($usersgorup): ?>
                        <?php foreach ($usersgorup as $value): ?>
                            <?php $usuario = $user->findById($value->idusuario); ?>
                            <tr>
                                <td class="center"><?= $usuario->nome; ?></td>

                                <td class="center"><?= $usuario->cc . " - " . $usuario->cc_descricao; ?></td>
                                <td class="actions center">
                                    <a href="<?= BASEURL ?>cadastros/areas/deleteuser.php?id=<?= $value->id ?>&idarea=<?= $areas->id; ?>"
                                       class="delete-row" data-toggle="tooltip" title="Deletar Usuário!"><i
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
