<?php
require_once('../config.php');
require_once("../vendor/autoload.php");
require_once(DBAPI);
abresessao();


//Nome do pai do menu para identificar
$_SESSION['menu'] = 'Melhoria';

?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<section role="main" class="content-body">


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
                        <th>Relatórios</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <td class="actions">
                            <a href="<?= BASEURL ?>relatorio/relatorioquantidade.php"
                               class="delete-row" data-toggle="tooltip" title="Emitir Relatório">Quantidade de Projeto e
                                Melhoria por Área</a>
                        </td>

                    </tr>
                    <tr>
                        <td class="actions">
                            <a href="<?= BASEURL ?>relatorio/relatorioqtdgrupo.php"
                               class="delete-row" data-toggle="tooltip" title="Emitir Relatório">Quantidade de Projeto e
                                Melhoria por Grupo</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="actions">
                            <a href="<?= BASEURL ?>relatorio/relatorioqtdabrangencia.php"
                               class="delete-row" data-toggle="tooltip" title="Emitir Relatório">Quantidade de Projeto e
                                Melhoria por Abrangencia</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="actions">
                            <a href="<?= BASEURL ?>relatorio/relatorioqtdfoco.php"
                               class="delete-row" data-toggle="tooltip" title="Emitir Relatório">Quantidade de Projeto e
                                Melhoria por Foco</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="actions">
                            <a href="<?= BASEURL ?>relatorio/relatoriovalorrecebido.php"
                               class="delete-row" data-toggle="tooltip" title="Emitir Relatório">Valor Recebido por
                                Usuario</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="actions">
                            <a href="<?= BASEURL ?>relatorio/relatoriorecebidogrupo.php"
                               class="delete-row" data-toggle="tooltip" title="Emitir Relatório">Valor Recebido por
                                Grupo</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="actions">
                            <a href="<?= BASEURL ?>relatorio/relatorioqtdenganjamento.php"
                               class="delete-row" data-toggle="tooltip" title="Emitir Relatório">Enganjamento Por
                                Área</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="actions">
                            <a href="<?= BASEURL ?>relatorio/relatoriovalorinvestimento.php"
                               class="delete-row" data-toggle="tooltip" title="Emitir Relatório">Investimento
                                Melhoria / Projeto</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</section>
<?php include(FOOTER_TEMPLATE); ?>

