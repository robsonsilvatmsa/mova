<?php
require_once("../../vendor/autoload.php");
require_once('../../config.php');
require_once('functions.php');
require_once("../../source/models/User.php");

abresessao();

//Nome do pai do menu para identificar
$_SESSION['menu'] = "Administrador";

use Source\models\User;

$model = new User();

$users = $model->find("idempresa <> 2 and situacaosenior <> '7-Demitido' ")->order("nome")->fetch(true);
?>


<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>


<style>
    .table-condensed {
        font-size: 10px;
    }
</style>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Usuários</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Manutenção de Usuario</span></li>
            </ul>
            <p class="sidebar-right-toggle"></p>
        </div>

    </header>

    <section class="panel">
        <header class="panel-heading">

            <div class="card-header">
                <!--<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addregistro"><i class="fa fa-plus-square"></i> Incluir</a></button>-->
                <!--<a href="add.php" class="btn btn-sm btn-primary"><i class="fa fa-plus-square"></i> Incluir</a>-->
                <button type="button" class="btn btn-sm btn-primary" id="btn-getResponse"><i
                            class="fa fa-cog"></i>&nbsp;&nbsp;Sincronizar Usuarios
                </button>
                <a class="btn btn-sm btn-tertiary" href="index.php"><i
                            class="fa fa-refresh"></i>&nbsp;&nbsp;Atualizar</a>
                <a class="btn btn-sm btn-tertiary" href="exportcsv.php"><i
                            class="fa fa-download"></i>&nbsp;&nbsp;Exportar CSV</a>
            </div>
            <br>
        </header>
        <div class="panel-body">

            <table class="table table-bordered table-striped mb-none" id="datatable-default">
                <thead>
                <tr>
                    <th style="width:  20%">Nome</th>
                    <th style="width:   7%">Matricula</th>
                    <th style="width:   5%">Empresa</th>
                    <th style="width:  30%">Departamento</th>

                    
                    <th style="width:   7%">Opções</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($users) : ?>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?= $user->nome; ?></td>
                            <td><?= $user->matricula; ?></td>
                            <td>
                                <?php
                                if ($user->idempresa == 1) {
                                    echo "TMSA";
                                } elseif ($user->idempresa == 2) {
                                    echo "IMS";
                                } elseif ($user->idempresa == 3) {
                                    echo "BULKTECH";
                                }

                                ?>
                            </td>
                            <td><?= $user->cc . " - " . $user->cc_descricao; ?></td>


                            <td class="actions text-right">
                                <div class="fa-hover col-lg-3 col-md-6">
                                    <a href="edit.php?id=<?= $user->id; ?>">
                                        <i class="fa fa-edit ui-tooltip"
                                           data-toggle="tooltip" data-placement="top" title="Editar"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6">Nenhum registro encontrado.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</section>


<?php include('modal.php'); ?>
<?php include(FOOTER_TEMPLATE); ?>
