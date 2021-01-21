<?php
require_once("../../vendor/autoload.php");
require_once("functions.php");


use Cadastros\aprovadoresmelhoria\functions;
use Source\models\ImprovementAnalyzer;
use Source\models\TableArea;

$area = (new TableArea())->find()->fetch(true);
$areas = new TableArea();
$functions = new functions();
$aprovadores = new ImprovementAnalyzer();
$id = $_GET['id'];

$aprovador = $aprovadores->find("idmelhoria = $id")->fetch(true);

foreach ($aprovador as $col):


    echo "<tr style='heigth'>" .
        "<td><select name='respon[]' class= 'form-control' required>";

    $are = $areas->findById($col->idarea);
    $desc = '';
    if ($are)
        $desc = $are->description_area;

    echo "<option value=' $col->idarea '> $desc </option>";

    foreach ($area as $item) {
        echo "<option value=' $item->id '>$item->description_area</option>";
    }

    echo "</select></td>" .
        "<td class='center'>" .
        " <input id='seq$col->sequencia' class='form-control' name='seq[]' type='hidden' readonly='' value='" . $col->sequencia . "'><b>" . $col->sequencia .
        "°</b></td>
        <td class='center'><input type='hidden' name='id[]' value='$col->id'>
        <input id='seq' type='hidden' value='$col->sequencia'>
        <a href='delete.php?id=$col->id&melhoria=$id' class='btn btn-danger center'>Deletar</a>
        </td>
        </tr>";
endforeach;