<?php
require_once('../../config.php');
require_once("../../vendor/autoload.php");

use Source\models\TableArea;

$area = new TableArea();
$id = $_GET['id'];
$areas = $area->find("id <> $id")->fetch(true);

if ($areas) {
    foreach ($areas as $item) {
        $abrangencia[] = array(
            'descicao' => $item->description_area,
            'id' => $item->id
        );

    }
}


echo json_encode($abrangencia);