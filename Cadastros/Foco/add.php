<?php
require_once('../../config.php');
require_once("../../vendor/autoload.php");

use Source\controllers\Foco;

$function = new Foco();
abresessao();
$now = date_create('now', new DateTimeZone('America/Sao_Paulo'));
//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Cadastro';

if (!empty($_POST["namegroup"]))
    $function->save($_POST["namegroup"]);

?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Cadastra Foco</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Cadastra Foco</span></li>
            </ul>
            <p class="sidebar-right-toggle"></p>
        </div>
    </header>

    <section class="panel">
        <div class="col-md-12">
            <form action="#" method="post">
                <section class="panel">
                    <header class="panel-heading">

                        <h2 class="panel-title">Cadastra Foco</h2>

                    </header>

                    <div class="panel-body">
                        <div class="row form-group">
                            <div class="col-lg-12">

                                <label>Descrição do Foco:</label>
                                <input type="text" name="namegroup" placeholder="Descrição do Foco"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer">
                        <button class="btn btn-success">Salvar</button>
                        <a href="<?= BASEURL ?>cadastros/Foco" class="btn btn-danger">cancelar</a>
                    </footer>
                </section>
            </form>
        </div>
    </section>
</section>
<?php include(FOOTER_TEMPLATE); ?>
