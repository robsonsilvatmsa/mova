<?php
require_once('../config.php');
require_once("../vendor/autoload.php");
require_once(DBAPI);
abresessao();
$value = [];


$post = filter_input_array(INPUT_GET, FILTER_DEFAULT);



    $consulta = find_query("
select
((count(gr.idgrupo)*100) / (
   select
      count(id) 
   from
      usuarios 
   where
      usuarios.cc = usu.cc 
      and usuarios.situacaosenior <> '7-Demitido')) as 'Total',
      usu.cc_descricao 
   from
      usuariogrupo as gr,
      usuarios as usu 
   where
      usu.id = gr.idusuario 
      and usu.situacaosenior <> '7-Demitido' 
   group by
      usu.cc_descricao,
      usu.cc
   order by Total desc

    ");

    $i = 0;
    $a = 0;
    foreach ($consulta as $cons):
        $value += [
            "nome" . $a => $cons["cc_descricao"],
            "Valor" . $a => $cons["Total"],
            "rotulo" . $a => $cons["Total"],

        ];

        $a++;
    endforeach;
    $value += ["total" => $a];


    echo json_encode($value);
