<?php
require_once('../config.php');
require_once("../vendor/autoload.php");
require_once(DBAPI);
abresessao();

$value = [];


$post = filter_input_array(INPUT_GET, FILTER_DEFAULT);


$to = $post["to"];
$end = $post["end"];


if ($to) {

    $consulta = find_query("
	
	SELECT
case 
when ((SELECT
    COUNT(ID)
  FROM usuariogrupo
  WHERE usuariogrupo.idgrupo = Melhoria.idGrupo)) >= 3 then 
  (SUM(Melhoria.ValorMelhoria) / (SELECT COUNT(ID)
  FROM usuariogrupo WHERE usuariogrupo.idgrupo = Melhoria.idGrupo
  ))
  else (SUM(Melhoria.ValorMelhoria)/3)
  END AS Valor,
  usuarios.nome,
  Melhoria.idGrupo
FROM Melhoria,
     usuarios,
     usuariogrupo,
     Grupo
WHERE Melhoria.idGrupo = usuariogrupo.idgrupo
AND usuarios.id = usuariogrupo.idusuario
AND Grupo.id = Melhoria.idGrupo
AND Grupo.id = usuariogrupo.idgrupo
AND Melhoria.data_resgate  between '$to' and  '$end'
GROUP BY usuarios.nome,
         Melhoria.idGrupo


    ");

    $i = 0;
    $a = 0;
    foreach ($consulta as $cons):
        $value += [
            "nome" . $a => $cons["nome"],
            "Valor" . $a => $cons["Valor"],
            "rotulo" . $a => number_format($cons["Valor"], "2", ",", "."),

        ];

        $a++;
    endforeach;
    $value += ["total" => $a];


    echo json_encode($value);


}