<?php
require_once('../../config.php');
require_once("functions.php");
require_once("../../vendor/autoload.php");


use Cadastros\grupos\functions;
use Source\models\User;
use Source\models\Group;
use Source\models\UserGroup;

$function = new functions();
abresessao();
$now = date_create('now', new DateTimeZone('America/Sao_Paulo'));
//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Cadastro';


$group = new Group;
$id = $_GET["id"];
$groups = $group->findById($id);

$user = new User;

$usergroup = new UserGroup;

$usersgorup = $usergroup->find("idgrupo = $id")->fetch(true);


?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2> Editar Cadastro de Grupos</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Editar Cadastro de Grupos</span></li>
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

            <h2 class="panel-title">Incluir Usuário ao Grupo</h2>

        </header>
        <div class="panel-body">
            <a type="button" href="<?= BASEURL ?>/Cadastros/grupos/adduser.php?id=<?= $groups->id; ?>"
               class="mb-xs mt-xs mr-xs btn btn-primary">Novo
                Usuário</a>
            <a type="button" href="<?= BASEURL ?>/Cadastros/grupos/" class="mb-xs mt-xs mr-xs btn btn-danger">Voltar
            </a>
        </div>

    </section>

    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">
                <a href="#" class="fa fa-caret-down"></a>
                <a href="#" class="fa fa-times"></a>
            </div>

            <h2 class="panel-title"> Grupo: <?= $groups->name_group; ?></h2>
        </header>
        <div class="panel-body">
            <div class="table-striped">
                <table class="table table-bordered table-striped mb-md" id="datatable-default">
                    <thead>
                    <tr>

                        <th class="center">Nome Integrante</th>
                        <th class="center">Data de Ingresso</th>
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
                                <td class="center"><?= date_format(date_create($value->date_include), "d/m/Y"); ?></td>
                                <td class="center"><?= $usuario->cc . " - " . $usuario->cc_descricao; ?></td>
                                <td class="actions center">
                                    <a href="<?= BASEURL ?>cadastros/grupos/deleteuser.php?id=<?= $value->id ?>&idgrupo=<?= $id ?>"
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
