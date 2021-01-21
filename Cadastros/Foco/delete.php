<?php
require_once('../../config.php');
require_once ('../../vendor/autoload.php');


use Source\controllers\Foco;



$function = new Foco();
abresessao();

if ($_GET['id']){
    $id = $_GET['id'];
    $function->deletefoco($id);
    header("location: index.php");
}







