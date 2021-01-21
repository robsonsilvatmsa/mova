<?php
require_once('../../config.php');
require_once("../../vendor/autoload.php");

use Source\models\TableValores;
use Source\controllers\Valores;
use Source\models\Focus;

$function = new Valores();
abresessao();


$tablevalores = new TableValores();
$id = $_GET['id'];
$valores = $tablevalores->findById($id);

//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Cadastro';

if (!empty($_POST['valor']) && !empty($_POST["foco"])) {
    $function->update($_POST["valor"], $_POST['foco'], $id);
} elseif (!empty($_POST['valor'])) {
    $function->update($_POST["valor"], "", $id);
}

?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Ajuste de Valores</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Valores</span></li>
            </ul>
            <p class="sidebar-right-toggle"></p>
        </div>

    </header>


    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">

            </div>

            <h2 class="panel-title">Valores</h2>
        </header>
        <div class="panel-body">
            <div class="table-striped">
                <form method="post" action="#">
                    <div class="panel-body">
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <?php if (!empty($valores->descricao)): ?>
                                    <h4><?= $valores->descricao ?></h4>
                                <?php else: ?>
                                    <?= $focus = ((new Focus())->findById($valores->idfoco))->focus_description ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label>Valor:</label>
                                <input type="number" name="valor" placeholder="Valor" class="form-control"
                                       value="<?= $valores->valor ?>">
                            </div>
                        </div>
                    </div>
                    <?php
                    if (!empty($valores->idfoco)) {
                        $Focus = new Focus();
                        $foco = $Focus->find()->fetch(true);
                    }

                    if (!empty($foco)):

                        ?>
                        <div class="panel-body">
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <label>Foco:</label>
                                    <select class="form-control" name="foco">
                                        <option>
                                        </option>
                                        <?php foreach ($foco as $item): ?>
                                            <option value="<?= $item->id ?>">
                                                <?= $item->focus_description ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                    <?php endif; ?>

                    <footer class="panel-footer">
                        <button class="btn btn-success">Salvar</button>
                        <a href="<?= BASEURL ?>cadastros/Valores" class="btn btn-danger">cancelar</a>
                    </footer>
                </form>
            </div>
        </div>
    </section>
</section>
<?php include(FOOTER_TEMPLATE); ?>
