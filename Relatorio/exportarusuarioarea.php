<?php
require_once('../config.php');
require_once("../vendor/autoload.php");
require_once(DBAPI);
abresessao();

use Source\controllers\ExportarUsuarioArea;


$export = new ExportarUsuarioArea();

$export->exportar();


