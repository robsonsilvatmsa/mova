<?php
require_once('../../config.php');
require_once("../../vendor/autoload.php");

use Source\controllers\AnalisarMelhoria;
use Source\models\Melhoria;



use Source\models\AbrangenciaMelhoria;
use Source\models\Anexos;
use Source\models\Focus;
use Source\models\Group;
use Source\models\TableArea;


$group = new Group();


$TableArea = new TableArea();

$anexos = new Anexos();
$id = $_GET['id'];
$melhoria = new Melhoria();
$abrangencia = new AbrangenciaMelhoria();

$foco = new Focus();


$area = $TableArea->find()->fetch(true);

$function = new AnalisarMelhoria();
abresessao();
$idmelhoria = $_GET['id'];
$area = $_GET['area'];
$melhoria = new Melhoria();
$mel = $melhoria->find("id = $id")->fetch(true);
//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Melhoria';

if (!empty($_POST['rdbSuper']) || !empty($_POST['rdbEngInd']) || !empty($_POST['rdbSesmt'])) {
    $obs = '';
    if (!empty($_POST['rdbSuper'])) {
        if (!empty($_POST['txtAvaliacao']))
            $obs = $_POST['txtAvaliacao'];
        $function->save($idmelhoria, $area, $_POST['txtsuper'], $obs, $_POST['rdbSuper'], $_SESSION['nome']);
    } elseif (!empty($_POST['rdbEngInd'])) {
        if (!empty($_POST['txtAvaliacaoEng']))
            $obs = $_POST['txtAvaliacaoEng'];
        $function->save($idmelhoria, $area, $_POST['txtEng'], $obs, $_POST['rdbEngInd'], $_SESSION['nome']);
    } elseif (!empty($_POST['rdbSesmt'])) {
        if (!empty($_POST['txtAvaliacaoSesmt']))
            $obs = $_POST['txtAvaliacaoSesmt'];
        $function->save($idmelhoria, $area, $_POST['txtSesmt'], $obs, $_POST['rdbSesmt'], $_SESSION['nome']);
    }
}
if (!empty($_GET['seq'])) {
    $seq = $_GET['seq'];
}
?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<script type="text/javascript" src="<?= BASEURL ?>/assets/vendor/jquery/jquery.js"></script>
<script type="text/javascript" src="<?= BASEURL ?>/assets/js/AnaliseMelhoria.js"></script>
<script>
    $(window).load(function () {
        document.getElementById("super").style.display = 'none';
        document.getElementById("engind").style.display = 'none';
        document.getElementById("sesmt").style.display = 'none';
        if (<?= $seq?> === 1) {
            document.getElementById("super").style.display = '';
            document.getElementById("engind").style.display = 'none';
            document.getElementById("sesmt").style.display = 'none';
        } else if (<?= $seq?> === 2) {
            document.getElementById("super").style.display = 'none';
            document.getElementById("engind").style.display = '';
            document.getElementById("sesmt").style.display = 'none';
        } else if (<?= $seq?> === 3) {
            document.getElementById("super").style.display = 'none';
            document.getElementById("engind").style.display = 'none';
            document.getElementById("sesmt").style.display = '';
        }
    });
</script>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Analise De Melhoria</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Analise De Melhoria</span></li>
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
                <h2 class="panel-title">Analise De Melhoria</h2>
            </header>

            <br>
            <form method="post" action="#">
                <div id="super">
                    <header class="panel-heading center">
                        <h2 class="panel-title">Supervisão</h2>
                    </header>

                    <div class="panel-body">
                        <div class="col-sm-12">
                            <label>Ideia Aprovada?</label>
                            <br>
                            <input type="radio" name="rdbSuper" value="Sim" onclick="ocultaranaliseSup()">&nbsp;<label>Sim</label>
                            <br>
                            <input id="SupRejeita" type="radio" name="rdbSuper" value="Não"
                                   onclick="analiseSup()">&nbsp;<label>Não</label>
                        </div>
                        <div id="Avaliacao" class="col-sm-12" style="display: none">
                            <div class="col-sm-2">
                                <input id="rdbsup" name="txtAvaliacao" type="radio" value="Simples">
                                <label>Simples Manutenção</label>
                            </div>
                            <div class="col-sm-2">
                                <input name="txtAvaliacao" type="radio" value="Não é de Interesse">
                                <label>Não é de Interesse da Empresa</label>
                            </div>
                            <div class="col-sm-2">
                                <input name="txtAvaliacao" type="radio" value="Atribuicao">
                                <label>Atribuição do Colaborador</label>
                            </div>
                            <div class="col-sm-1">
                                <input name="txtAvaliacao" type="radio" value="Existe">
                                <label>Já Existente</label>
                            </div>
                            <div class="col-sm-2">
                                <input name="txtAvaliacao" type="radio" value="outro" onclick="obrigatorioSup()">
                                <label>Outro</label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label>Parecer</label>
                            <textarea id="txtsuper" name="txtsuper" class="form-control" rows="8"></textarea>
                        </div>
                    </div>
                    <br>
                </div>

                <div id="engind">
                    <header class="panel-heading center">
                        <h2 class="panel-title">Engenharia Industrial</h2>
                    </header>

                    <div class="panel-body">
                        <div class="col-sm-12">
                            <label>Ideia Aprovada?</label>
                            <br>
                            <input type="radio" name="rdbEngInd" value="Sim" onclick="ocultaranalisaEng()">&nbsp;<label>Sim</label>
                            <br>
                            <input id="EngRejeita" type="radio" name="rdbEngInd" value="Não"
                                   onclick="analisaEng()">&nbsp;<label>Não</label>
                        </div>
                        <div id="AvaliacaoEng" class="col-sm-12" style="display: none">
                            <div class="col-sm-2">
                                <input id="rdbengind" name="txtAvaliacaoEng" type="radio"
                                       value="Inviável Economicamente">
                                <label>Inviável Economicamente</label>
                            </div>
                            <div class="col-sm-2">
                                <input name="txtAvaliacaoEng" type="radio" value="Compromete Custos">
                                <label>Compromete Custos</label>
                            </div>
                            <div class="col-sm-2">
                                <input name="txtAvaliacaoEng" type="radio" value="Compromete a Produtividade">
                                <label>Compromete a Produtividade</label>
                            </div>
                            <div class="col-sm-2">
                                <input name="txtAvaliacaoEng" type="radio" value="Compromete o Processo">
                                <label>Compromete o Processo</label>
                            </div>
                            <div class="col-sm-2">
                                <input name="txtAvaliacaoEng" type="radio" value="outro" onclick="obrigatorioEng()">
                                <label>Outro</label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label>Parecer</label>
                            <textarea id="txtEng" name="txtEng" class="form-control" rows="8"></textarea>
                        </div>
                    </div>
                    <br>
                </div>

                <div id="sesmt">
                    <header class="panel-heading center">
                        <h2 class="panel-title">SESMT</h2>
                    </header>

                    <div class="panel-body">
                        <div class="col-sm-12">
                            <label>Ideia Aprovada?</label>
                            <br>
                            <input onclick="ocultaranalisaSesmt()" type="radio" name="rdbSesmt"
                                   value="Sim">&nbsp;<label>Sim</label>
                            <br>
                            <input id="SesRejeita" type="radio" name="rdbSesmt" value="Não"
                                   onclick="analisaSesmt()">&nbsp;<label>Não</label>
                        </div>
                        <div id="AvaliacaoSesmt" class="col-sm-12" style="display: none">
                            <div class="col-sm-2">
                                <input name="txtAvaliacaoSesmt" type="radio" value="Compromete a Segurança">
                                <label>Compromete a Segurança</label>
                            </div>
                            <div class="col-sm-2">
                                <input id="rdbsesmt" name="txtAvaliacaoSesmt" type="radio"
                                       value="Compromete o Meio Ambiente">
                                <label>Compromete o Meio Ambiente</label>
                            </div>
                            <div class="col-sm-2">
                                <input name="txtAvaliacaoSesmt" type="radio" value="outro" onclick="obrigatorioSesmt()">
                                <label>Outro</label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label>Parecer</label>
                            <textarea id="txtSesmt" name="txtSesmt" class="form-control" rows="8"></textarea>
                        </div>
                    </div>
                    <br>
                </div>

                <footer class="panel-footer">
                    <button class="btn btn-success">Incluir</button>
                    <a href="<?= BASEURL ?>melhoria/Analise" class="btn btn-danger">cancelar</a>
                </footer>

                <br>
            </form>
        </div>

    </section>
</section>


<?php include(FOOTER_TEMPLATE); ?>
