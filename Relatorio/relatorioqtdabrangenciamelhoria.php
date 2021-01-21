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
select count(AbrangenciaMelhoria.idmelhoria) as Valor, Area.description_area 
from AbrangenciaMelhoria, Melhoria,Area 
where AbrangenciaMelhoria.idmelhoria = Melhoria.id and Melhoria.status >= 5 and Melhoria.DataInicio between '$to' and  '$end'
and AbrangenciaMelhoria.idarea = Area.id 
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