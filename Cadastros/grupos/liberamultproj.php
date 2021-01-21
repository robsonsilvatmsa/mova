<?php
require_once('../../config.php');
require_once("functions.php");
require_once("../../vendor/autoload.php");


use Cadastros\grupos\functions;


$function = new functions();
abresessao();

if ($_GET['id']) {
    $id = $_GET['id'];
    $mult = $_GET['multi'];
    $function->liberamulti($id, $mult);

    header("location: index.php");
}

