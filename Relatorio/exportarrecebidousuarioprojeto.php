<?php
require_once('../config.php');
require_once("../vendor/autoload.php");
require_once(DBAPI);
abresessao();

use Source\controllers\ExportarValorUsuarioProjeto;

$value = [];

$export = new ExportarValorUsuarioProjeto();

$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$to = $post["start"];
$end = $post["end"];


if ($to) {
    $export->exportar($to, $end);

} else {
    header("location: relatoriovalorrecebido.php");
}