<?php

// Quando a ação for para remover anexo
if (isset($_POST["acao"])) {
    if ($_POST['acao'] == 'removeAnexo') {
        // Recuperando nome do arquivo
        $arquivo = $_POST['arquivo'];
        // Caminho dos uploads
        $caminho = 'uploads/';
        // Verificando se o arquivo realmente existe
        if (file_exists($caminho . $arquivo) and !empty($arquivo)) // Removendo arquivo
        {
            unlink($caminho . $arquivo);
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

use Projeto\functions;
use Source\models\AbrangenciaProjeto;
use Source\models\Anexos;
use Source\models\Focus;
use Source\models\Group;
use Source\models\Project;
use Source\models\TableArea;


$function = new functions();
abresessao();
$group = new Group();

$now = date_create('now', new DateTimeZone('America/Sao_Paulo'));
//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Melhoria';


$id = $_GET['id'];

$abrangencia = new AbrangenciaProjeto();
$anexos = new Anexos();
$area = new TableArea();
$foco = new Focus();

$idgroup = $_SESSION['idgrupo'];
$melhoria = new Project();
$foco = new Focus();
$area = new TableArea();
$focus = $foco->find()->fetch(true);
$areas = $area->find()->fetch(true);
$mel = $melhoria->find("id = $id")->fetch(true);


if (!empty($_POST['modelo'])) {
    $caus1 = '';
    $caus2 = '';
    $caus3 = '';
    $caus4 = '';
    $caus5 = '';
    $caus6 = '';
    if ($_POST['causa1']) {
        $caus1 = $_POST['causa1'];
    }
    if ($_POST['causa2']) {
        $caus2 = $_POST['causa2'];
    }
    if ($_POST['causa3']) {
        $caus3 = $_POST['causa3'];
    }
    if ($_POST['causa4']) {
        $caus4 = $_POST['causa4'];
    }
    if ($_POST['causa5']) {
        $caus5 = $_POST['causa5'];
    }
    if ($_POST['causa6']) {
        $caus6 = $_POST['causa6'];
    }

    $categ1 = '';
    $categ2 = '';
    $categ3 = '';
    $categ4 = '';
    $categ5 = '';
    $categ6 = '';
    if ($_POST['categ1']) {
        $categ1 = $_POST['categ1'];
    }
    if ($_POST['categ2']) {
        $categ2 = $_POST['categ2'];
    }
    if ($_POST['categ3']) {
        $categ3 = $_POST['categ3'];
    }
    if ($_POST['categ4']) {
        $categ4 = $_POST['categ4'];
    }
    if ($_POST['categ5']) {
        $categ5 = $_POST['categ5'];
    }
    if ($_POST['categ6']) {
        $categ6 = $_POST['categ6'];
    }


    $function->update($id, $_SESSION['codprovisorio'], $_POST['modelo'],
        [
            $caus1,
            $caus2,
            $caus3,
            $caus4,
            $caus5,
            $caus6,
        ], [
            $categ1,
            $categ2,
            $categ3,
            $categ4,
            $categ5,
            $categ6,
        ],
        $_POST['efeito'], $_POST['pq1'], $_POST['pq2'], $_POST['pq3'], $_POST['pq4'], $_POST['pq5'],
        $_POST['causaraiz'], filter_input(INPUT_POST,"actiontaken",FILTER_SANITIZE_STRING));
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

    function requerer() {
        document.getElementById("price").setAttribute("required", true);
    }

    function removoverRequired() {
        document.getElementById("price").required = false;

    }

    function espinha() {

        document.getElementById("espPeixe").style.display = "";
        document.getElementById("porque").style.display = "none";
        document.getElementById("pq1").required = false;
        document.getElementById("pq2").required = false;
        document.getElementById("pq3").required = false;

    }

    function porque() {
        document.getElementById("espPeixe").style.display = "none";
        document.getElementById("porque").style.display = "";
        document.getElementById("pq1").setAttribute("required", true);
        document.getElementById("pq2").setAttribute("required", true);
        document.getElementById("pq3").setAttribute("required", true);
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
        <h2>Edição Projeto</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Edição Projeto</span></li>
            </ul>
            <p class="sidebar-right-toggle"></p>
        </div>
    </header>

    <section class="panel">
        <div class="col-md-12">
            <form method="post" action="#">

                <header class="panel-heading center">

                    <h2 class="panel-title">Registro De Projeto</h2>

                </header>
                <?php
                foreach ($mel as $itemMel): ?>

                    <div class="panel-body">
                        <header class="panel-heading right-side ">
                            <span>N° do Registro: <?= sprintf('%08d', $itemMel->id); ?></span>
                            <br>
                            <span>Grupo: <?php
                                $grupo = $group->findById($itemMel->idGrupo);
                                echo $grupo->name_group; ?></span>
                            <br>

                        </header>
                        <div class="col-md-6"><label>Projeto Registrado
                                Em: <?= date_format(date_create($itemMel->DataInicio), "d/m/Y") ?></label></div>
                        <!--<div class="col-md-6"><label>Melhoria Encerrada Em: </label></div>-->
                        <br>
                        <hr>

                        <div class="row">
                            <div class="col-lg-6">
                                <label>Área de Implantação:</label>
                                <?php
                                $areaimp = $area->findById($itemMel->idArea);
                                if (!empty($areaimp)) {
                                    echo $areaimp->description_area;
                                } ?>
                            </div>
                            <br>
                            <div class="col-lg-6">
                                <label>Abrangencia do Projeto:</label>
                                <?php
                                $abran = $abrangencia->find("[idprojeto] =$itemMel->id")->fetch(true) ?>
                                <?php
                                if (!empty($abran)): ?>
                                    <?php
                                    foreach ($abran as $items): ?>
                                        <span><?php
                                            $are = $area->findById($items->idarea);
                                            if ($are) {
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
                                <label>Foco do Projeto:</label>

                                <?php
                                $focus = $foco->findById($itemMel->idFoco);
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
                            <label class="control-label">Projeto Será Executado Pelo Grupo?&nbsp;</label>
                            <br>
                            <span><?= $itemMel->GrupoExecuta ?></span>
                        </div>
                        <br>
                        <div class="form-inline">
                            <label class="control-label">Nessário Investimento Financeiro?&nbsp;</label>
                            <br>
                            <span><?= $itemMel->NecessitaInvestimento ?></span>
                            &nbsp;<br>
                            <div class="input-group mb-md">
                                <span class="input-group-addon">R$</span>
                                <input type="text" name="txtvalor" readonly id="price" class="form-control"
                                       value="<?= $itemMel->ValorInvestimento ?>">
                                <span class="input-group-addon ">,00</span>
                            </div>
                        </div>
                        <!-- SOLICITADO POR SOLANGE A NÃO INCLUSSÃO DE ANEXOS NA EDIÇÃO DA MELHORIA.
                        <div class="row">
                            <ul id="anexos"></ul>
                            <iframe class="col-md-12" src="inclusao/upload.php" frameborder="0"
                                    scrolling="no"></iframe>
                        </div>-->
                        <!-- /.row -->
                        <div class="row">
                            <?php
                            $anexo = $anexos->find("idProvisorio = '$itemMel->id' and origem = 'projeto'")->fetch(true); ?>
                            <?php
                            if ($anexo):?>
                                <ul>
                                    <?php
                                    foreach ($anexo as $itemanexo): ?>
                                        <li>
                                            <a href="<?= BASEURL ?>/Projeto/inclusao/uploads/<?= $itemanexo->arquivo ?>">
                                                <?= $itemanexo->arquivo ?></a>
                                        </li>
                                    <?php
                                    endforeach; ?>
                                </ul>
                            <?php
                            endif; ?>
                        </div> <!-- /.row -->

                        <section class="panel">
                            <header class="panel-heading center">
                                <h4>Selecione Uma escolha de apresentação da causa raiz do problema</h4>
                            </header>
                            <div class="panel-body center">
                                <input id="sim" name="modelo" type="radio" value="espinha" required
                                       onclick="espinha()"/>
                                <label for="exampleCheckbox1">ESPINHA DE PEIXE &nbsp;<label class="required"
                                                                                            style="font-size: medium">*</label></label>&nbsp;
                                <input id="nao" name="modelo" type="radio" onclick="porque()" value="porques" required"
                                />
                                <label for="exampleCheckbox1">5 PORQUES <label class="required"
                                                                               style="font-size: medium">*</label></label>&nbsp;
                            </div>
                        </section>
                        <section style="display: none" class="panel" id="porque">
                            <header class="panel-heading center">

                                <h2 class="panel-title">5 - Porques</h2>

                            </header>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" for="textareaAutosize">1°</label>
                                        <div class="col-md-12">
                                            <input id="pq1" type="text" class="form-control input-rounded" name="pq1">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" for="textareaAutosize">2°</label>
                                        <div class="col-md-12">
                                            <input id="pq2" type="text" class="form-control input-rounded" name="pq2">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" for="textareaAutosize">3°</label>
                                        <div class="col-md-12">
                                            <input id="pq3" type="text" class="form-control input-rounded" name="pq3">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" for="textareaAutosize">4°</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control input-rounded" name="pq4">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" for="textareaAutosize">5°</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control input-rounded" name="pq5">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <header class="panel-heading center">

                                <h2 class="panel-title">Causa Raiz do Problema</h2>

                            </header>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="form-group">

                                        <div class="col-md-12">
                                    <textarea class="form-control" rows="5" id="textareaAutosize" name="causaraiz"
                                              data-plugin-textarea-autosize></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body center">
                                    <div class="form-group">

                                        <iframe style="background-color: white" src="inclusao/upload.php"
                                                class="col-md-offset-4 col-md-4" frameborder="0"
                                                scrolling="no"></iframe>
                                    </div>
                                </div>
                            </div>
                        </section aside>
                        <section style="display: none" class="panel" id="espPeixe">
                            <header class="panel-heading center">

                                <h2 class="panel-title">Espinha de Peixe</h2>

                            </header>
                            <div class="panel-body center">
                                <div class="col-md-12">
                                    <img height="250" src="../assets/images/espinha-peixe-1024x449.png">
                                </div>

                            </div>
                            <header class="panel-heading center">
                            </header>
                            <div class="panel-body center">


                                <div class="col-sm-6">
                                    <label>
                                        Material
                                    </label>
                                    <input type="text" class="form-control" name="categ1">
                                </div>
                                <div class="col-sm-6">
                                    <label>
                                        Causa
                                    </label>
                                    <input type="text" class="form-control" name="causa1">
                                </div>
                                <div class="col-sm-6">
                                    <label>
                                        Mão de Obra
                                    </label>
                                    <input type="text" class="form-control" name="categ2">
                                </div>
                                <div class="col-sm-6">
                                    <label>
                                        Causa
                                    </label>
                                    <input type="text" class="form-control" name="causa2">
                                </div>
                                <div class="col-sm-6">
                                    <label>
                                        Máquina
                                    </label>
                                    <input type="text" class="form-control" name="categ3">
                                </div>
                                <div class="col-sm-6">
                                    <label>
                                        Causa
                                    </label>
                                    <input type="text" class="form-control" name="causa3">
                                </div>
                                <div class="col-sm-6">
                                    <label>
                                        Material
                                    </label>
                                    <input type="text" class="form-control" name="categ4">
                                </div>
                                <div class="col-sm-6">
                                    <label>
                                        Causa
                                    </label>
                                    <input type="text" class="form-control" name="causa4">
                                </div>
                                <div class="col-sm-6">
                                    <label>
                                        Medida
                                    </label>
                                    <input type="text" class="form-control" name="categ5">
                                </div>
                                <div class="col-sm-6">
                                    <label>
                                        Causa
                                    </label>
                                    <input type="text" class="form-control" name="causa5">
                                </div>
                                <div class="col-sm-6">
                                    <label>
                                        Método
                                    </label>
                                    <input type="text" class="form-control" name="categ6">
                                </div>
                                <div class="col-sm-6">
                                    <label>
                                        Causa
                                    </label>
                                    <input type="text" class="form-control" name="causa6">
                                </div>
                                <div class="col-sm-12">
                                    <label>
                                        Efeito
                                    </label>
                                    <textarea class="form-control" rows="5" name="efeito"></textarea>
                                </div>
                                <div class="panel-body center">
                                    <div class="form-group">

                                        <iframe style="background-color: white" src="inclusao/upload.php"
                                                class="col-md-offset-4 col-md-4" frameborder="0"
                                                scrolling="no"></iframe>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section>
                            <header class="panel-heading center">
                                <h4>Descreva a Ação Realizada</h4>
                            </header>
                            <div class="panel-body center">

                                <label for="exampleCheckbox1">Ação Realizada &nbsp;<label class="required"
                                                                                          style="font-size: medium">*</label></label>&nbsp;
                                <textarea cols="8" rows="8" class="form-control" name="actiontaken" type="text" value=""
                                          required
                                ></textarea>
                            </div>
                        </section>
                    </div>

                <?php
                endforeach; ?>
                <footer class="panel-footer">
                    <button class="btn btn-success">Incluir</button>
                    <a href="<?= BASEURL ?>projeto" class="btn btn-danger">cancelar</a>
                </footer>
    </section>
    </form>
    </div>
</section>
</section>
<?php
include(FOOTER_TEMPLATE); ?>

