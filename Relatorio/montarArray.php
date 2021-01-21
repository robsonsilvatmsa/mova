<?php
require_once('../config.php');
require_once("../vendor/autoload.php");
require_once(DBAPI);
abresessao();
$value = [];

$consulta = find_query("
SELECT
 (SUM(Melhoria.ValorMelhoria))
  AS Valor,
  Grupo.name_group as nome,
  Melhoria.idGrupo
FROM Melhoria,
     Grupo
WHERE Melhoria.idGrupo = Grupo.id
GROUP BY Grupo.name_group,
         Melhoria.idGrupo
    order by Valor desc
    ");

if ($consulta):


    $value = [
        "nome" => $consulta,
    ];


endif;

echo json_encode($value);