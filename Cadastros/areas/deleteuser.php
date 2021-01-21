<?php
require_once('../../config.php');
require_once("../../vendor/autoload.php");

use Source\controllers\Area;

$function = new Area();


abresessao();

if ($_GET['id']) {
    $id = $_GET['id'];
    $idarea = $_GET['idarea'];
    $function->deleteusuario($id);
    header("location: edit.php?id=$idarea");


}







