<?php
require_once('../../config.php');
require_once('functions.php');
abresessao();

//Nome do pai do menu para identificar
$_SESSION['menu'] = "Administrador";


	$setores = find_query("select setores.*, 
							totcc = (select count(id) 
											from setores_centrodecusto as scc 
											where setores.id = scc.idsetor),
							emp.nome as empresa
							from setores, empresas as emp
							where setores.idempresa = emp.id
							order by emp.nome, setores.setor");
	
?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>


<style>
.table-condensed {
font-size: 10px;
}
</style>

	
	<div id="content">
		
		
		<div id="content-header">
			<h1>Setores</h1>
		</div> <!-- #content-header -->	


		<div id="content-container">

			<div class="animated fadeIn">
			<div class="row">

				<div class="col-md-12">

					<div class="portlet">
					
						<div class="card-header">
							<!--<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addregistro"><i class="fa fa-plus-square"></i> Incluir</a></button>-->
							<!--<a href="add.php" class="btn btn-sm btn-primary"><i class="fa fa-plus-square"></i> Incluir</a>-->
							<a href="add.php" class="btn btn-sm btn-primary"><i class="fa fa-plus-square"></i> &nbsp;&nbsp;Novo Setor</a>
							<a class="btn btn-sm btn-tertiary" href="index.php"><i class="fa fa-refresh"></i>&nbsp;&nbsp;Atualizar</a>
						</div><br>
					

						<div class="portlet-header">

							<h3>
								<i class="fa fa-user"></i>
								Manutenção de Setores
							</h3>

						</div> <!-- /.portlet-header -->

						<div class="portlet-content">						



							<table 
								class="table table-striped table-bordered table-hover table-condensed table-highlight table-sm display"
								data-provide="datatable" 
								data-display-rows="20"
								data-paginate="true"
								data-info="true"
								data-search="true"
								data-length-change="true"
								
							>
									<thead>
										<tr>
											<th style="width: 20%">Empresa</th>
											<th style="width: 25%">Nome Setor</th>
											<th style="width: 10%">Ativo</th>
											<th style="width: 15%">Data Inc/Modif.</th>
											<th style="width: 13%">CC Relacionados</th>													
											<th style="width: 8%">Relacionar</th>
											<th style="width: 10%">Ações</th>											
										</tr>
									</thead>
									<tbody>
											<?php if ($setores) : ?>
											<?php foreach ($setores as $setor) : ?>


												<tr>
													<td><?php echo $setor['empresa']; ?></td>
													<td><?php echo $setor['setor']; ?></td>
													<td><?php echo ($setor['ativo']==1)? 'Sim' : 'Não'; ?></td>
													<td><?php echo $setor['modificado']; ?></td>
													<td><?php echo $setor['totcc']; ?></td>
													<td class="actions text-center">
														<?php If ($setor['ativo'] == 1) { ?>
														<div class="fa-hover col-lg-3 col-md-6">
																<a href="relacionar.php?id=<?php echo $setor['id']; ?>"><i class="fa fa-gears ui-tooltip howler" data-type="info" data-toggle="tooltip" data-placement="top" title="Relacionar"></i></a>
														</div>
														<?php } ?>
													</td>													
													<td class="actions text-left">
														<div class="fa-hover col-lg-3 col-md-6">
															<a href="edit.php?id=<?php echo $setor['id']; ?>"><i class="fa fa-edit ui-tooltip" data-toggle="tooltip" data-placement="top" title="Editar"></i></a>
														</div>
														
														<?php If ($setor['totcc'] == 0) { ?>
														<div class="fa-hover col-lg-3 col-md-6">
															<a href="delete.php?id=<?php echo $setor['id']; ?>"><i class="fa fa-trash ui-tooltip" data-toggle="tooltip" data-placement="top" title="Excluir"></i></a>
														</div>
														<?php } ?>
														<!--<div class="fa-hover col-lg-3 col-md-6">
															<a href="delete.php?id=<?php echo $setor['id']; ?>"><i class="fa fa-eye ui-tooltip" data-toggle="tooltip" data-placement="top" title="Visualizar"></i></a>
														</div>-->
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
							

						</div> <!-- /.portlet-content -->

					</div> <!-- /.portlet -->

				

				</div> <!-- /.col -->
			</div>
			</div> <!-- /.row -->
			
			
 

		</div> <!-- /#content-container -->		
		
	</div> <!-- #content -->
	
	
</div> <!-- #wrapper -->

<?php include(FOOTER_TEMPLATE); ?>