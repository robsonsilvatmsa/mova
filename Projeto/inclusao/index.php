<?php
// Quando a ação for para remover anexo
if (isset($_POST["acao"])) {
    if ($_POST['acao'] == 'removeAnexo') {
        // Recuperando nome do arquivo
        $arquivo = $_POST['arquivo'];
        // Caminho dos uploads
        $caminho = 'uploads/';
        // Verificando se o arquivo realmente existe
        if (file_exists($caminho . $arquivo) and !empty($arquivo))
            // Removendo arquivo
            unlink($caminho . $arquivo);
        // Finaliza a requisição
        exit;
    }
}

// Se enviado o formulário
if (isset($_POST['enviar'])) {
    echo 'Arquivos Enviados: ';
    echo '<pre>';
    print_r($_POST['anexos']);
    echo '</pre>';
}
?>
<?php
require_once('../../config.php');
require_once("functions.php");
require_once("../../vendor/autoload.php");

use Projeto\inclusao\functions;
use Source\models\Focus;
use Source\models\TableArea;

$function = new functions();
abresessao();

$_SESSION['idgrupo'];

$foco = new Focus();
$area = new TableArea();
$focus = $foco->find()->fetch(true);
$areas = $area->find()->fetch(true);

$now = date_create('now', new DateTimeZone('America/Sao_Paulo'));

if (!empty($_POST['area']) && !empty($_POST['foco']) && !empty($_POST['descricao']) && !empty($_POST['Solucao']) &&
    !empty($_POST['grupo']) && !empty($_POST['financeiro'])) {


    $function->save(
        $_SESSION['idgrupo'], $_POST['area'], $_POST['foco'], $_POST['descricao'], $_POST['Solucao'],
        $_POST['grupo'], $_POST['financeiro'], date_format($now, 'Y-m-d'),
        $_POST['valor'], $_SESSION['codprovisorio'], $_POST['abrangencia']
    );
}

//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Melhoria';
?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="<?= BASEURL ?>Cadastros/grupos/buscarcolaboradores.js"></script>

<script>
    function requerer() {
        document.getElementById("price").setAttribute("required", true);
    }

    function removoverRequired() {
        document.getElementById("price").required = false;

    }

</script>

<script type="text/javascript">
    $(function ($) {
        // Quando enviado o formulário
        $("#upload").submit(function () {
            // Passando por cada anexo
            $("#anexos").find("li").each(function () {
                // Recuperando nome do arquivo
                var arquivo = $(this).attr('lang');
                // Criando campo oculto com o nome do arquivo
                $("#upload").prepend('<input type="hidden" name="anexos[]" value="' + arquivo + '" \/>');
            });
        });
    });


    // Função para remover um anexo
    function removeAnexo(obj) {
        // Recuperando nome do arquivo
        var arquivo = $(obj).parent('li').attr('lang');
        // Removendo arquivo do servidor
        $.post("index.php", {acao: 'removeAnexo', arquivo: arquivo}, function () {
            // Removendo elemento da página
            $(obj).parent('li').remove();
        });
    }

</script>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Inclusão Projeto</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Inclusão Projeto</span></li>
            </ul>
            <p class="sidebar-right-toggle"></p>
        </div>
    </header>

    <section class="panel">
        <div class="col-md-12">
            <form method="post" action="#">
                <section class="panel">
                    <header class="panel-heading center">

                        <h2 class="panel-title">Registro De Projeto</h2>

                    </header>

                    <div class="panel-body">
                        <header class="panel-heading right-side ">
                            <span>N° do Registro: <?= sprintf('%08d', 1); ?></span>
                            <br>
                            <span>Grupo: <?= $_SESSION['grupo']; ?></span>


                        </header>
                        <div class="col-md-6"><label>Projeto Registrado
                                Em: <?= date_format($now, "d/m/Y") ?></label></div>
                        <!--<div class="col-md-6"><label>Melhoria Encerrada Em: <?php $texto = new DateTime(' -1 month');
                        echo date_format($texto, 'd/m/Y'); ?>
                            </label></div>-->
                        <br>
                        <hr>

                        <div class="row">
                            <div class="col-lg-6">
                                <label>Área de Implantação: <label class="required" style="font-size: medium">*</label></label>
                                <select required class="form-control populate" name="area">

                                    <option value="">Selecione...</option>
                                    <?php foreach ($areas as $items): ?>
                                        <option value="<?= $items->id ?>"><?= $items->description_area; ?></option>
                                    <?php endforeach; ?>

                                </select>
                            </div>
                            <br>
                            <div class="col-lg-6">
                                <label>Abrangencia do Projeto:</label>
                                <select class="form-control" multiple="multiple" data-plugin-multiselect id=""
                                        name="abrangencia[]">
                                    <?php foreach ($areas as $items): ?>
                                        <option value="<?= $items->id ?>"><?= $items->description_area; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label>Foco do Projeto: <label class="required"
                                                               style="font-size: medium">*</label></label>
                                <select required class="form-control populate" name="foco">

                                    <option value="">Selecione...</option>
                                    <?php foreach ($focus as $item): ?>
                                        <option value="<?= $item->id ?>"><?= $item->focus_description ?></option>
                                    <?php endforeach; ?>

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="textareaAutosize">Descrição do
                                    Problema <label class="required" style="font-size: medium">*</label></label>
                                <div class="col-md-12">
                                        <textarea required class="form-control" rows="5" id="textareaAutosize"
                                                  name="descricao"
                                                  data-plugin-textarea-autosize></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="textareaAutosize">Solução
                                    Proposta <label class="required" style="font-size: medium">*</label></label>
                                <div class="col-md-12">
                                        <textarea required class="form-control" rows="5" id="textareaAutosize"
                                                  name="Solucao"
                                                  data-plugin-textarea-autosize></textarea>
                                </div>
                            </div>
                        </div>
                        <br>
                        <footer class="panel-footer">
                            <div class="form-inline">

                                <label class="control-label">Projeto Será Executado Pelo Grupo?&nbsp;<label
                                            class="required" style="font-size: medium">*</label></label>
                                <br>
                                <input id="awesome" name="grupo" type="radio" value="sim" required/>
                                <label for="exampleCheckbox1">Sim &nbsp;</label>
                                <input id="awesome" name="grupo" type="radio" value="não" required/>
                                <label for="exampleCheckbox1">Não</label>
                            </div>
                            <br>
                            <div class="form-inline">

                                <label class="control-label">Nessário Investimento Financeiro?&nbsp;<label
                                            class="required" style="font-size: medium">*</label></label>
                                <br>
                                <input id="sim" name="financeiro" type="radio" value="sim" required
                                       onclick="requerer()"/>
                                <label for="exampleCheckbox1">Sim &nbsp;</label>
                                <input id="nao" name="financeiro" type="radio" value="não" required
                                       onclick="removoverRequired()"/>
                                <label for="exampleCheckbox1">Não</label>
                                &nbsp;
                                <div class="input-group mb-md">
                                    <span class="input-group-addon">R$</span>
                                    <input type="text" name="valor" min="1" id="price" class="form-control">
                                    <span class="input-group-addon ">,00</span>
                                </div>

                            </div>
                        </footer>
                        <div class="form-group">

                            <iframe src="upload.php" class="col-md-12" frameborder="0" scrolling="no"></iframe>
                        </div>


                    </div>
                </section>


                <section class="panel">
                    <header class="panel-heading center">
                        <h4>Arquivos Anexados</h4>
                    </header>
                    <div class="panel-body">
                        <ul id="anexos" style="background-color: white"></ul>
                    </div>
                </section aside>


                <footer class="panel-footer">
                    <button class="btn btn-success">Incluir</button>
                    <a href="<?= BASEURL ?>projeto" class="btn btn-danger">cancelar</a>
                </footer>

            </form>
        </div>
    </section>
</section>
<?php include(FOOTER_TEMPLATE); ?>

