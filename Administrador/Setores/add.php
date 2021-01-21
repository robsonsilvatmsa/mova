<?php
require_once('../../config.php');
require_once('functions.php');
abresessao();
add();
?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<style>
.table-condensed {
font-size: 12px;
}
</style>

	
	<div id="content">
		
		<div id="content-header">
			<h1>Setores</h1>
		</div> <!-- #content-header -->	

		<div id="content-container">
			<div class="animated fadeIn">
			<div class="row">
				<div class="col-md-6">
					<div class="portlet">
			
						<div class="portlet-header">

							<h3>
								<i class="fa fa-hand-o-up"></i>
								Cadastro de Setores
							</h3>

						</div> <!-- /.portlet-header -->

						<div class="portlet-content">						
								<div class="col-sm-12">
									<div class="card">
										<div class="card-body card-block">
											<form class="form-horizontal" action="add.php" method="post">

												<div class="form-group">	
													<label for="select-input">Empresa</label>
													<select name="selemp" id="select-input" class="form-control">
														<option value="1">TMSA</option>
														<option value="2">IMS</option>
														<option value="3">BULKTECH</option>
													</select>
												</div>	

												<div class="form-group">
													<label for="name">Nome do Setor</label>
													<input type="text" name="setor['setor']" value="" class="form-control" data-required="true" >
												</div>

												<div class="form-group">
													<label>Ativar ?</label>
													<div class="checkbox">
														<label>
															<input type="checkbox" name="ativar" value="" class="form-check-input">
															Sim
														</label>
													</div>
												</div> <!-- /.form-group -->

												<div class="form-group">
													<hr>
													<button type="submit" class="btn btn-primary btn-sm">Gravar</button>
													&nbsp;<a href="index.php" class="btn btn-default btn-sm">Cancelar</a>
												</div>
												
											</form>
									</div>
								</div>
				
						</div> <!-- /.portlet-content -->
										
					</div> <!-- /.portlet -->
				</div> <!-- /.col -->
			</div>
			</div> <!-- /.row -->
		</div> <!-- /#content-container -->		
	</div> <!-- #content -->
	
</div> <!-- #wrapper -->

<?php include(FOOTER_TEMPLATE); ?>