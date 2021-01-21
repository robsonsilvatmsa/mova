<?php

// Quando a ação for para remover anexo
if (isset($_POST["acao"])) {
    if ($_POST['acao'] == 'removeAnexo') {
        // Recuperando nome do arquivo
        $arquivo = $_POST['arquivo'];
        // Caminho dos uploads
        $caminho = 'uploads/';
        // Verificando se o arquivo realmente existe
        if (file_exists($caminho.$arquivo) and !empty($arquivo)) // Removendo arquivo
        {
            unlink($caminho.$arquivo);
        }
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
require_once('../config.php');
require_once("functions.php");
require_once("../vendor/autoload.php");

use Melhoria\functions;
use Source\models\Focus;
use Source\models\TableArea;
use Source\models\Melhoria;


use Source\models\AbrangenciaMelhoria;
use Source\controllers\ViewMelhoria;
use Source\models\Anexos;
use Source\models\Group;


$function = new functions();
abresessao();
$group = new Group();

$now = date_create('now', new DateTimeZone('America/Sao_Paulo'));
//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Melhoria';


$id = $_GET['id'];

$abrangencia = new AbrangenciaMelhoria();
$anexos = new Anexos();
$area = new TableArea();
$foco = new Focus();

$idgroup = $_SESSION['idgrupo'];
$melhoria = new Melhoria();
$foco = new Focus();
$area = new TableArea();
$focus = $foco->find()->fetch(true);
$areas = $area->find()->fetch(true);
$mel = $melhoria->find("id = $id")->fetch(true);


if (!empty($_POST['txtResultado'])) {
    $function->finalizar($id, $_SESSION['codprovisorio'], $_POST['txtResultado']);
}

//$conn = Connect::getInstance();
//$query = $conn->query();

?>

<?php
include(ESTILO_TEMPLATE); ?>
<?php
include(HEADER_TEMPLATE); ?>
<?php
include(MENU_TEMPLATE); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="<?= BASEURL ?>Cadastros/grupos/buscarcolaboradores.js"></script>

<script>
    function requerer() {
        document.getElementById("price").setAttribute("required", true);
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
        <h2>Edição Melhoria</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Edição Melhoria</span></li>
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
                <?php
                foreach ($mel as $itemMel): ?>

                    <div class="panel-body">
                        <header class="panel-heading right-side ">
                            <span>N° do Registro: <?= sprintf('%08d', $itemMel->id); ?></span>
                            <br>
                            <span>Grupo: <?php
                                $grupo = $group->findById($itemMel->IdGrupo);
                                if (!empty($grupo)) {
                                    echo $grupo->name_group;
                                } ?></span>
                            <br>

                        </header>
                        <div class="col-md-6"><label>Melhoria Registrada
                                Em: <?= date_format(date_create($itemMel->DataInicio), "d/m/Y") ?></label></div>
                        <!--<div class="col-md-6"><label>Melhoria Encerrada Em: </label></div>-->
                        <br>
                        <hr>

                        <div class="row">
                            <div class="col-lg-6">
                                <label>Área de Implantação:</label>
                                <?php
                                $areaimp = $area->findById($itemMel->IdAreaImplantada);
                                if (!empty($areaimp))
                                    echo $areaimp->description_area ?>
                            </div>
                            <br>
                            <div class="col-lg-6">
                                <label>Abrangencia da Melhoria:</label>
                                <?php
                                $abran = $abrangencia->find("[idmelhoria] =$itemMel->id")->fetch(true) ?>
                                <?php
                                if ($abran): ?>
                                    <?php
                                    foreach ($abran as $items): ?>
                                        <span><?php
                                            $are = $area->findById($items->idarea);
                                            if (!empty($are)) {
                                                echo $are->description_area;
                                            }
                                            ?></span>
                                    <?php
                                    endforeach; ?>
                                <?php
                                endif; ?>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label>Foco da Melhoria:</label>

                                <?php
                                $focus = $foco->findById($itemMel->IdFoco);
                                echo $focus->focus_description;
                                ?>

                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="textareaAutosize">Descrição do
                                    Problema</label>
                                <div class="col-md-12">
                                       <span>
                                           <?= $itemMel->Descricao; ?>
                                       </span>
                                    <br>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="textareaAutosize">Solução
                                    Proposta</label>
                                <div class="col-md-12">
                                     <span>
                                         <?= $itemMel->SolucaoProposta ?>
                                     </span>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="form-inline">
                            <label class="control-label">Melhoria Será Executada Pelo Grupo?&nbsp;</label>
                            <br>
                            <span><?= $itemMel->GrupoExecuta ?></span>
                        </div>
                        <br>
                        <div class="form-inline">
                            <label class="control-label">Nessário Investimento Financeiro?&nbsp;</label>
                            <br>
                            <span><?= $itemMel->NecessitaInvestimento ?></span>
                            <br>
                            &nbsp;
                            <div class="input-group mb-md">
                                <span class="input-group-addon">R$</span>
                                <input type="text" name="txtvalor" id="price" value="<?= $itemMel->ValorInvestimento ?>"
                                       readonly class="form-control">
                                <span class="input-group-addon ">,00</span>
                            </div>
                        </div>
                        <div class="row">
                            <ul id="anexos"></ul>
                            <iframe class="col-md-12" src="inclusao/upload.php" frameborder="0"
                                    scrolling="no"></iframe>
                        </div> <!-- /.row -->
                        <div class="row">
                            <label class="col-md-4 control-label" for="textareaAutosize">Melhorias Obtidas com o
                                Projeto <label class="required" style="font-size: medium">*</label></label>
                            <div class="col-md-12">
                                        <textarea required class="form-control" rows="5" id="textareaAutosize"
                                                  name="txtResultado"
                                                  data-plugin-textarea-autosize></textarea>
                            </div>
                        </div>
                    </div>
                <?php
                endforeach; ?>
                <footer class="panel-footer">
                    <button class="btn btn-success">Finalizar/Enviar para Eficacia</button>
                    <a href="<?= BASEURL ?>melhoria" class="btn btn-danger">cancelar</a>
                </footer>
    </section>
    </form>
    </div>
</section>
</section>
<?php
include(FOOTER_TEMPLATE); ?>

