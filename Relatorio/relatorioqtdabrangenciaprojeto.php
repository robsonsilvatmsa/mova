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

select count(AbrangenciaProjeto.idprojeto) as Valor, Area.description_area 
from AbrangenciaProjeto, Project,Area 
where AbrangenciaProjeto.idprojeto = Project.id and Project.Status >= 5 and Project.DataInicio between '$to' and  '$end'
  and AbrangenciaProjeto.idarea = Area.id 
group by Area.description_area order by Valor desc
    ");

    $i = 0;
    $a = 0;
    foreach ($consulta as $cons):
        $value += [
            "nome" . $a => $cons["description_area"],
            "Valor" . $a => $cons["Valor"],
            "rotulo" . $a => number_format($cons["Valor"], "2", ",", "."),

        ];

        $a++;
    endforeach;
    $value += ["total" => $a];


    echo json_encode($value);
}