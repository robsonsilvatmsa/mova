<?php

require_once('../../config.php');
require_once('functions.php');
require_once("../../vendor/autoload.php");


// alimenta matricula do colaborador
$matricula = isset($_GET['matricula']);


//busca dados do colaborador através da matricula
if ((isset($_GET['matricula']))) {

    $matricula = $_GET['matricula'];
    $matricula = str_pad($matricula, 4, "0", STR_PAD_LEFT);

    if (!empty($matricula)) {
        $consultaAX = find_query("SELECT top 1 * FROM USUARIOS "
            . "WHERE MATRICULA = '$matricula' "
            . "and situacaosenior <>'7-demitido' ");
    };

    if ($consultaAX) :
        foreach ($consultaAX as $caxs) :
            $iduser = $caxs['id'];
            $aDados = array('NOME' => $caxs['nome'],
                'ID' => $caxs['id'],
                'CC' => ($caxs['cc'] . ' - ' . $caxs['cc_descricao']));
        endforeach;
    endif;

    $consultagrupo = find_query("Select * from usuariogrupo where idusuario = $iduser");
    if (!empty($consultagrupo)) {
        $adicionado = true;
    } else {
        $adicionado = false;
    }
};

error_reporting(E_ALL);

//retorno json para preenchimento no front-end
if ($consultaAX) :
    foreach ($consultaAX as $caxs) :
        $aDados = array('NOME' => $caxs['nome'],
            'ID' => $caxs['id'],
            'CC' => ($caxs['cc'] . ' - ' . $caxs['cc_descricao']),
            'adicionado' => $adicionado
        );


    endforeach;
endif;

echo json_encode($aDados);
?>
