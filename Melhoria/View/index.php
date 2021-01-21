<?php

require_once('../../config.php');
require_once("../../vendor/autoload.php");

use Source\controllers\ViewMelhoria;
use Source\models\AbrangenciaMelhoria;
use Source\models\AnaliseDaMelhoria;
use Source\models\Anexos;
use Source\models\Focus;
use Source\models\Group;
use Source\models\ImprovementAnalyzer;
use Source\models\Melhoria;
use Source\models\TableArea;
use Source\models\TableEficaciaMelhoria;

$group = new Group();


$view = new ViewMelhoria();
abresessao();
$id = $_GET['id'];
$melhoria = new Melhoria();
$abrangencia = new AbrangenciaMelhoria();
$anexos = new Anexos();
$area = new TableArea();
$foco = new Focus();
$eficacia = (new TableEficaciaMelhoria())->find("idmelhoria = {$id}")->fetch(true);


$analisador = (new ImprovementAnalyzer())->find("idmelhoria = $id")->fetch(true);
if (!empty($analisador)) {
    foreach ($analisador as $analise) {
        if (!empty($idanali)) {
            $idanali = $idanali . ',';
            $idanali = $idanali . $analise->id;
        } else {
            $idanali = $analise->id;
        }
    }

    $analiseprojeto = (new AnaliseDaMelhoria())->find("idAnalisador in ($idanali) ")->fetch(true);
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

                    <h2 class="panel-title">Melhoria</h2>

                </header>
                <?php
                foreach ($mel as $itemMel): ?>
                    <div class="panel-body">
                        <header class="panel-heading right-side ">
                            <span>N° do Registro: <?= sprintf('%08d', $itemMel->id); ?></span>
                            <br>
                            <span>Grupo: <?php
                                $grupo = $group->findById($itemMel->IdGrupo);
                                echo $grupo->name_group; ?></span>
                            <br>

                        </header>
                        <div class="col-md-6"><label>Melhoria Registrada
                                Em: <?= date_format(date_create($itemMel->DataInicio), "d/m/Y") ?></label></div>
                        <div class="col-md-6"><label>Melhoria Encerrada
                                Em: <?php
                                if (!empty($itemMel->DataEncerramento)) {
                                    echo date_format(date_create($itemMel->DataEncerramento), "d/m/Y");
                                } else {
                                    "";
                                }
                                ?> </label>
                        </div>
                        <br>
                        <hr>
                        <span>
                            Status da Melhoria:
                        </span>

                        <span>
                        <?php
                        $status = $itemMel->status;
                        if ($status == 0) {
                            echo "Enviado para Analise";
                        } elseif ($status == 1) {
                            echo "Em Analise";
                        } elseif ($status == 2) {
                            echo "Aprovada";
                        } elseif ($status == 3) {
                            echo "Implantada";
                        } elseif ($status == 4) {
                            echo "Rejeitada";
                        } elseif ($status == 5) {
                            echo "Avaliada Equipe Mova";
                        }
                        ?>
                        </span>

                        <div class="row">
                            <br>
                            <div class="col-lg-6">
                                <label>Área de Implantação:</label>

                                <?php
                                $areaimp = $area->findById($itemMel->IdAreaImplantada);
                                if (!empty($areaimp)) {
                                    echo $areaimp->description_area;
                                } ?>
                            </div>
                            <br>
                            <div class="col-lg-6">
                                <label>Abrangencia da Melhoria:</label>
                                <?php
                                $abran = $abrangencia->find("[idmelhoria] =$itemMel->id")->fetch(true) ?>
                                <?php
                                if (!empty($abran)): ?>
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
                            &nbsp;<br>
                            <div class="input-group mb-md">
                                <span class="input-group-addon">R$</span>
                                <input type="text" name="txtvalor" readonly id="price" class="form-control"
                                       value="<?= $itemMel->ValorInvestimento ?>">
                                <span class="input-group-addon ">,00</span>
                            </div>
                        </div>
                        <div class="row">
                            <?php
                            $anexo = $anexos->find("idProvisorio = '$itemMel->id' and origem = 'melhoria'")->fetch(true); ?>
                            <?php
                            if ($anexo):?>
                                <ul>
                                    <?php
                                    foreach ($anexo as $itemanexo): ?>
                                        <li>
                                            <a href="<?= BASEURL ?>/Melhoria/inclusao/uploads/<?= $itemanexo->arquivo ?>">
                                                <?= $itemanexo->arquivo ?></a>
                                        </li>
                                    <?php
                                    endforeach; ?>
                                </ul>
                            <?php
                            endif; ?>
                        </div> <!-- /.row -->
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
                                               Resultado Obtido:
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
                    <a href="<?= BASEURL ?>melhoria" class="btn btn-danger">Voltar</a>
                </footer>
            </section>

        </div>

    </section>
</section>


<?php
include(FOOTER_TEMPLATE); ?>
