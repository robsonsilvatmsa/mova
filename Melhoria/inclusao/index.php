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

use Melhoria\inclusao\functions;
use Source\models\Focus;
use Source\models\TableArea;
use Source\models\Melhoria;

$function = new functions();
abresessao();


$now = date_create('now', new DateTimeZone('America/Sao_Paulo'));
//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Melhoria';


$idgroup = $_SESSION['idgrupo'];
$melhoria = new Melhoria();
$foco = new Focus();
$area = new TableArea();
$focus = $foco->find()->fetch(true);
$areas = $area->find()->fetch(true);
$mel = $melhoria->find("", "max(id)")->fetch(true);

if ($mel) {
    foreach ($mel as $itemel) {
        $num = $itemel->id + 1;
    }
} else $num = 1;

if (!empty($_POST['cmbArea']) && !empty($_POST['cmbAbrangencia']) && !empty($_POST['cmbFoco'])
    && !empty($idgroup) && !empty($_POST['txtDescricao']) && !empty($_POST['txtSolucao']) && !empty($_POST['rdbgrupo'])
    && !empty($_POST['rdbInvestimento'])) {

    $function->salvar($_POST['txtDescricao'], $_POST['txtSolucao'], $idgroup, $_POST['cmbFoco'], $_POST['cmbArea'],
        $_POST['rdbgrupo'], $_POST['rdbInvestimento'], date_format($now, 'Y-m-d'), $_POST['txtvalor'], $_SESSION['codprovisorio'], $_POST['cmbAbrangencia']);

}

//$conn = Connect::getInstance();
//$query = $conn->query();

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
        <h2>Inclusão Melhoria </h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Inclusão Melhoria</span></li>
            </ul>
            <p class="sidebar-right-toggle"></p>
        </div>
    </header>

    <section class="panel">
        <div class="col-md-12">
            <form method="post" action="#">

                <header class="panel-heading center">

                    <h2 class="panel-title">Registro De Melhoria</h2>

                </header>

                <div class="panel-body">
                    <header class="panel-heading right-side ">
                        <span>N° do Registro: <?= sprintf('%08d', $num); ?></span>
                        <br>
                        <span>Grupo: <?= $_SESSION['grupo']; ?></span>


                    </header>
                    <div class="col-md-6"><label>Melhoria Registrada
                            Em: <?= date_format($now, "d/m/Y") ?></label></div>
                    <!--<div class="col-md-6"><label>Melhoria Encerrada Em: </label></div>-->
                    <br>
                    <hr>

                    <div class="row">
                        <div class="col-lg-6">
                            <label>Área de Implantação: <label class="required"
                                                               style="font-size: medium">*</label></label>
                            <select id="cmbArea" name="cmbArea"
                                    class="form-control" required
                                    onclick="populaabrangencia()">

                                <option value="">Selecione...</option>
                                <?php foreach ($areas as $items): ?>
                                    <option value="<?= $items->id ?>"
                                    ><?= $items->description_area; ?></option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                        <br>
                        <div class="col-lg-6">
                            <label>Abrangencia da Melhoria:</label>
                            <select name="cmbAbrangencia[]" class="form-control" multiple="multiple"
                                    data-plugin-multiselect id="cmbAbrangencia">
                                <?php foreach ($areas as $items): ?>
                                    <option value="<?= $items->id ?>"
                                    ><?= $items->description_area; ?></option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>Foco da Melhoria: <label class="required" style="font-size: medium">*</label></label>
                            <select name="cmbFoco" class="form-control populate" required>

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
                                        <textarea required name="txtDescricao" class="form-control" rows="5"
                                                  id="textareaAutosize"
                                                  data-plugin-textarea-autosize></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="textareaAutosize">Solução
                                Proposta <label class="required" style="font-size: medium">*</label></label>
                            <div class="col-md-12">
                                        <textarea required name="txtSolucao" class="form-control" rows="5"
                                                  id="textareaAutosize"
                                                  data-plugin-textarea-autosize></textarea>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="form-inline">
                        <label class="control-label">Melhoria Será Executada Pelo Grupo? <label class="required"
                                                                                                style="font-size: medium">*</label></label>
                        <br>
                        <input id="awesome" name="rdbgrupo" type="radio" value="Sim" required/>
                        <label for="exampleCheckbox1">Sim &nbsp;</label>
                        <input id="awesome" name="rdbgrupo" type="radio" value="Não" required/>
                        <label for="exampleCheckbox1">Não</label>
                    </div>
                    <br>
                    <div class="form-inline">
                        <label class="control-label">Nessário Investimento Financeiro? <label class="required"
                                                                                              style="font-size: medium">*</label></label>
                        <br>
                        <input id="sim" name="rdbInvestimento" type="radio" value="Sim" required
                               onclick="requerer()"/>
                        <label for="exampleCheckbox1">Sim &nbsp;</label>
                        <input id="nao" name="rdbInvestimento" type="radio" value="Não" required
                               onclick="removoverRequired()"/>
                        <label for="exampleCheckbox1">Não</label>
                        &nbsp;
                        <div class="input-group mb-md">
                            <span class="input-group-addon">R$</span>
                            <input type="number" min="1" name="txtvalor" id="price"
                                   class="form-control">
                            <span class="input-group-addon ">,00</span>
                        </div>
                    </div>
                    <div class="row">
                        <ul id="anexos"></ul>
                        <iframe class="col-md-12" src="upload.php" frameborder="0" scrolling="no"></iframe>
                    </div> <!-- /.row -->
                </div>

                <footer class="panel-footer">
                    <button class="btn btn-success">Incluir</button>
                    <a href="<?= BASEURL ?>melhoria" class="btn btn-danger">cancelar</a>
                </footer>
    </section>
    </form>
    </div>
</section>
</section>
<?php include(FOOTER_TEMPLATE); ?>

