<?php
/**
 * Arquivo Consulta para montagem relatório foco projeto.
 */
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
select count(Project.idGrupo) as Valor , Grupo.name_group 
from Project , Grupo where Grupo.id = Project.idGrupo and Project.Status >= 5 and Project.DataInicio between '$to' and  '$end'
group by name_group order by Valor desc 
    ");
    
    $a = 0;
    foreach ($consulta as $cons):
        $value += [
            "nome" . $a => $cons["name_group"],
            "Valor" . $a => $cons["Valor"],
            "rotulo" . $a => number_format($cons["Valor"], "2", ",", "."),

        ];

        $a++;
    endforeach;
    $value += ["total" => $a];


    echo json_encode($value);
}