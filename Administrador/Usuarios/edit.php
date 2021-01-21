<?php
require_once('../../config.php');
require_once('functions.php');
abresessao();

//edit();

//consultas internas da pagina
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $dsSeguranca = find_query("SELECT * from SEGURANCA");

    $lusuarios = find_query(" 		
				SELECT U.*, 
			'SETOR' = (
				SELECT S.SETOR
				FROM
					 CENTRODECUSTO AS C,
					 SETORES_CENTRODECUSTO AS SC,
					 SETORES AS S
				WHERE U.CC = C.codigo AND
					  C.ID = SC.idcentrodecusto AND
					  SC.idsetor = S.id and
					  u.idempresa = c.idempresa
			  ), emp.Nome as empresa
		FROM USUARIOS AS U, empresas as emp
		where u.idempresa = emp.id and U.id = $id
		");


}

?>


<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

    <style>
        .table-condensed {
            font-size: 12px;
        }
    </style>

    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Editar Permissões</h2>
        </header>

        <section class="panel">


            <div id="content-container">
                <!-- Abre conexao com tabela de usuarios -->
                <?php if ($lusuarios) : ?>
                <?php foreach ($lusuarios

                as $user) : ?>

                <div class="row">

                    <div class="col-md-9">

                        <div class="row">

                            <div class="col-md-3 col-sm-6">

                                <div class="thumbnail">
                                    <?php echo foto($user['matricula']); ?>
                                </div> <!-- /.thumbnail -->
                                <br/>
                            </div> <!-- /.col -->

                            <div class="col-md-8 col-sm-7">

                                <h3><?php echo $user['nome']; ?></h3>

                                <hr/>

                                <ul class="icons-list">
                                    <li><i class="icon-li fa fa-building"></i> <b>Empresa:</b>
                                        <?php echo $user['empresa']; ?></li>
                                    <li><i class="icon-li fa fa-list-alt"></i> <b>Matrícula:</b>
                                        <?php echo $user['matricula']; ?></li>
                                    <li><i class="icon-li fa fa-user"></i> <b>Login
                                            Rede:</b> <?php echo $user['login']; ?>
                                    </li>
                                    <li><i class="icon-li fa fa-envelope"></i>
                                        <b>Email:</b> <?php echo $user['email']; ?>
                                    </li>
                                </ul>

                                <hr/>
                                <br/>

                                <div class="portlet-content">


                                    <table
                                            class="table table-striped table-bordered table-hover table-condensed table-highlight table-sm display"
                                            data-provide="datatable1" data-display-rows="20" data-paginate="true"
                                            data-info="true" data-search="true" data-length-change="true">
                                        <thead>
                                        <tr>
                                            <th style="width:  40%">Permissão</th>
                                            <th style="width:  40%">Situação</th>
                                            <th style="width:  20%">Ação</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if ($dsSeguranca) : ?>
                                            <?php foreach ($dsSeguranca as $Seg) : ?>

                                                <tr>
                                                    <td><?php echo $Seg['nome']; ?></td>
                                                    <td>
                                                        <?php
                                                        if (buscaPermissoes($id, $Seg['id'], true) == 1) {
                                                            $StatusAcesso = true;
                                                        } else {
                                                            $StatusAcesso = false;
                                                        }
                                                        ?>
                                                        <?php if ($StatusAcesso) { ?> <span
                                                                class="label label-success">Liberado</span> <?php } ?>
                                                    </td>

                                                    <td class="actions text-right">
                                                        <div class="fa-hover col-lg-3 col-md-6">
                                                            <a
                                                                    href="AtivaPermissao.php?idSeg=<?php echo $Seg['id']; ?>&idUser=<?php echo $id; ?>&tipo=1">
                                                                <?php if (buscaPermissoes($id, $Seg['id'], true) == 0) { ?>
                                                                    <i class="fa fa-check-square-o ui-tooltip"
                                                                       data-toggle="tooltip"
                                                                       data-placement="top" title="Liberar"></i>
                                                                <?php } ?>
                                                            </a>
                                                        </div>
                                                        <div class="fa-hover col-lg-3 col-md-6">
                                                            <a
                                                                    href="AtivaPermissao.php?idSeg=<?php echo $Seg['id']; ?>&idUser=<?php echo $id; ?>&tipo=0">
                                                                <?php if (buscaPermissoes($id, $Seg['id'], true) == 1) { ?>
                                                                    <i class="fa fa-ban  ui-tooltip"
                                                                       data-toggle="tooltip"
                                                                       data-placement="top" title="Bloquear"></i>
                                                                <?php } ?>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="6">Nenhum registro encontrado.</td>
                                            </tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>


                                    <a href="<?= BASEURL ?>Administrador/Usuarios" class="btn btn-danger">Voltar</a>
                                </div> <!-- /.portlet-content -->

                                <hr/>

                                <br/>


                            </div>

                        </div>

                    </div>
                    <div class="col-md-3 col-sm-6 col-sidebar-right">

                        <h4>Informações</h4>
                        <div class="list-group">

                            <a href="javascript:;" class="list-group-item">
                                <h3 class="pull-right"><i class="fa fa-building-o"></i></h3>
                                <p class="list-group-item-text">Setor</p>
                                <h4 class="list-group-item-heading"><?php echo $user['SETOR']; ?></h4>
                            </a>
                            <a href="javascript:;" class="list-group-item">
                                <h3 class="pull-right"><i class="fa fa-list-alt"></i></h3>
                                <p class="list-group-item-text">Centro de Custo</p>
                                <h4 class="list-group-item-heading">
                                    <?php echo $user['cc']; ?>-<?php echo $user['cc_descricao']; ?></h4>
                            </a>
                            <a href="javascript:;" class="list-group-item">
                                <h3 class="pull-right"><i class="fa fa-group"></i></h3>
                                <p class="list-group-item-text">Situação Sênior</p>
                                <h4 class="list-group-item-heading"><?php echo $user['situacaosenior']; ?></h4>
                            </a>
                        </div> <!-- /.list-group -->

                        <br/>
                    </div>

                    <?php endforeach; ?>
                    <?php endif; ?>
                    <!-- fecha foreach com tabela de usuarios -->

                </div> <!-- /.row -->


            </div> <!-- /#content-container -->


        </section>
    </section>

    <div id="content">


    </div> <!-- #content -->


    </div> <!-- #wrapper -->

<?php include(FOOTER_TEMPLATE); ?>