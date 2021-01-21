<?php

require_once('../../config.php');
require_once("../../vendor/autoload.php");

use Source\controllers\AprovadoresMelhoria;

$aprovadores = new AprovadoresMelhoria();

$id = $_GET['id'];
$idmel = $_GET['melhoria'];

$aprovadores->delete($id);

header("location: edit.php?id=$idmel");