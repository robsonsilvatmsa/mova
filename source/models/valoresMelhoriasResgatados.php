<?php
header('Access-Control-Allow-Origin: *');
$matricula = $_GET['matricula'];

$connection = new PDO("sqlsrv:Database=MOVADEV;server=sql003.tecno.local", "portal", "fkj#5htmsa2018");

$statement = $connection->prepare('
select distinct u.*, m.*, ug.*
from Melhoria as m, usuarios as u, Grupo as gp, usuariogrupo as ug
inner join usuarios on usuarios.id = ug.idusuario
inner join Melhoria on Melhoria.IdGrupo = ug.idgrupo
inner join Grupo on grupo.id = Melhoria.IdGrupo
    WHERE m.status = 5 and m.resgatado = 1 and u.id = ug.idusuario and u.matricula ='.$matricula );

$statement->execute();
$melhoria = $statement->fetchAll();



echo json_encode();

return;