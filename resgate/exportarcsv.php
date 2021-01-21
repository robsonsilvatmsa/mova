<?php

require_once('../config.php');
require_once("../vendor/autoload.php");


use Source\controllers\ResgateMelhoria;

$resgate = new ResgateMelhoria();


$resgate->exportar();