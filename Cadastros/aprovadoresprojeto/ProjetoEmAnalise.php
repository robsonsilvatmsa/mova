<?php

require_once('../../config.php');
require_once("../../vendor/autoload.php");

use Source\controllers\AprovadoresProjeto;
use Source\models\Project;
use Source\models\Group;

$function = new AprovadoresProjeto();
$group = new Group();
abresessao();

$project = new Project();
$projetos = $project->find("Status = 1")->fetch(true);

//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Aprovadores';

?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Editar Sequência de Aprovação Projetos</h2>
        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Editar Sequência de Aprovação Projeto</span></li>
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

            <h2 class="panel-title">Editar Sequência de Aprovação</h2>

        </header>
        <div class="panel-body">
            <div class="table-striped">
                <table class="table table-bordered table-striped mb-md" id="datatable-default">
                    <thead>
                    <tr>
                        <th>Código Projeto</th>
                        <th>Descrição Projeto</th>
                        <th>Grupo</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($projetos): ?>
                        <?php foreach ($projetos as $projeto): ?>
                            <tr>
                                <td><?= sprintf('%08d', $projeto->id); ?></td>
                                <td><?= $projeto->Descricao ?></td>
                                <td>
                                    <?php
                                    $grupo = $group->findById($projeto->idGrupo);
                                    if ($grupo)
                                        echo $grupo->name_group;
                                    ?>
                                </td>
                                <td>
                                    <a href="<?= BASEURL ?>cadastros/aprovadoresprojeto/edit.php?id=<?= $projeto->id ?>"><i
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
