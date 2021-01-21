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
(SUM(Melhoria.ValorInvestimento))  AS Valor
FROM Melhoria
WHERE  Melhoria.DataEncerramento  between '$to' and  '$end'
order by Valor desc
    ");

    $i = 0;
    $a = 0;
    foreach ($consulta as $cons):
        $value += [
            "nome" . $a => "Valor Investimento Melhoria",
            "Valor" . $a => $cons["Valor"],
            "rotulo" . $a => number_format($cons["Valor"], "2", ",", "."),

        ];

        $a++;
    endforeach;
    $value += ["total" => $a];


    echo json_encode($value);
}

