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
      WHERE usuariogrupo.idgrupo = Project.idGrupo)) >= 3 then 
      (SUM(Project.ValorProjeto) / (SELECT COUNT(ID)
      FROM usuariogrupo WHERE usuariogrupo.idgrupo = Project.idGrupo
      ))
      else (SUM(Project.ValorProjeto)/3)
      END AS Valor,
      usuarios.nome,
      Project.idGrupo
    FROM Project,
         usuarios,
         usuariogrupo,
         Grupo
    WHERE Project.idGrupo = usuariogrupo.idgrupo
    AND usuarios.id = usuariogrupo.idusuario
    AND Grupo.id = Project.idGrupo
    AND Grupo.id = usuariogrupo.idgrupo
    AND Project.data_resgate  between '$to' and  '$end'
    GROUP BY usuarios.nome,
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