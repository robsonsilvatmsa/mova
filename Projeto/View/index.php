<?php

require_once('../../config.php');
require_once("../../vendor/autoload.php");

use Source\controllers\ViewProjeto;
use Source\models\AbrangenciaProjeto;
use Source\models\AnaliseDoProjeto;
use Source\models\Anexos;
use Source\models\EspinhaPeixeProj;
use Source\models\Focus;
use Source\models\Group;
use Source\models\Porques;
use Source\models\Project;
use Source\models\ProjectAnalyzer;
use Source\models\TableArea;
use Source\models\TableEficaciaProjeto;

$group = new Group();

$view = new ViewProjeto();
abresessao();
$id = $_GET['id'];
$melhoria = new Project();
$abrangencia = new AbrangenciaProjeto();
$anexos = new Anexos();
$area = new TableArea();
$foco = new Focus();
$espinha = new EspinhaPeixeProj();
$porques = new Porques();

$eficacia = (new TableEficaciaProjeto())->find("idprojeto = {$id}")->fetch(true);
$analisador = (new ProjectAnalyzer())->find("idprojeto = $id")->fetch(true);
if (!empty($analisador)) {
    foreach ($analisador as $analise) {
        if (!empty($idanali)) {
            $idanali .= ',';
            $idanali .= $analise->id;
        } else {
            $idanali = $analise->id;
        }
    }
    $analiseprojeto = (new AnaliseDoProjeto())->find("idAnalisador in ($idanali) ")->fetch(true);
}
$mel = $melhoria->find("id = $id")->fetch(true);
//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Melhoria';

?>
<?php
include(ESTILO_TEMPLATE); ?>
<?php
include(HEADER_TEMPLATE); ?>
<?php
include(MENU_TEMPLATE); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2></h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span></span></li>
            </ul>
            <p class="sidebar-right-toggle"></p>
        </div>

    </header>

    <section class="panel">

        <div class="col-md-12">

            <section class="panel">
                <header class="panel-heading center">

                    <h2 class="panel-title">Projeto</h2>

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
                        <div class="col-md-6"><label>Projeto Encerrado
                                Em: <?php
                                if (!empty($itemMel->DataConclusao)) {
                                    echo date_format(date_create($itemMel->DataConclusao), "d/m/Y");
                                } else {
                                    "";
                                }
                                ?> </label></div>
                        <br>
                        <hr>

                        <div class="row">
                            <div class="col-lg-12">
                                <p>
                                    <span>Status Projeto: </span>
                                    <?php
                                    $status = $itemMel->Status;
                                    if ($status == 0) {
                                        echo "Enviado para Analise";
                                    } elseif ($status == 1) {
                                        echo "Em Analise";
                                    } elseif ($status == 2) {
                                        echo "Aprovado";
                                    } elseif ($status == 3) {
                                        echo "Implantado";
                                    } elseif ($status == 4) {
                                        echo "Rejeitado";
                                    } elseif ($itemMel->Status == 5) {
                                        echo "Avaliada Equipe Mova";
                                    } elseif ($itemMel->Status == 6) {
                                        echo "Auditado Equipe Mova";
                                    }
                                    ?>
                                </p>
                                <br>
                            </div>
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
                                       value="<?= number_format( $itemMel->ValorInvestimento,2,",",".") ?>">
                                <span class="input-group-addon ">,00</span>
                            </div>
                        </div>
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
                        <div class="form-group">
                            <h3 class="control-label">Brainstorming</h3>
                            <?php
                            $pqs = $porques->find("idprojeto = $itemMel->id")->fetch(true); ?>
                            <?php
                            $efect = false;
                            $esp = $espinha->find("idprojeto = $itemMel->id")->fetch(true); ?>
                            <?php
                            if ($itemMel->ModoCausaRaiz == "porques" && !empty($pqs)): ?>


                                <div class="col-md-offset-1">
                                    <h4>5 Porquês</h4>
                                </div>
                                <div class="col-md-offset-2">

                                    <?php
                                    foreach ($pqs as $pq): ?>
                                        <table class="table table-bordered table-striped mb-md">
                                            <thead>
                                            <tr>
                                                <th>
                                                    <h3>1° Porque</h3>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <label style="color: red"><?= $pq->primeiropq; ?></label>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <thead>
                                            <tr>
                                                <th>
                                                    <h3>2° Porque</h3>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <label style="color: red"><?= $pq->segundopq; ?></label>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <thead>
                                            <tr>
                                                <th>
                                                    <h3>3° Porque</h3>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <label style="color: red"><?= $pq->terceiropq; ?></label>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <thead>
                                            <tr>
                                                <th>
                                                    <h3>4° Porque</h3>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <label style="color: red"><?= $pq->quartopq; ?></label>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <thead>
                                            <tr>
                                                <th>
                                                    <h3>5° Porque</h3>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <label style="color: red"><?= $pq->quintopq; ?></label>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <thead>
                                            <tr>
                                                <th>
                                                    <h3>Causa Raiz</h3>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <label style="color: red"><?= $pq->causaraiz; ?></label>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    <?php
                                    endforeach; ?>
                                </div>

                            <?php
                            elseif ($itemMel->ModoCausaRaiz == "espinha" && !empty($esp)): ?>

                                <div class="col-md-offset-1">
                                    <h4>Espinha de Peixe</h4>
                                </div>
                                <div class="col-md-offset-2 ">
                                    <table class="table table-bordered table-striped mb-md">
                                        <?php
                                        foreach ($esp as $val): ?>
                                            <thead>
                                            <tr>
                                                <th>
                                                    <h3>
                                                        Causa
                                                    </h3>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <label class="control-label" style="color: red">
                                                        <?= $val->causa; ?>
                                                    </label>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <thead>
                                            <tr>
                                                <th>
                                                    <h3>
                                                        Categoria
                                                    </h3>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <label style="color: red">
                                                        <?= $val->categoria ?>
                                                    </label>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <?php
                                            if ($efect == false): ?>
                                                <?php
                                                $efect = true; ?>
                                            <?php
                                            endif; ?>
                                        <?php
                                        endforeach; ?>
                                        <thead>
                                        <tr>
                                            <th>
                                                <h3>
                                                    Efeito
                                                </h3>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <label style="color: red">
                                                    <?php
                                                    echo $val->efeito ?>
                                                </label>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            <?php
                            endif; ?>
                        </div>
                        <?php
                        if (!empty($analiseprojeto)): ?>
                            <div class="row">
                                <div class="form-group">
                                    <h4 class="col-md-3 control-label" for="textareaAutosize">Observações da
                                        Analise: </h4>
                                    <?php
                                    foreach ($analiseprojeto as $item): ?>
                                        <div class="col-md-12">
                                            <span>
                                               Parecer do <?= $item->analisador; ?>:&nbsp;
                                            </span>
                                            <span>
                                                <?= $item->observacao; ?>
                                            </span>
                                            <br>
                                            <br>
                                        </div>
                                    <?php
                                    endforeach; ?>
                                    <div class="col-md-12">
                                        <span>
                                               Resultado Obtido:&nbsp;
                                            </span>
                                        <span><?= mb_convert_case($itemMel->ResultadoObtido, MB_CASE_TITLE) ?></span>
                                    </div>

                                    <div class="col-md-12">
                                        <br>
                                        
                                        <span>
                                           Parecer Eficácia:
                                        </span>
                                        <?php if ($eficacia): ?>
                                            <?php foreach ($eficacia as $eficaz): ?>
                                                <span>
                                                    <?= mb_convert_case($eficaz->parecer, MB_CASE_TITLE); ?>
                                                </span>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endif; ?>
                    </div>

                <?php
                endforeach; ?>

                <footer class="panel-footer">
                    <a href="<?= BASEURL ?>Projeto" class="btn btn-danger">Voltar</a>
                </footer>
            </section>

        </div>

    </section>
</section>


<?php
include(FOOTER_TEMPLATE); ?>
