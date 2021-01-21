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
 (SUM(Melhoria.ValorInvestimento))
  AS Valor,
  Grupo.name_group as nome,
  Melhoria.idGrupo
FROM Melhoria,
     Grupo
WHERE Melhoria.idGrupo = Grupo.id and Melhoria.DataEncerramento  between '$to' and  '$end'
GROUP BY Grupo.name_group,
         Melhoria.idGrupo
    order by Valor desc
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