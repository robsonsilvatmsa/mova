<?php

use League\Csv\Writer;
use League\Csv\Reader;

require_once("../../vendor/autoload.php");
require_once('../../config.php');
require_once('functions.php');

//Nome do pai do menu para identificar
$_SESSION['menu'] = "Administrador";

$lusuarios = find_query(" 
		SELECT U.*, 
			'SETOR' = (
				SELECT S.SETOR
				FROM
					 CENTRODECUSTO AS C,
					 SETORES_CENTRODECUSTO AS SC,
					 SETORES AS S
				WHERE U.CC = C.codigo AND
					  C.ID = SC.idcentrodecusto AND
					  SC.idsetor = S.id and
					  emp.id = s.idempresa
			  ), emp.Nome
		FROM USUARIOS AS U, empresas as emp
		where u.idempresa = emp.id
		");


$csv = Writer::createFromString('');
$csv->setDelimiter(';');
$csv->setOutputBOM(Reader::BOM_UTF8);
$csv->insertOne([
    "Empresa",
    "Matricula",
    "Nome",
    "Email",
    "Usuario",
    "Situacao Senior",
    "Centro de Custo"
]);
foreach ($lusuarios as $user) {
    if ($user["idempresa"] == 1) {
        $empresa = "TMSA";
    } else if ($user["idempresa"] == 2) {
        $empresa = "IMS";
    } else if ($user["idempresa"] == 3) {
        $empresa = "Bulktech";
    }
    $departamento = $user["cc"] . " - " . $user["cc_descricao"];

    $csv->insertOne([
        $empresa,
        $user["matricula"],
        $user["nome"],
        $user["email"],
        $user["login"],
        $user["situacaosenior"],
        $departamento
    ]);
}


$csv->output("usuarios.csv");
