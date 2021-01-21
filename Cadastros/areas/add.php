<?php
require_once('../../config.php');

require_once("../../vendor/autoload.php");

use Source\controllers\Area;

$function = new Area();
abresessao();
$now = date_create('now', new DateTimeZone('America/Sao_Paulo'));
//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Cadastro';
if (!empty($_POST['namegroup']))
    $function->save($_POST['namegroup'], [$_POST['idmember1'], $_POST['idmember2']]);
?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="<?= BASEURL ?>Cadastros/areas/buscarcolaboradores.js"></script>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Cadastro de Áreas</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Cadastro de Áreas</span></li>
            </ul>
            <p class="sidebar-right-toggle"></p>
        </div>
    </header>

    <section class="panel">
        <div class="col-md-12">
            <form method="post" action="#">
                <section class="panel">
                    <header class="panel-heading">

                        <h2 class="panel-title">Nova Área</h2>

                    </header>

                    <div class="panel-body">
                        <div class="row form-group">
                            <div class="col-lg-12">

                                <label>Nome da Área:</label>
                                <input type="text" name="namegroup" placeholder="Nome da Área" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <label>Nome do Supervisor:</label>
                                <input type="text" readonly="" id="membername1" name="membername1"
                                       placeholder="Nome do Supervisor" class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label>Matricula do Supervisor:</label>
                                <input type="text" name="matriculaintegrante1" id="matriculaintegrante1"
                                       onfocusout="lostfocus()" placeholder="Matricula do Supervisor"
                                       class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label>Área do Supervisor:</label>
                                <input type="text" readonly="" id="ccintegrante1" name="ccintegrante1"
                                       placeholder="Área do Supervisor" class="form-control">
                                <input type="hidden" readonly="" id="idmember1" name="idmember1"
                                       placeholder="Área do Integrante" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <label>Nome do Supervisor:</label>
                                <input type="text" readonly="" id="membername2" name="membername2"
                                       placeholder="Nome do Supervisor" class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label>Matricula do Supervisor:</label>
                                <input type="text" name="matriculaintegrante2" id="matriculaintegrante2"
                                       onfocusout="lostfocus1()" placeholder="Matricula do Supervisor"
                                       class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label>Área do Supervisor:</label>
                                <input type="text" readonly="" id="ccintegrante2" name="ccintegrante2"
                                       placeholder="Área do Supervisor" class="form-control">
                                <input type="hidden" readonly="" id="idmember2" name="idmember2"
                                       placeholder="Área do Integrante" class="form-control">
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
