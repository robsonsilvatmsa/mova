<?php
   require_once('functions.php');
   ini_set('max_execution_time', 0);

$database = open_database();
$listagem = null;
$reguser = null;

			//$sql = "SELECT [samAccountName] as loginrede, [ATIVO] as situacaorede FROM [master].[dbo].[AdView] WHERE [ATIVO] = 'ATIVO'";
			
			
			$sql = "SELECT emp.id as idempresa, 
							fun.nomfun as nome, 
							(cc.codccu) as cc,
							(cc.nomccu) as cc_descricao,
							dbo.lpad(fun.numcad,4,'0') as matricula, 
							(CONVERT(VARCHAR, sit.codsit)+'-'+sit.dessit) as situacaosenior,
							ad.samAccountName as login,
							ad.mail as email,
							fun.numcpf as cpf
					FROM [tm-seniordb01].senior_prod.dbo.R034FUN as fun left join master.dbo.adview as ad on convert(varchar,fun.numcpf) = ad.employeeID,
							[tm-seniordb01].senior_prod.dbo.R030EMP as empresa,
							[tm-seniordb01].senior_prod.dbo.r018ccu as cc,
							[tm-seniordb01].senior_prod.dbo.r010sit as sit, 
							[tm-seniordb01].senior_prod.dbo.r034cpl as fcomp,
							empresas as emp
					WHERE 	fun.numemp = empresa.numemp and
							fun.codccu = cc.codccu and
							fun.numemp = cc.numemp and
							fun.sitafa = sit.codsit and 
							fun.numemp = fcomp.numemp and
							fun.numcad = fcomp.numcad and
							empresa.apeemp = emp.Nome
					order by fun.nomfun";
							
			//echo $sql;
			
			$result = $database->prepare($sql);
			$result->setFetchMode(PDO::FETCH_ASSOC);
			$result->execute();
			
			echo $result->rowCount();
			
			while ($lista = $result->fetch())
			{
				$reguser = (buscaLogin($lista['matricula']));
				
				If ($reguser == 0)
				{
					//insert
					save("usuarios", $lista);					
				} 
				
				//update
				update("usuarios", $reguser, $lista);
				
			}
			
			
			//insere centro de custos na tabela
			$sql = "SELECT  emp.id as idempresa,
							(cc.codccu) as codigo,
							(cc.nomccu) as descricao
					FROM [tm-seniordb01].senior_prod.dbo.R034FUN as fun,
							[tm-seniordb01].senior_prod.dbo.R030EMP as empresa,
							[tm-seniordb01].senior_prod.dbo.r018ccu as cc,
							[tm-seniordb01].senior_prod.dbo.r010sit as sit, 
							[tm-seniordb01].senior_prod.dbo.r034cpl as fcomp,
							empresas as emp
												
					WHERE 	fun.numemp = empresa.numemp and
							fun.codccu = cc.codccu and
							fun.numemp = cc.numemp and
							fun.sitafa = sit.codsit and 
							sit.codsit = 1 and cc.codccu <> '41.4110' and
							fun.numemp = fcomp.numemp and
							fun.numcad = fcomp.numcad and
							empresa.apeemp = emp.Nome
					group by emp.id,
							 cc.codccu,
							 cc.nomccu";
							
			//echo $sql;
			
			$result = $database->prepare($sql);
			$result->setFetchMode(PDO::FETCH_ASSOC);
			$result->execute();
			
			//echo $result->rowCount();
			
			while ($lista = $result->fetch())
			{
				$reguser = (buscaCC($lista['codigo'],$lista['idempresa']));
				
				If ($reguser == 0)
				{
					//insert
					save("centrodecusto", $lista);					
				} 
				
				//update
				update("centrodecusto", $reguser, $lista);
				
			}			
			
			
			
function insereRegistro($umatricula) {
	$database = open_database();
	$found = null;
	$sql = "SELECT count(loginrede) as total from usuarios where matricula = '" . $umatricula . "'";
	$regs = current($database->query($sql)->fetch());	
	close_database($database);
	if ($regs > 0) { return true; } else { return false; };
}


function buscaLogin( $umatricula ) {
	$database = open_database();
	$found = null;
	$sql = "SELECT id from usuarios where matricula = '" . $umatricula . "'";
	$regs = current($database->query($sql)->fetch());	
	close_database($database);
	if ($regs > 0) { return $regs; } else { return 0; };
}

function buscaCC( $codigo, $uempresa ) {
	$database = open_database();
	$found = null;
	$sql = "SELECT id from centrodecusto where codigo = '" . $codigo . "' and idempresa = '" . $uempresa . "'";
	$regs = current($database->query($sql)->fetch());	
	close_database($database);
	if ($regs > 0) { return $regs; } else { return 0; };
}

	close_database($database);
?>