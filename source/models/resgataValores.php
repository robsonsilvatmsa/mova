<?php
header('Access-Control-Allow-Origin: *');
$idgrupo = $_GET['idgrupo'];

$connection = new PDO("sqlsrv:Database=MOVADEV;server=sql003.tecno.local", "portal", "fkj#5htmsa2018");

$statement = $connection->prepare('select * from usuariogrupo where idgrupo = :idgrupo');
$statement->bindParam(':idgrupo',$idgrupo);
$statement->execute();
$qtdeGrupo = $statement->fetchAll();

$statement = $connection->prepare('SELECT m.* FROM Melhoria as m WHERE '.$idgrupo.' = 4 and status = 5 and resgatado < 1 or '.$idgrupo.' =  4 and status = 5 and resgatado is null');
$statement->execute();
$melhoria =$statement->fetchAll();

$statement = $connection->prepare('SELECT p.* FROM Project as p WHERE IdGrupo =  '.$idgrupo.' and status = 5 and resgatado < 1 or IdGrupo =   '.$idgrupo.' and status = 5 and resgatado is null or IdGrupo =  '.$idgrupo.' and status = 6 and resgatado < 1 or IdGrupo =   '.$idgrupo.' and status = 6 and resgatado is null');
$statement->execute();
$projeto = $statement->fetchAll();

echo json_encode(['melhoria'=>$melhoria, 'projeto'=>$projeto, 'qtdeGrupo'=>$qtdeGrupo]);

return;