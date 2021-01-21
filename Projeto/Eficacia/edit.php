<?php
require_once('../../config.php');
require_once("../../vendor/autoload.php");

use Source\controllers\EficaciaProjeto;
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

$function = new EficaciaProjeto();
abresessao();
$idmelhoria = $_GET['id'];

$melhoria = new Project();
$mel = $melhoria->find()->fetch(true);
$area = $TableArea->find()->fetch(true);
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
            $_POST['rdbproblema'],
            $_POST['rdbmetodo'],
            $_POST['rdbcausa'],
            $_POST['rdpprojeto']
            ,
            $_POST['rdbresultado'],
            $_POST['rdbabrproj'],
            $_POST['rdbabrsolucao'],
        ], $idmelhoria);
    }

}

?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<script type="text/javascript" src="<?= BASEURL ?>/assets/vendor/jquery/jquery.js"></script>
<script type="text/javascript" src="<?= BASEURL ?>/assets/js/AnaliseEficaciaProj.js"></script>


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
                    <?php $anexo = $anexos->find("idProvisorio = '$proj->id'")->fetch(true); ?>
                    <?php
                    if ($anexo): ?>
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
                                <h3 class="col-sm-offset-1">Metodologia e Execução</h3>
                                <br>
                                &nbsp;<label>O Problema está claramente definido/identificado?</label>
                                <div class="col-sm-offset-1">
                                    <input type="radio" id="rdbproblema" name="rdbproblema"
                                           value="Sim"><label>Sim</label>&nbsp;&nbsp;
                                    <input type="radio" id="rdbproblema1" name="rdbproblema"
                                           value="Não"><label>Não</label>
                                </div>
                                <br>
                                <label>O método analise da causa raiz está corretamente aplicado?</label>
                                <div class="col-sm-offset-1">
                                    <input type="radio" id="rdbmetodo" name="rdbmetodo"
                                           value="Sim"><label>Sim</label>&nbsp;&nbsp;
                                    <input type="radio" id="rdbmetodo1" name="rdbmetodo"
                                           value="Não"><label>Não</label>
                                </div>
                                <br>
                                &nbsp;<label>A causa raiz apresentada se eliminada impede que o problema ocorra?</label>
                                <div class="col-sm-offset-1">
                                    <input type="radio" id="rdbcausa" name="rdbcausa" value="Sim"><label>Sim</label>&nbsp;&nbsp;
                                    <input type="radio" id="rdbcausa1" name="rdbcausa" value="Não"><label>Não</label>
                                </div>
                                <br>
                                &nbsp;<label>O Projeto foi desenvolvido e implementado pelo próprio grupo sem recursos
                                    de outras áreas?</label>
                                <div class="col-sm-offset-1">
                                    <input type="radio" id="rdpprojeto" name="rdpprojeto"
                                           value="Sim"><label>Sim</label>&nbsp;&nbsp;
                                    <input type="radio" id="rdpprojeto1" name="rdpprojeto"
                                           value="Não"><label>Não</label>
                                </div>

                            </div>
                            <div class="col-sm-12 col-sm-offset-1">
                                <h3 class="col-sm-offset-1">Resultado</h3>
                                <br>
                                &nbsp;<label>O resultado do projeto possui alto impacto no resultado.(Analisar em
                                    relação ao foco específico do projeto)?</label>
                                <div class="col-sm-offset-1">
                                    <input type="radio" id="rdbresultado" name="rdbresultado"
                                           value="Sim"><label>Sim</label>&nbsp;&nbsp;
                                    <input type="radio" id="rdbresultado1" name="rdbresultado"
                                           value="Não"><label>Não</label>
                                </div>
                                <br>


                            </div>
                            <div class="col-sm-12 col-sm-offset-1">
                                <h3 class="col-sm-offset-1">Inovação</h3>
                                <br>
                                &nbsp;<label>O Projeto trouxe retorno para diversas áreas, avaliar abrangência?</label>
                                <div class="col-sm-offset-1">
                                    <input type="radio" id="rdbabrproj" name="rdbabrproj"
                                           value="Sim"><label>Sim</label>&nbsp;&nbsp;
                                    <input type="radio" id="rdbabrproj1" name="rdbabrproj"
                                           value="Não"><label>Não</label>
                                </div>
                                <br>
                                &nbsp;<label>A solução proposta é inovadora, não existe em nenhuma outra área da
                                    empresa?</label>
                                <div class="col-sm-offset-1">
                                    <input type="radio" id="rdbabrsolucao" name="rdbabrsolucao"
                                           value="Sim"><label>Sim</label>&nbsp;&nbsp;
                                    <input type="radio" id="rdbabrsolucao1" name="rdbabrsolucao"
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
                    <a href="<?= BASEURL ?>Projeto/eficacia" class="btn btn-danger">cancelar</a>
                </footer>

                <br>
            </form>
        </div>

    </section>
</section>


<?php include(FOOTER_TEMPLATE); ?>
