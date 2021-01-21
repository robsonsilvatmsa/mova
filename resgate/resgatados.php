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

$user = new User();

function descMelhoria($grupoid)
{
    $melhoria = new  Melhoria();
    return $melhoria->find("IdGrupo = $grupoid and status = 5 and resgatado < 1 or IdGrupo = $grupoid and status = 5 and resgatado is null")->fetch();
}
function descProjetos($grupoid)
{
    $projeto = new  Project();
    return $projeto->find("IdGrupo = $grupoid and status = 5 and resgatado < 1 or IdGrupo = $grupoid and status = 5 and resgatado is null")->fetch();
}

abresessao();
$_SESSION['menu'] = '';

$connection = new PDO("sqlsrv:Database=MOVA;server=sql003.tecno.local", "portal", "fkj#5htmsa2018");

$statement = $connection->prepare('
    select distinct u.nome, u.id, u.matricula
from Melhoria as m, usuarios as u, Grupo as gp, usuariogrupo as ug
inner join usuarios on usuarios.id = ug.idusuario
inner join Melhoria on Melhoria.IdGrupo = ug.idgrupo
inner join Grupo on grupo.id = Melhoria.IdGrupo
    WHERE m.status = 5 and m.resgatado = 1 and u.id = ug.idusuario
	group by u.nome, u.id,gp.name_group,u.matricula order by u.nome
');

$statement->execute();
$dados = $statement->fetchAll();

function buscagrupo($iduser){
    $connection = new PDO("sqlsrv:Database=MOVA;server=sql003.tecno.local", "portal", "fkj#5htmsa2018");
    $statement = $connection->prepare('select * from usuariogrupo where idusuario = '.$iduser);
    $statement->execute();
    $dados = $statement->fetch();
    return $dados['idgrupo'];
}

?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Historico de Resgates</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Historico de Resgates</span></li>
            </ul>
            <p class="sidebar-right-toggle"></p>
        </div>

    </header>

    <table
        class="table table-striped table-bordered table-hover table-highlight table-checkable"
        data-provide="datatable"
        data-display-rows="15"
        data-info="false"
        data-paginate="false"
    >
        <thead>
        <tr>
            <th data-filterable="true" data-sortable="true" width="20%">Nome</th>
            <th data-filterable="true" data-sortable="true" data-direction="asc"width="20%" >Matricula</th>
            <th data-filterable="false" data-sortable="true" data-direction="asc"width="5%" ></th>

        </tr>
        </thead>
        <tbody>
        <?php foreach ($dados as $dado): ?>
            <tr>
                <td> <?= $dado["nome"] ?></td>
                <td><?=  $dado["matricula"] ?></td>
                <form method="get" action="detalhesResgatados.php">
                    <input type="hidden" name="idgrupo" value='<?= buscagrupo($dado["id"]) ?>'></input>
                    <input type="hidden" name="nome" value='<?=  $dado["nome"]  ?>'></input>
                    <input type="hidden" name="matricula" value='<?= $dado["matricula"] ?>'></input>
                    <td><button type="submit" class="btn btn-primary">
                        Ver detalhes
                    </button></td>
                </form>
            </tr>
        <?php endforeach ?>

        </tbody>
    </table>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php include(FOOTER_TEMPLATE); ?>
