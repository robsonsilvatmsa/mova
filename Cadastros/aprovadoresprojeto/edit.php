<?php

require_once('../../config.php');
require_once("../../vendor/autoload.php");

use Source\controllers\AprovadoresProjeto;
use Source\models\AbrangenciaProjeto;
use Source\models\Anexos;
use Source\models\EspinhaPeixeProj;
use Source\models\Focus;
use Source\models\Group;
use Source\models\Porques;
use Source\models\Project;
use Source\models\TableArea;

$function = new AprovadoresProjeto();
abresessao();
$TableArea = new TableArea();
$group = new Group();
$anexos = new Anexos();
$id = $_GET['id'];
$foco = new Focus();
$project = new Project();
$abangencia = new AbrangenciaProjeto();
$espinha = new EspinhaPeixeProj();
$porques = new Porques();
$projeto = $project->find("id = $id")->fetch(true);
//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Aprovadores';
$area = $TableArea->find()->fetch(true);

if (!empty($id) && !empty($_POST['respon']) && !empty($_POST['seq'])) {
    $function->update($id, $_POST['respon'], $_POST['seq'], $_POST['id']);
}
?>
<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>s
<script src="../../assets/js/AjustarAprovadores.js"></script>
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
<input type="hidden" id="codPA" value="<?= $id ?>">
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Cadastro de Sequência de Aprovação Projetos</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Cadastro de Sequência de Aprovação Projetos</span></li>
            </ul>
            <p class="sidebar-right-toggle"></p>
        </div>

    </header>
    <section class="panel">
        <header class="panel-heading center toggle ">
            <div class="panel-actions fc-state-down">
                <a href="#" class="fa fa-caret-down"></a>

            </div>
            <h2 class="panel-title">Projeto</h2>

        </header>
        <?php foreach ($projeto as $proj): ?>
            <div class="panel-body">
                <header class="panel-heading right-side ">
                    <span>N° do Registro: <?= sprintf('%08d', $proj->id); ?></span>
                    <br>
                    <span>Grupo: <?php $grupo = $group->findById($proj->idGrupo);
                        if ($grupo) {
                            echo $grupo->name_group;
                        } ?></span>
                    <br>

                </header>
                <div class="col-md-6"><label>Melhoria Registrada
                        Em: <?= date_format(date_create($proj->DataInicio), "d/m/Y") ?></label></div>
                <div class="col-md-6"><label>Melhoria Encerrada
                        Em: <?php if (!empty($proj->DataEncerramento)) {
                            echo date_format(date_create($proj->DataEncerramento), "d/m/Y");
                        } else {
                            "";
                        }
                        ?> </label></div>
                <br>
                <hr>

                <div class="row">
                    <div class="col-lg-6">
                        <label>Área de Implantação:</label>
                        <?php $areaimp = $TableArea->findById($proj->idArea);
                        echo $areaimp->description_area ?>
                    </div>
                    <br>
                    <div class="col-lg-6">
                        <label>Abrangencia da Melhoria:</label>
                        <?php $abran = $abangencia->find("[idprojeto] =$proj->id")->fetch(true) ?>
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

                        <?php $focus = $foco->findById($proj->idFoco);
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
                                           <?= $proj->Descricao; ?>
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
                                         <?= $proj->SolucaoProposta ?>
                                     </span>
                            <br>
                        </div>
                    </div>
                </div>
                <br>

                <div class="form-inline">
                    <label class="control-label">Melhoria Será Executada Pelo Grupo?&nbsp;</label>
                    <br>
                    <span><?= $proj->GrupoExecuta ?></span>
                </div>
                <br>
                <div class="form-inline">
                    <label class="control-label">Nessário Investimento Financeiro?&nbsp;</label>
                    <br>
                    <span><?= $proj->NecessitaInvestimento ?></span>
                    &nbsp;<br>
                    <div class="input-group mb-md">
                        <span class="input-group-addon">R$</span>
                        <input type="text" name="txtvalor" readonly id="price" class="form-control"
                               value="<?= $proj->ValorInvestimento ?>">
                        <span class="input-group-addon ">,00</span>
                    </div>
                </div>
                <div class="form-group">
                    <h3 class="control-label">Brainstorming</h3>
                    <?php $pqs = $porques->find("idprojeto = $proj->id")->fetch(true); ?>
                    <?php $efect = false;
                    $esp = $espinha->find("idprojeto = $proj->id")->fetch(true); ?>
                    <?php if ($proj->ModoCausaRaiz == "porques" && !empty($pqs)): ?>

                        <div class="col-md-offset-1">
                            <h4>5 Porquês</h4>
                        </div>
                        <div class="col-md-offset-2">

                            <?php foreach ($pqs as $pq): ?>
                                <h3>1° Porque</h3>
                                <label><?= $pq->primeiropq; ?></label>
                                <h3>2° Porque</h3>
                                <label><?= $pq->segundopq; ?></label>
                                <h3>3° Porque</h3>
                                <label><?= $pq->terceiropq; ?></label>
                                <h3>4° Porque</h3>
                                <label><?= $pq->quartopq; ?></label>
                                <h3>5° Porque</h3>
                                <label><?= $pq->quintopq; ?></label>
                                <h3>Causa Raiz</h3>
                                <label><?= $pq->causaraiz; ?></label>
                            <?php endforeach; ?>
                        </div>
                    <?php elseif ($proj->ModoCausaRaiz == "espinha" && !empty($esp)): ?>

                        <div class="col-md-offset-1">
                            <h4>Espinha de Peixe</h4>
                        </div>
                        <div class="col-md-offset-2 ">
                            <?php foreach ($esp as $val): ?>

                                <h3>
                                    Causa
                                </h3>
                                <label class="control-label">
                                    <?= $val->causa; ?>
                                </label>
                                <h3>
                                    Categoria
                                </h3>
                                <label>
                                    <?= $val->categoria ?>
                                </label>
                                <?php if ($efect == false): ?>
                                    <?php $efect = true; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <h3>
                                Efeito
                            </h3>
                            <label>
                                <?php echo $val->efeito ?>
                            </label>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <?php $anexo = $anexos->find("idProvisorio = '$proj->IdAnexo'")->fetch(true); ?>
                    <?php
                    if ($anexo):?>
                        <ul>
                            <?php foreach ($anexo as $itemanexo): ?>
                                <li>
                                    <a href="<?= BASEURL ?>/Projeto/inclusao/uploads/<?= $itemanexo->arquivo ?>">
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
                    <table class="table table-bordered table-striped mb-md">
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
                        <tbody id="aqui">

                        </tbody>
                    </table>
                </div>

            </div>
            <footer class="panel-footer">
                <button class="btn btn-success">Salvar</button>
                <a href="<?= BASEURL ?>cadastros/aprovadoresprojeto/projetoemanalise.php"
                   class="btn btn-danger">cancelar</a>
            </footer>
        </form>

    </section>
</section>


<?php include(FOOTER_TEMPLATE); ?>
