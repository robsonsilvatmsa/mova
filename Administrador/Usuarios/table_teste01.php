<?php
require_once('../../config.php');
require_once('functions.php');
abresessao();
    index();
?>


<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/plug-ins/preview/searchPane/dataTables.searchPane.min.css">

		<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/plug-ins/preview/searchPane/dataTables.searchPane.min.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready( function () {
				$('#example').DataTable( {
					searchPane: true,
					stateSave: true
				} );
			} );
		</script>
	</head>
	<body>
		<div class="container">
			<table id="example" class="display nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th style="width:   5%">Empresa</th>
						<th style="width:   7%">Matricula</th>
						<th style="width:  23%">Nome</th>
						<th style="width:  10%">CPF</th>											
						<th style="width:  36%">Departamento</th>
						<th style="width:  12%">Pendências</th>
						<th style="width:   7%">Opções</th>
					</tr>
				</thead>

				<tbody>
					<?php if ($usuarios) : ?>
					<?php foreach ($z as $user) : ?>


						<tr>
							<td><?php echo $user['idempresa']; ?></td>
							<td><?php echo $user['matricula']; ?></td>
							<td><?php echo $user['nome']; ?></td>
							<td><?php echo $user['cpf']; ?></td>
							<td><?php echo $user['cc_descricao']; ?></td>
							<td>
								<?php If ($user['login'] == '') { ?>
									<span class="label label-secondary">Login Rede</span>
								<?php } ?>
								<?php If ($user['email'] == '') { ?>
									<span class="label label-secondary">E-mail</span>
								<?php } ?>											
							</td>
							<td class="actions text-right">
								<div class="fa-hover col-lg-3 col-md-6">
									<a href="edit.php?id=<?php echo $user['id']; ?>"><i class="fa fa-edit ui-tooltip" data-toggle="tooltip" data-placement="top" title="Editar"></i></a>
								</div>
								<div class="fa-hover col-lg-3 col-md-6">
									<a href="delete.php?id=<?php echo $user['id']; ?>"><i class="fa fa-eye ui-tooltip" data-toggle="tooltip" data-placement="top" title="Visualizar"></i></a>
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
			
		</div>
	</body>
</html>