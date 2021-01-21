<?php
require_once('../../config.php');
require_once("functions.php");
require_once("../../vendor/autoload.php");

use Cadastros\grupos\functions;

$function = new functions();
abresessao();
$exibir = 'none';

if (!empty($_POST["namegroup"])) {
    if (!empty($_POST["idmember1"]) && !empty($_POST["idmember2"]) && !empty($_POST["idmember3"])) {
        $function->save();
    } else {
        $exibir = '';
    }
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
        <div class="col-md-12">
            <form method="post" action="#">
                <section class="panel">
                    <header class="panel-heading">

                        <h2 class="panel-title">Novo Grupo</h2>

                    </header>

                    <div class="panel-body">
                        <div class="alert alert-danger" style="display: <?= $exibir; ?>">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            Adicione 3 usuários ao grupo
                        </div>
                        <label>Data: <?= date_format($now, "d/m/Y") ?></label>
                        <div class="row form-group">
                            <div class="col-lg-12">

                                <label>Nome do Grupo:</label>
                                <input required type="text" name="namegroup" placeholder="Nome do Grupo"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <label>Nome do Integrante:</label>
                                <input type="text" disabled="" id="membername1" name="membername1"
                                       placeholder="Nome do Integrante" class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label>Matricula do Integrante:</label>
                                <input required type="text" name="matriculaintegrante1" id="matriculaintegrante1"
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
                        <div class="row">
                            <div class="col-lg-4">
                                <label>Nome do Integrante:</label>
                                <input type="text" disabled="" id="membername2" name="membername2"
                                       placeholder="Nome do Integrante" class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label>Matricula do Integrante:</label>
                                <input required type="text" id="matriculaintegrante2" onfocusout="lostfocus1()"
                                       name="matriculaintegrante2" placeholder="Matricula do Integrante"
                                       class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label>Área do Integrante:</label>
                                <input type="text" disabled="" id="ccintegrante2" name="ccintegrante2"
                                       placeholder="Área do Integrante" class="form-control">
                                <input type="hidden" readonly="" id="idmember2" name="idmember2"
                                       placeholder="Área do Integrante" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <label>Nome do Integrante:</label>
                                <input type="text" disabled="" id="membername3" name="membername3"
                                       placeholder="Nome do Integrante" class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label>Matricula do Integrante:</label>
                                <input required type="text" id="matriculaintegrante3" name="matriculaintegrante3"
                                       onfocusout="lostfocus2()" placeholder="Matricula do Integrante"
                                       class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label>Área do Integrante:</label>
                                <input type="text" disabled="" id="ccintegrante3" name="ccintegrante3"
                                       placeholder="Área do Integrante" class="form-control">
                                <input type="hidden" readonly="" id="idmember3" name="idmember3"
                                       placeholder="Área do Integrante" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <label>Nome do Integrante:</label>
                                <input type="text" disabled="" id="membername4" name="membername4"
                                       placeholder="Nome do Integrante" class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label>Matricula do Integrante:</label>
                                <input type="text" id="matriculaintegrante4" name="matriculaintegrante4"
                                       onfocusout="lostfocus3()" placeholder="Matricula do Integrante"
                                       class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label>Área do Integrante:</label>
                                <input type="text" disabled="" id="ccintegrante4" name="ccintegrante4"
                                       placeholder="Área do Integrante" class="form-control">
                                <input type="hidden" readonly="" id="idmember4" name="idmember4"
                                       placeholder="Área do Integrante" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <label>Nome do Integrante:</label>
                                <input type="text" disabled="" id="membername5" name="membername5"
                                       placeholder="Nome do Integrante" class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label>Matricula do Integrante:</label>
                                <input type="text" id="matriculaintegrante5" onfocusout="lostfocus4()"
                                       name="matriculaintegrante5" placeholder="Matricula do Integrante"
                                       class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label>Área do Integrante:</label>
                                <input type="text" disabled="" id="ccintegrante5" name="ccintegrante5"
                                       placeholder="Área do Integrante" class="form-control">
                                <input type="hidden" readonly="" id="idmember5" name="idmember5"
                                       placeholder="Área do Integrante" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <label>Nome do Integrante:</label>
                                <input type="text" id="membername6" disabled="" name="membername6"
                                       placeholder="Nome do Integrante" class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label>Matricula do Integrante:</label>
                                <input type="text" id="matriculaintegrante6" onfocusout="lostfocus5()"
                                       name="matriculaintegrante6" placeholder="Matricula do Integrante"
                                       class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label>Área do Integrante:</label>
                                <input type="text" id="ccintegrante6" disabled="" name="ccintegrante6"
                                       placeholder="Área do Integrante" class="form-control">
                                <input type="hidden" readonly="" id="idmember6" name="idmember6"
                                       placeholder="Área do Integrante" class="form-control">
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer">
                        <button class="btn btn-success">Salvar</button>
                        <a href="<?= BASEURL ?>cadastros/grupos" class="btn btn-danger">cancelar</a>
                    </footer>
                </section>
            </form>
        </div>
    </section>
</section>
<?php include(FOOTER_TEMPLATE); ?>
