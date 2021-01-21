<?php

require_once('../../config.php');
require_once("../../vendor/autoload.php");

use Source\controllers\AprovadoresMelhoria;
use Source\models\AbrangenciaMelhoria;
use Source\models\Anexos;
use Source\models\Focus;
use Source\models\Group;
use Source\models\Melhoria;
use Source\models\TableArea;


$group = new Group();

$function = new AprovadoresMelhoria();
abresessao();
$TableArea = new TableArea();
//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Aprovadores';

$anexos = new Anexos();
$id = $_GET['id'];
$melhoria = new Melhoria();
$abrangencia = new AbrangenciaMelhoria();

$foco = new Focus();

$mel = $melhoria->find("id = $id")->fetch(true);


var_dump($_POST);
if (!empty($_POST['respon']) && !empty($_POST['seq'])) {
    $function->save($id, $_POST['respon'], $_POST['seq']);
}


$area = $TableArea->find()->fetch(true);
?>
<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    i = 1
    $(document).ready(function () {
        $("#add").click(function () {
            $("#aqui").find('#seq' + i).each(function () {
                i++;
            });
            var markup = "<tr style='heigth'>" +
                "<td><select name='respon[]' class= 'form-control' required>" +
                "<option value=''>Selecione...</option>" +
                "<?php foreach ($area as $col): ?>" +
                "<option value='<?php echo $col->id ?>''><?php echo $col->description_area; ?></option>" +
                "<?php endforeach; ?>" +
                "</select></td>" +
                "<td class='center'>" +
                " <input id='seq" + i + "' class='form-control' name='seq[]' type='hidden' readonly='' value='" + i + "'><b>" + i +
                "°</b></td>" +
                "<td class='center'><input type='checkbox' class='' name='chkdelete'></tr>";
            $("#aqui").append(markup);

        });
    });
    $(document).ready(function () {
        // Find and remove selected table rows
        $("#btndelt").click(function () {
            $("#aqui").find('input[name="chkdelete"]').each(function () {
                if ($(this).is(":checked")) {
                    $(this).parents("tr").remove();
                } else {
                    alert("Selecione uma Opção para Excluir")
                }
            });
        });
    });
</script>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Cadastro de Sequência de Aprovação Melhorias</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Cadastro de Sequência de Aprovação Melhorias</span></li>
            </ul>
            <p class="sidebar-right-toggle"></p>
        </div>

    </header>


    <section class="panel">
        <header class="panel-heading center toggle ">
            <div class="panel-actions fc-state-down">
                <a href="#" class="fa fa-caret-down"></a>

            </div>
            <h2 class="panel-title">Melhoria</h2>

        </header>
        <?php foreach ($mel as $itemMel): ?>
            <div class="panel-body">
                <header class="panel-heading right-side ">
                    <span>N° do Registro: <?= sprintf('%08d', $itemMel->id); ?></span>
                    <br>
                    <span>Grupo: <?php $grupo = $group->findById($itemMel->IdGrupo);
                        echo $grupo->name_group; ?></span>
                    <br>

                </header>
                <div class="col-md-6"><label>Melhoria Registrada
                        Em: <?= date_format(date_create($itemMel->DataInicio), "d/m/Y") ?></label></div>
                <div class="col-md-6"><label>Melhoria Encerrada
                        Em: <?php if (!empty($itemMel->DataEncerramento)) {
                            echo date_format(date_create($itemMel->DataEncerramento), "d/m/Y");
                        } else {
                            "";
                        }
                        ?> </label></div>
                <br>
                <hr>

                <div class="row">
                    <div class="col-lg-6">
                        <label>Área de Implantação:</label>
                        <?php $areaimp = $TableArea->findById($itemMel->IdAreaImplantada);
                        echo $areaimp->description_area ?>
                    </div>
                    <br>
                    <div class="col-lg-6">
                        <label>Abrangencia da Melhoria:</label>
                        <?php $abran = $abrangencia->find("[idmelhoria] =$itemMel->id")->fetch(true) ?>
                        <?php if ($abran): ?>
                            <?php foreach ($abran as $items): ?>
                                <span><?php
                                    $are = $TableArea->findById($items->idarea);
                                    echo $are->description_area;
                                    ?></span><br>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </select>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <label>Foco da Melhoria:</label>

                        <?php $focus = $foco->findById($itemMel->IdFoco);
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
                    &nbsp;<br>
                    <div class="input-group mb-md">
                        <span class="input-group-addon">R$</span>
                        <input type="text" name="txtvalor" readonly id="price" class="form-control"
                               value="<?= $itemMel->ValorInvestimento ?>">
                        <span class="input-group-addon ">,00</span>
                    </div>
                </div>
                <div class="row">
                    <?php $anexo = $anexos->find("idProvisorio = '$itemMel->IdAnexo'")->fetch(true); ?>
                    <?php
                    if ($anexo):?>
                        <ul>
                            <?php foreach ($anexo as $itemanexo): ?>
                                <li>
                                    <a href="<?= BASEURL ?>/Melhoria/inclusao/uploads/<?= $itemanexo->arquivo ?>">
                                        <?= $itemanexo->arquivo ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div> <!-- /.row -->
            </div>
        <?php endforeach; ?>

    </section>


    <section class="panel">
        <header class="panel-heading">
            <h2 class="panel-title">Adicionar Aprovadores</h2>
        </header>
        <form method="post" action="#">
            <div class="panel-body">


                <div class="row">
                    <table id="aqui" class="table table-bordered table-striped mb-md" id="datatable-default">
                        <thead>
                        <tr>

                            <th class="center">Aprovadores <a id="add" class="  btn-success"
                                                              style="width: 25px;height: 25px; text-align: center;"><i
                                            style="width: 20px;height: 25px"
                                            class="glyphicon glyphicon-plus"></i></a></th>

                            <th class="center">Sequencia</th>
                            <th class="center">
                                <button id="btndelt" type="button" class="btn btn-danger fa fa-trash-o"></button>
                            </th>
                        </tr>
                        </thead>
                    </table>
                </div>

            </div>
            <footer class="panel-footer">
                <button class="btn btn-success">Salvar</button>
                <a href="<?= BASEURL ?>cadastros/aprovadoresmelhoria" class="btn btn-danger">cancelar</a>
            </footer>
        </form>
    </section>
</section>


<?php include(FOOTER_TEMPLATE); ?>
