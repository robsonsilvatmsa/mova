<?php
require_once('../config.php');
require_once("../vendor/autoload.php");
require_once(DBAPI);
abresessao();

use Source\models\ImprovementAnalyzer;
use Source\models\Melhoria;
use Source\models\Project;
use Source\models\ProjectAnalyzer;
use Source\models\TableArea;

$idArea = "";
$message = "";
$description = "";
$number = "";
$filter = [
    "id" => FILTER_SANITIZE_NUMBER_INT,
    "type" => FILTER_SANITIZE_STRING,
];

$get = filter_input_array(INPUT_GET, $filter);

if ($get['type'] == 'melhoria') {
    $mel = new Melhoria();

    $ImprovementAnalyzer = new ImprovementAnalyzer();

    $improvanalyzer = $ImprovementAnalyzer->find("status < 1 and idmelhoria =" . $get["id"])->fetch(true);
    $idmel = "";
    if ($improvanalyzer) {
        foreach ($improvanalyzer as $analise) {

            $idmel = $analise->idmelhoria;
            if ($idArea) {
                $idArea .= ",";
                $idArea .= $analise->idarea;
            } else {
                $idArea = $analise->idarea;
            }

        }


        $melhoria = $mel->findById($idmel)->fetch(true);
        $description = $melhoria->Descricao;
        $number = sprintf('%08d', $idmel);

    } else {
        $message = "<p class='alert alert-danger'>Não Existe Informações a Listar</p>";
    }

} elseif ($get['type'] == "projeto") {
    $ProjectAnalyzer = new ProjectAnalyzer();

    $analyzer = $ProjectAnalyzer->find("status < 1 and idprojeto =" . $get["id"])->fetch(true);
    $id = "";
    $idArea = "";
    if ($analyzer) {
        foreach ($analyzer as $value) {

            $id = $value->idprojeto;
            if ($idArea) {
                $idArea .= ",";
                $idArea .= $value->idarea;
            } else {
                $idArea = $value->idarea;
            }
        }
        $Project = new Project();

        $projetos = $Project->findById($id);
        $description = $projetos->Descricao;
        $number = sprintf('%08d', $id);
    } else {
        $message = "<p class='alert alert-danger'>Não Existe Informações a Listar</p>";
    }


} else {
    $message = "<p class='alert alert-danger'>Não Existe Informações a Listar</p>";
}


?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<section role="main" class="content-body">

    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">

            </div>

            <h2 class="panel-title">Acompanhamento de Aprovação <?= mb_convert_case("{$get['type']} número {$number}",
                    MB_CASE_TITLE) ?></h2>
        </header>
        <div class="panel-body">
            <div class="table-striped">
                <?php if ($message): ?>
                    <?= $message ?>
                <?php else: ?>
                    <p class='alert alert-success'><b>Descrição <?= mb_convert_case($get['type'] . ": ",
                            MB_CASE_TITLE) . "</b>", $description ?></p>
                    <?php if ($idArea): ?>
                        <?php $area = (new TableArea())->find(" id in ($idArea)")->fetch(true); ?>
                        <?php if ($area): ?>
                            <?php foreach ($area as $item): ?>
                                <p class='alert alert-warning'>Area Pendente de
                                    Aprovação: <?= "{$item->description_area}" ?></p>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>

            </div>
        </div>
    </section>


</section>
<?php include(FOOTER_TEMPLATE); ?>

