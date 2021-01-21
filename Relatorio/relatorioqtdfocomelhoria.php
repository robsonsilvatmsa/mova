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
select COUNT(Melhoria.IdFoco) as Valor,Foco.focus_description 
from Melhoria,Foco 
where Foco.id = Melhoria.IdFoco and Melhoria.status >=5 and Melhoria.DataInicio between '$to' and  '$end'
group by Foco.focus_description order by Valor desc

");

    $i = 0;
    $a = 0;
    foreach ($consulta as $cons):
        $value += [
            "nome" . $a => $cons["focus_description"],
            "Valor" . $a => $cons["Valor"],
            "rotulo" . $a => number_format($cons["Valor"], "2", ",", "."),

        ];

        $a++;
    endforeach;
    $value += ["total" => $a];


    echo json_encode($value);
}