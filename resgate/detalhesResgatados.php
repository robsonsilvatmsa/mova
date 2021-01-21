<?php
require_once('../config.php');
require_once("../vendor/autoload.php");


use Source\controllers\ResgateMelhoria;
use Source\models\Group;
use Source\models\UserGroup;
use Source\models\User;
use Source\models\Melhoria;
use Source\models\Project;


$group = (new Group())->find()->fetch(true);

$resgate = new ResgateMelhoria();

abresessao();
$_SESSION['menu'] = '';

$connection = new PDO("sqlsrv:Database=MOVA;server=sql003.tecno.local", "portal", "fkj#5htmsa2018");

$idgrupo = $_GET['idgrupo'];
$nome = $_GET['nome'];
$matricula = $_GET['matricula'];

$statement = $connection->prepare('select  m.* from Melhoria as m WHERE m.status = 5 and m.resgatado = 1 and m.IdGrupo= '.$idgrupo);
$statement->execute();
$dadosMelhoria = $statement->fetchAll();

$statement = $connection->prepare('select  p.* from Project as p WHERE p.status = 5 and p.resgatado = 1 and p.idGrupo='.$idgrupo);
$statement->execute();
$dadosProjetos = $statement->fetchAll();

function valorMelhoriaUser($idgrupo, $valorMelhoria){
    $connection = new PDO("sqlsrv:Database=MOVA;server=sql003.tecno.local", "portal", "fkj#5htmsa2018");
    $statement = $connection->prepare('select * from usuariogrupo where idgrupo ='.$idgrupo);
    $statement->execute();
    $qtdUser = count($statement->fetchAll());
    $valorCada = ($valorMelhoria/$qtdUser);
    return  number_format(($valorCada), 2, ",", ".");
}
function valorProjetoUser($idgrupo, $valorProjeto){
    $connection = new PDO("sqlsrv:Database=MOVA;server=sql003.tecno.local", "portal", "fkj#5htmsa2018");
    $statement = $connection->prepare('select * from usuariogrupo where idgrupo ='.$idgrupo);
    $statement->execute();
    $qtdUser = count($statement->fetchAll());
    $valorCada = ($valorProjeto/$qtdUser);
    return  number_format(($valorCada), 2, ",", ".");
}

?>
<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Resgate Melhoria e Projeto</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Resgate Melhoria e Projeto</span></li>
            </ul>
            <p class="sidebar-right-toggle"></p>
        </div>

    </header>
    <div class="panel-body" style="margin-bottom: 15px; background-color: #DADDE1">
        <a type="button" href="index.php"
           class="mb-xs mt-xs mr-xs btn btn-default">Voltar</a>

    </div>
    <div class="row" style="border-style: solid; border-width: 1px; font-size: 20px; padding: 5px">
        <div class="col-2 col-sm-1">Nome</div>
        <div class="col-2 col-sm-5" id='nome'><b><?php echo $nome ?></b></div>
        <div class="col-4 col-sm-2">Matricula</div>
        <div class="col-6 col-sm-4" id="grupo"><b><?php echo $matricula ?></b></div>
    </div>
    <br>
        <?php
        if($dadosMelhoria):
            echo "<h2 style='margin-top: 0'>MELHORIAS</h2>";
            foreach ($dadosMelhoria as $dadoMelhoria): ?>
                <table class="table" style="border-style: solid; border-width: 1px">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Numero Melhoria</th>
                        <th scope="col">Nome Melhoria</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Data do resgate</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th id="numero"><?= sprintf('%08d', $dadoMelhoria["id"] ) ?></th>
                        <th id="melhoria"><?= $dadoMelhoria["Descricao"] ?></th>
                        <td id='valor'><?= valorMelhoriaUser($dadoMelhoria["IdGrupo"], $dadoMelhoria["ValorMelhoria"]) ?></td>
                        <td id="dataencerramento">
                            <?= date_format(date_create($dadoMelhoria["data_resgate"]), "d/m/Y"); ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
        <?php   endforeach;
                    endif;
        ?>
    <?php
        if ($dadosProjetos):
            echo "<h2 style='margin-top: 0'>Projetos</h2>";
            foreach ($dadosProjetos as $dadoProjeto):
        ?>
        <table class="table" style="border-style: solid; border-width: 1px">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Numero Melhoria / Projeto</th>
                <th scope="col">Melhoria / Projeto</th>
                <th scope="col">Valor</th>
                <th scope="col">Data do resgate</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th id="numero"><?= sprintf('%08d', $dadoProjeto["id"] ) ?></th>
                <th id="melhoria"><?= $dadoProjeto["Descricao"] ?></th>
                <td id='valor'><?= valorProjetoUser($dadoProjeto["idGrupo"], $dadoProjeto["ValorProjeto"]) ?></td>
                <td id="dataencerramento">
                    <?= date_format(date_create($dadoProjeto["data_resgate"]), "d/m/Y"); ?>
                </td>
            </tr>
            </tbody>
        </table>
    <?php
            endforeach;
            endif;?>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php include(FOOTER_TEMPLATE); ?>