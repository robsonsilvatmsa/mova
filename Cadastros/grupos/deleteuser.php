<?php
require_once('../../config.php');
require_once("functions.php");
require_once("../../vendor/autoload.php");


use Cadastros\grupos\functions;


$function = new functions();
abresessao();

if ($_GET['id']) {
    $id = $_GET['id'];
    $idgrupo = $_GET['idgrupo'];
    $function->deleteusuario($id);
    header("location: edit.php?id=$idgrupo");
}







