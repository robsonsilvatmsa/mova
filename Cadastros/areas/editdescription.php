<?php
require_once('../../config.php');
require_once('../../vendor/autoload.php');


use Source\controllers\Area;
use Source\models\TableArea;


$function = new Area();

$model = new TableArea();

$groups = $model->findById($_GET['id']);

$idgroup = $_GET["id"];

if (!empty($_POST["namegroup"]))
    $function->editname($idgroup, $_POST["namegroup"]);

abresessao();

//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Cadastro';
?>


<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2></h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span></span></li>
            </ul>
            <p class="sidebar-right-toggle"></p>
        </div>

    </header>

    <section class="panel">

        <div class="col-md-12">
            <form method="post" action="#">
                <section class="panel">
                    <header class="panel-heading">

                        <h2 class="panel-title">Editar Área</h2>

                    </header>

                    <div class="panel-body">

                        <div class="row form-group">
                            <div class="col-lg-12">

                                <label>Nome da Área:</label>
                                <input type="text" name="namegroup" placeholder="Nome do Grupo" class="form-control"
                                       value="<?= $groups->description_area ?>">
                            </div>
                        </div>

                    </div>
                    <footer class="panel-footer">
                        <button class="btn btn-success">Salvar</button>
                        <a href="<?= BASEURL ?>cadastros/areas" class="btn btn-danger">cancelar</a>
                    </footer>
                </section>
            </form>
        </div>

    </section>
</section>


<?php include(FOOTER_TEMPLATE); ?>
