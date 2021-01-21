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
 (SUM(Project.ValorProjeto))
  AS Valor,
  Grupo.name_group as nome,
  Project.idGrupo
FROM Project,
     Grupo
WHERE Project.idGrupo = Grupo.id and Project.data_resgate  between '$to' and  '$end'
GROUP BY Grupo.name_group,
         Project.idGrupo
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