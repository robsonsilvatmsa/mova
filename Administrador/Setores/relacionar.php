<?php
require_once('../../config.php');
require_once('functions.php'); 
abresessao();
  
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	
		$setores = find_query("select setores.*, emp.nome as empresa from setores, empresas as emp where setores.id = $id and setores.idempresa = emp.id");
		$centrosdecusto = find_query("SELECT cc.* 
										FROM centrodecusto as cc, setores
										WHERE cc.id NOT IN (SELECT idcentrodecusto FROM setores_centrodecusto ) and
												cc.idempresa = setores.idempresa and
												setores.id = $id 
										order by cc.descricao");

		$relacionados = find_query("select cc.* from setores_centrodecusto as rel, centrodecusto as cc where rel.idcentrodecusto = cc.id and rel.idsetor = $id order by cc.descricao");
	
	}
?>

<?php include(ESTILO_TEMPLATE); ?>
<link rel="stylesheet" type="text/css" href="multi.min.css">
<script src="multi.min.js"></script>

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
				<div class="col-md-12">
					<?php foreach ($setores as $setor) : ?>
						<h3>Empresa:&nbsp;<?php echo $setor['empresa']; ?>&nbsp;&nbsp;-&nbsp;&nbsp;Setor:&nbsp;<?php echo $setor['setor']; ?> </h3>
					<?php endforeach; ?>
					<hr />
					<br />
					
					<div class="portlet">
			
						<div class="portlet-header">

							<h3>
								<i class="fa fa-hand-o-up"></i>
								Relacionar centro de custo com setor
							</h3>

						</div> <!-- /.portlet-header -->

						<div class="portlet-content">						
								<div class="col-sm-12">
									<div class="card">
										<div class="card-body card-block">

												
												<form method="post" name="frmfrutas" action="add_relacionar.php?id=<?php echo $id; ?>" id="frmfrutas">
													<div class="container">
																<select multiple="multiple" name="opcoes[]" id="fruit_select">
																	
																	<?php foreach ($relacionados as $relac) : ?>
																		<option selected="selected"><?php echo $relac['id'].' | '.$relac['codigo'].' - '.$relac['descricao']; ?></option>
																	<?php endforeach; ?>
																	
																	<?php foreach ($centrosdecusto as $cc) : ?>
																		<option><?php echo $cc['id'].' | '.$cc['codigo'].' - '.$cc['descricao']; ?></option>
																	<?php endforeach; ?>
																</select>
													</div><br><hr>
													<div class="card-footer">
														<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-dot-circle-o"></i> Gravar</button>
														<a href="index.php" class="btn btn-primary btn-sm">Cancelar</a>
													</div>
												</form>												
												

												<!--<div class="form-group">
													<hr>
													<button type="submit" class="btn btn-primary btn-sm">Gravar</button>
													&nbsp;<a href="index.php" class="btn btn-default btn-sm">Cancelar</a>
												</div>-->
												
										</div>
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


<script>
	var select = document.getElementById('fruit_select');
	multi( select );
</script>


<?php include(FOOTER_TEMPLATE); ?>