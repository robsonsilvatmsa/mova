<?php

require_once('../../config.php');
require_once("../../vendor/autoload.php");

use Source\controllers\AprovadoresProjeto;

$aprovadores = new AprovadoresProjeto();

$id = $_GET['id'];
$idproj = $_GET['projeto'];

$aprovadores->delete($id);

header("location: edit.php?id=$idproj");