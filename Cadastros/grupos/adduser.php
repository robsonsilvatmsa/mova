<?php
require_once('../../config.php');
require_once("functions.php");
require_once("../../vendor/autoload.php");

use Cadastros\grupos\functions;

$function = new functions();
abresessao();

if(!empty($_GET["id"]))
{
    $idgroup = $_GET["id"];
}

if (!empty($_POST["idmember1"])) {
    $function->adduser($_POST["idmember1"],$idgroup);
}

$now = date_create('now', new DateTimeZone('America/Sao_Paulo'));
//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Cadastro';

?>
<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="<?= BASEURL ?>Cadastros/grupos/buscarcolaboradores.js"></script>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Novo Integrante</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Novo Integrante</span></li>
            </ul>
            <p class="sidebar-right-toggle"></p>
        </div>

    </header>

    <section class="panel">
        <form method="post" action="#">
            <section class="panel">
                <header class="panel-heading">

                    <h2 class="panel-title">Novo Integrante</h2>

                </header>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <label>Nome do Integrante:</label>
                            <input type="text" disabled="" id="membername1" name="membername1"
                                   placeholder="Nome do Integrante" class="form-control">
                        </div>
                        <div class="col-lg-4">
                            <label>Matricula do Integrante:</label>
                            <input type="text" name="matriculaintegrante1" id="matriculaintegrante1"
                                   onfocusout="lostfocus()" placeholder="Matricula do Integrante"
                                   class="form-control">
                        </div>
                        <div class="col-lg-4">
                            <label>Área do Integrante:</label>
                            <input type="text" disabled="" id="ccintegrante1" name="ccintegrante1"
                                   placeholder="Área do Integrante" class="form-control">
                            <input type="hidden" readonly="" id="idmember1" name="idmember1"
                                   placeholder="Área do Integrante" class="form-control">
                        </div>
                    </div>
                </div>
                <footer class="panel-footer">
                    <button class="btn btn-success">Salvar</button>
                    <a href="<?= BASEURL ?>cadastros/grupos/edit.php?id=<?= $_GET["id"];?>" class="btn btn-danger">cancelar</a>
                </footer>
            </section>
        </form>

    </section>
</section>


<?php include(FOOTER_TEMPLATE); ?>
