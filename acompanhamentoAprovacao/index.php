<?php
require_once('../config.php');
require_once("../vendor/autoload.php");
require_once(DBAPI);
abresessao();

use Source\models\ImprovementAnalyzer;
use Source\models\Melhoria;
use Source\models\Project;
use Source\models\ProjectAnalyzer;

$mel = new Melhoria();
$ImprovementAnalyzer = new ImprovementAnalyzer();

$improvanalyzer = $ImprovementAnalyzer->find("status < 1")->fetch(true);
$idmel = "";
if ($improvanalyzer) {
    foreach ($improvanalyzer as $analise) {
        if ($idmel) {
            $idmel .= ',';
            $idmel .= $analise->idmelhoria;
        } else {
            $idmel = $analise->idmelhoria;
        }
    }
}
$melhoria = $mel->find("id in ($idmel)")->fetch(true);

$ProjectAnalyzer = new ProjectAnalyzer();

$analyzer = $ProjectAnalyzer->find("status < 1")->fetch(true);
$id = "";

if ($analyzer) {
    foreach ($analyzer as $value) {
        if ($id) {
            $id .= ',';
            $id .= $value->idprojeto;

        } else {
            $id = $value->idprojeto;
        }

    }
}


$Project = new Project();

$projetos = $Project->find("id in ($id)")->fetch(true);


$total = 0;
//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Melhoria';
$_SESSION['codprovisorio'] = uniqid();
?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<section role="main" class="content-body">

    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">

            </div>

            <h2 class="panel-title">Acompanhamento de Aprovação Projetos</h2>
        </header>
        <div class="panel-body">
            <div class="table-striped">
                <table class="table table-bordered table-striped mb-md" id="datatable-default">
                    <thead>
                    <tr>
                        <th>Número Projeto</th>
                        <th>Descrição</th>
                        <th>Data Inclusão</th>
                        <th>Pendencias de Aprovação</th>

                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($projetos): ?>
                        <?php foreach ($projetos as $value): ?>
                            <tr>
                                <td><?= sprintf('%08d', $value->id); ?></td>
                                <td><?= $value->Descricao; ?></td>
                                <td><?= date_format(date_create($value->DataInicio), "d/m/Y"); ?></td>
                                <td>
                                    <?php
                                    $result = find_query(" select count(idprojeto) as resultado from AnalisadorProjeto 
 where status < 1 and idprojeto = $value->id");
                                    if ($result) {
                                        foreach ($result as $item) {
                                            echo $item['resultado'];
                                        }
                                    }
                                    ?>

                                </td>


                                <td class="actions">
                                    <a href="<?= BASEURL ?>acompanhamentoaprovacao/acompanhamentoAprovacao.php?id=<?= $value->id ?>&type=projeto"
                                       class="delete-row" data-toggle="tooltip" title="Visualizar Projeto"><i
                                                class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <td colspan="10">
                            Não existe dados a listar
                        </td>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </section>


    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">

            </div>

            <h2 class="panel-title">Acompanhamento de Aprovação Melhoria</h2>
        </header>
        <div class="panel-body">
            <div class="table-striped">
                <table class="table table-bordered table-striped mb-md" id="datatable-tabletools">
                    <thead>
                    <tr>
                        <th>Número Melhoria</th>
                        <th>Descrição</th>
                        <th>Data Inclusão</th>
                        <th>Pendencias de Aprovação</th>

                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($melhoria): ?>
                        <?php foreach ($melhoria as $value): ?>
                            <tr>
                                <td><?= sprintf('%08d', $value->id); ?></td>
                                <td><?= $value->Descricao; ?></td>
                                <td><?= date_format(date_create($value->DataInicio), "d/m/Y"); ?></td>
                                <td>
                                    <?php
                                    $result = find_query(" select count(idmelhoria) as resultado from AnalisadorMelhoria 
 where status < 1 and idmelhoria = $value->id");
                                    if ($result) {
                                        foreach ($result as $item) {
                                            echo $item['resultado'];
                                        }
                                    }
                                    ?>

                                </td>


                                <td class="actions">
                                    <a href="<?= BASEURL ?>acompanhamentoaprovacao/acompanhamentoAprovacao.php?id=<?= $value->id ?>&type=melhoria"
                                       class="delete-row" data-toggle="tooltip" title="Visualizar Projeto"><i
                                                class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <td colspan="10">
                            Não existe dados a listar
                        </td>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </section>
</section>
<?php include(FOOTER_TEMPLATE); ?>

