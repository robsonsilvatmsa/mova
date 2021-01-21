<?php
define("MAIL",[
	"host" => "smtp.office365.com",
	"port"=>"587"
]);

define("DATA_LAYER_CONFIG", [
    "driver" => "sqlsrv",
    "host" => "sql003.tecno.local",
    "port" => "1433",
    "dbname" => "MOVA",
    "username" => "portal",
    "passwd" => "fkj#5htmsa2018",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);


