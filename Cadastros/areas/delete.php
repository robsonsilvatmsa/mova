<?php
require_once('../../config.php');
require_once ('../../vendor/autoload.php');


use Source\controllers\Area;



$function = new Area();
abresessao();

if ($_GET['id']){
    $id = $_GET['id'];
    $function->deletearea($id);
    header("location: index.php");
}







