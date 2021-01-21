<?php
require_once('../../config.php');
require_once("../../vendor/autoload.php");

use Source\controllers\AnaliseProj;
use Source\models\AbrangenciaProjeto;
use Source\models\Anexos;
use Source\models\EspinhaPeixeProj;
use Source\models\Focus;
use Source\models\Group;
use Source\models\Porques;
use Source\models\Project;
use Source\models\TableArea;


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

$function = new AnaliseProj();
abresessao();
$idProjeto = $_GET['id'];
$area = $_GET['area'];
$Projeto = new Project();
$mel = $Projeto->find()->fetch(true);

//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Projeto';

if (!empty($_POST['rdbSuper']) || !empty($_POST['rdbEngInd']) || !empty($_POST['rdbSesmt'])) {
    $obs = '';
    if (!empty($_POST['rdbSuper'])) {
        if (!empty($_POST['txtAvaliacao'])) {
            $obs = $_POST['txtAvaliacao'];
        }
        $function->save($idProjeto, $area, $_POST['txtsuper'], $obs, $_POST['rdbSuper'], $_SESSION['nome']);
    } elseif (!empty($_POST['rdbEngInd'])) {
        if (!empty($_POST['txtAvaliacaoEng'])) {
            $obs = $_POST['txtAvaliacaoEng'];
        }
        $function->save($idProjeto, $area, $_POST['txtEng'], $obs, $_POST['rdbEngInd'], $_SESSION['nome']);
    } elseif (!empty($_POST['rdbSesmt'])) {
        if (!empty($_POST['txtAvaliacaoSesmt'])) {
            $obs = $_POST['txtAvaliacaoSesmt'];
        }
        $function->save($idProjeto, $area, $_POST['txtSesmt'], $obs, $_POST['rdbSesmt'], $_SESSION['nome']);
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
<script type="text/javascript" src="<?= BASEURL ?>/assets/js/AnaliseProjeto.js"></script>
<script>
    $(window).load(function () {
        document.getElementById("super").style.display = 'none';
        document.getElementById("engind").style.display = 'none';
        document.getElementById("sesmt").style.display = 'none';
        document.getElementById("qualidade").style.display = 'none';
        if (<?= $seq?> == 1) {
            document.getElementById("super").style.display = '';
            document.getElementById("engind").style.display = 'none';
            document.getElementById("sesmt").style.display = 'none';
            document.getElementById("qualidade").style.display = 'none';
            document.getElementById("supaprova").setAttribute("required", "true");
        } else if (<?= $seq?> == 2) {
            document.getElementById("super").style.display = 'none';
            document.getElementById("engind").style.display = '';
            document.getElementById("sesmt").style.display = 'none';
            document.getElementById("qualidade").style.display = 'none';
            document.getElementById("EngRejeita").setAttribute("required", "true");
        } else if (<?= $seq?> == 3) {
            document.getElementById("super").style.display = 'none';
            document.getElementById("engind").style.display = 'none';
            document.getElementById("sesmt").style.display = '';
            document.getElementById("qualidade").style.display = 'none';
            document.getElementById("SesRejeita").setAttribute("required", "true");
        } else if (<?= $seq?> == 4) {
            document.getElementById("super").style.display = 'none';
            document.getElementById("engind").style.display = 'none';
            document.getElementById("sesmt").style.display = 'none';
            document.getElementById("qualidade").style.display = '';
            document.getElementById("QualiRejeita").setAttribute("required", "true")
        }
    });
</script>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Analise De Projeto</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Analise De Projeto</span></li>
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
                        echo $grupo->name_group; ?></span>
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
                               value="<?= floatval($proj->ValorInvestimento) ?>">
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
                    <?php $anexo = $anexos->find("idProvisorio = '$proj->id'")->fetch(true); ?>
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


        <div class="col-md-12">
            <header class="panel-heading center">
                <h2 class="panel-title">Analise De Projeto</h2>
            </header>

            <br>
            <form method="post" action="#">
                <div id="super">
                    <header class="panel-heading center">
                        <h2 class="panel-title">Supervisão</h2>
                    </header>

                    <div class="panel-body">
                        <div class="col-sm-12">
                            <label>Projeto Aprovado?</label>
                            <br>
                            <input type="radio" name="rdbSuper" value="Sim"
                                   onclick="ocultaranaliseSup()">&nbsp;<label>Sim</label>
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
                            <label>Projeto Aprovado?</label>
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
                            <label>Projeto Aprovado?</label>
                            <br>
                            <input type="radio" name="rdbSesmt" value="Sim"
                                   onclick="ocultaranalisaSesmt()">&nbsp;<label>Sim</label>
                            <br>
                            <input id="SesRejeita" type="radio" name="rdbSesmt" value="Não"
                                   onclick="analisaSesmt()">&nbsp;<label>Não</label>
                        </div>
                        <div id="AvaliacaoSesmt" class="col-sm-12" style="display: none">
                            <div class="col-sm-2">
                                <input id="rdbsesmt" name="txtAvaliacaoSesmt" type="radio"
                                       value="Compromete a Segurança">
                                <label>Compromete a Segurança</label>
                            </div>
                            <div class="col-sm-2">
                                <input name="txtAvaliacaoSesmt" type="radio" value="Compromete o Meio Ambiente">
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

                <div id="qualidade">
                    <header class="panel-heading center">
                        <h2 class="panel-title">Qualidade</h2>
                    </header>

                    <div class="panel-body">
                        <div class="col-sm-12">
                            <label>Projeto Aprovado?</label>
                            <br>
                            <input type="radio" name="rdbquali" value="Sim"
                                   onclick="ocultarqual()">&nbsp;<label>Sim</label>
                            <br>
                            <input id="QualiRejeita" type="radio" name="rdbquali" value="Não"
                                   onclick="analisaQualidade()">&nbsp;<label>Não</label>
                        </div>
                        <div id="AvaliacaoQualidade" class="col-sm-12" style="display: none">
                            <div class="col-sm-2">
                                <input id="rdbquali" name="txtAvaliacaoQuali" type="radio"
                                       value="Compromete a Segurança">
                                <label>Compromete a Qualidade</label>
                            </div>
                            <div class="col-sm-2">
                                <input name="txtAvaliacaoQuali" type="radio" value="outro" onclick="obrigatorioSesmt()">
                                <label>Outro</label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label>Parecer</label>
                            <textarea id="txtQuali" name="txtQuali" class="form-control" rows="8"></textarea>
                        </div>
                    </div>
                    <br>
                </div>

                <footer class="panel-footer">
                    <button class="btn btn-success">Incluir</button>
                    <a href="<?= BASEURL ?>Projeto/Analise" class="btn btn-danger">cancelar</a>
                </footer>

                <br>
            </form>
        </div>

    </section>
</section>


<?php include(FOOTER_TEMPLATE); ?>
