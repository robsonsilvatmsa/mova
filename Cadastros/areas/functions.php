<?php

namespace Cadastros\areas;

require_once('../../config.php');
require_once(DBAPI);

/**
 * class functions
 * para declarar as funções a
 * serem utilizadas para cadastrar um usuário
 * @author robson.silva
 */
class functions
{

    private $now;

    public function __construct()
    {

    }

    public function index()
    {

    }

    public function grupos()
    {
        $consulta = find_all("grupos");
        return $consulta;
    }

    public function count($id)
    {
        $count = find_query("select * from grupos where id = $id");
        return $count;
    }
}
