<?php
require_once('../../config.php');
require_once("../../vendor/autoload.php");

use Source\controllers\EficaciaMelhoria;
use Source\models\AbrangenciaMelhoria;
use Source\models\Anexos;
use Source\models\Focus;
use Source\models\Group;
use Source\models\Melhoria;
use Source\models\TableArea;


$group = new Group();


$TableArea = new TableArea();

$anexos = new Anexos();
$id = $_GET['id'];
$melhoria = new Melhoria();
$abrangencia = new AbrangenciaMelhoria();

$foco = new Focus();


$area = $TableArea->find()->fetch(true);

$function = new EficaciaMelhoria();
abresessao();
$idmelhoria = $_GET['id'];

$melhoria = new Melhoria();
$mel = $melhoria->find("id = $id")->fetch(true);
//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Melhoria';

if (!empty($_POST['rdbSuper'])) {
    $obs = '';

    if (!empty($_POST['txtAvaliacao'])) {
        $obs = $_POST['txtAvaliacao'];
    }

    if (!empty($obs)) {
        $function->save($_POST['rdbSuper'], $_POST['txtparecer'], $obs, $idmelhoria);
    } else {
        $function->save($_POST['rdbSuper'], $_POST['txtparecer'], [
            $_POST['rdbResultadomel'],
            $_POST['rdbResultadogrupo'],
            $_POST['rdbAbrang'],
            $_POST['rdbInovacao'],
        ], $idmelhoria);
    }

}

?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<script type="text/javascript" src="<?= BASEURL ?>/assets/vendor/jquery/jquery.js"></script>
<script type="text/javascript" src="<?= BASEURL ?>/assets/js/AnaliseEficaciaMel.js"></script>


<section role="main" class="content-body">
    <header class="page-header">
        <h2>Analise De Eficácia</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Analise De Eficácia</span></li>
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


        <div class="col-md-12">
            <header class="panel-heading center">
                <h2 class="panel-title">Analise De Eficácia</h2>
            </header>

            <br>
            <form method="post" action="#">
                <div id="super">
                    <header class="panel-heading center">
                        <h2 class="panel-title">Eficácia</h2>
                    </header>

                    <div class="panel-body">
                        <div class="col-sm-12">
                            <label>Ideia Aprovada?</label>
                            <br>
                            <input type="radio" name="rdbSuper" value="Sim"
                                   onclick="eficacia()">&nbsp;<label>Sim</label>
                            <br>
                            <input id="SupRejeita" type="radio" name="rdbSuper" value="Não"
                                   onclick="analiseSup()">&nbsp;<label>Não</label>
                        </div>
                        <div id="Avaliacao" class="col-sm-12" style="display: none">
                            <div class="col-sm-4">
                                <input id="txtAvaliacao" name="txtAvaliacao" type="radio" value="Simples">
                                <label>Rever Considerações</label>
                            </div>
                            <div class="col-sm-4">
                                <input id="txtAvaliacao1" name="txtAvaliacao" type="radio" value="Existe">
                                <label>Não Eficaz</label>
                            </div>
                            <div class="col-sm-4">
                                <input id="txtAvaliacao2" name="txtAvaliacao" type="radio" value="outro"
                                       onclick="obrigatorioSup()">
                                <label>Outro</label>
                            </div>

                        </div>
                        <div id="Eficacia" style="display: none">
                            <div class="col-sm-12 col-sm-offset-1">
                                <h3 class="col-sm-offset-1">Resultado</h3>
                                <br>
                                &nbsp;<label>O Resultado da melhoria
                                    possui impacto no resultado (Analisar em relação ao foco específico da
                                    melhoria)?</label>
                                <div class="col-sm-offset-1">
                                    <input type="radio" id="rdbResultadomel" name="rdbResultadomel" value="Sim"><label>Sim</label>&nbsp;&nbsp;
                                    <input type="radio" id="rdbResultadomel1" name="rdbResultadomel" value="Não"><label>Não</label>
                                </div>
                                <br>
                                <label>A Melhoria foi desenvolvida e implementada
                                    pelo próprio grupo sem recursos de outras áreas?</label>
                                <div class="col-sm-offset-1">
                                    <input type="radio" id="rdbResultadogrupo" name="rdbResultadogrupo"
                                           value="Sim"><label>Sim</label>&nbsp;&nbsp;
                                    <input type="radio" id="rdbResultadogrupo1" name="rdbResultadogrupo"
                                           value="Não"><label>Não</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-sm-offset-1">
                                <h3 class="col-sm-offset-1">Abrangência</h3>
                                <br>
                                &nbsp;<label>A Melhoria trouxe retorno para diversas áreas, avaliar abrangência?</label>
                                <div class="col-sm-offset-1">
                                    <input type="radio" id="rdbAbrang" name="rdbAbrang" value="Sim"><label>Sim</label>&nbsp;&nbsp;
                                    <input type="radio" id="rdbAbrang1" name="rdbAbrang" value="Não"><label>Não</label>
                                </div>

                            </div>
                            <div class="col-sm-12 col-sm-offset-1">
                                <h3 class="col-sm-offset-1">Inovação</h3>
                                <br>
                                &nbsp;<label>A solução proposta é inovadora, não existe em nenhuma outra área da
                                    empresa?</label>
                                <div class="col-sm-offset-1">
                                    <input type="radio" id="rdbInovacao" name="rdbInovacao"
                                           value="Sim"><label>Sim</label>&nbsp;&nbsp;
                                    <input type="radio" id="rdbInovacao1" name="rdbInovacao"
                                           value="Não"><label>Não</label>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label>Parecer</label>
                            <textarea id="txtsuper" name="txtparecer" class="form-control" rows="8"></textarea>
                        </div>
                    </div>
                    <br>
                </div>


                <footer class="panel-footer">
                    <button class="btn btn-success">Incluir</button>
                    <a href="<?= BASEURL ?>melhoria/eficacia" class="btn btn-danger">cancelar</a>
                </footer>

                <br>
            </form>
        </div>

    </section>
</section>


<?php include(FOOTER_TEMPLATE); ?>
