<?php

/**
 *    Funcoes de Banco de Dados
 *
 * @version 0.0.1
 */

/**
 *    Executa a conexao com o DB
 */
function open_database()
{

    try {
        $serverName = DB_HOST;
        $database = DB_NAME;
        $username = DB_USER;
        $pw = DB_PASSWORD;

        //Establishes the connection
        //$conn = sqlsrv_connect($serverName, $connectionOptions);
        $conn = new PDO("sqlsrv:server=$serverName ; Database=$database", "$username", "$pw");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {

        echo $e->getMessage();
        return null;
    }
}

function open_database_senior()
{

    try {
        $serverName = DB_HOST_SENIOR;
        $database = DB_NAME_SENIOR;
        $username = DB_USER_SENIOR;
        $pw = DB_PASSWORD_SENIOR;

        //Establishes the connection
        //$conn = sqlsrv_connect($serverName, $connectionOptions);
        $conn = new PDO("sqlsrv:server=$serverName ; Database=$database", "$username", "$pw");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {

        echo $e->getMessage();
        return null;
    }
}

/**
 *    Fecha a conexao com o DB
 */
function close_database($conn)
{

    try {

        $conn = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

/**
 *  Pesquisa um Registro pelo ID em uma Tabela
 */
function find($table = null, $id = null)
{

    $database = open_database();
    $found = null;

    try {
        if ($id) {
            $sql = "SELECT * FROM " . $table . " WHERE id = " . $id;

            $result = $database->query($sql);

            $TotReg = countAll($table, $id);

            if ($TotReg > 0) {
                $found = current($database->query($sql)->fetchAll());
            }
        } else {

            $sql = "SELECT * FROM " . $table;
            //$result= sqlsrv_query($database, $sql, NULL, array('Scrollable'=>'static'));

            $result = $database->query($sql);


            if ($result) {
                $found = $result->fetchAll();
                //$found = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            }
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }


    close_database($database);
    return $found;
}

/**
 *  Pesquisa um Registro pelo ID em uma Tabela
 */
function find_senior($query = null)
{

    $database = open_database_senior();
    $found = null;

    try {

        $sql = $query;
        $result = $database->query($sql);


        if ($result) {
            $found = $result->fetchAll();
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }


    close_database($database);
    return $found;
}

/**
 *  Pesquisa um Registro pelo ID em uma Tabela
 */
function find_query($query = null)
{

    $database = open_database();
    $found = null;

    try {

        $sql = $query;
        $result = $database->query($sql);


        if ($result) {
            $found = $result->fetchAll();
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }


    close_database($database);
    return $found;
}

/**
 * Start Sessao
 */
function criasessao($login, $nome, $conectado, $url, $cpf)
{

    if ($conectado) {
        if (session_status() != PHP_SESSION_ACTIVE) {
            ob_start();
            session_start();
            session_cache_expire(60);
            $_SESSION['conectado'] = true;
            $_SESSION['menu'] = "-";

            if ($login == '' && !empty($cpf)) {
                $matusers = find_query("select * from usuarios where cpf ='" . $cpf . "'");
                foreach ($matusers as $matuser) :
                    $_SESSION['matricula'] = $matuser['matricula'];
                    $_SESSION['nome'] = $matuser['nome'];
                    $_SESSION['login'] = $matuser['login'];
                    $_SESSION['iduser'] = $matuser['id'];
                    break;
                endforeach;

            } else {

                $matusers = find_query("select * from usuarios where login ='" . $login . "'");
                foreach ($matusers as $matuser) :
                    $_SESSION['matricula'] = $matuser['matricula'];
                    $_SESSION['nome'] = $matuser['nome'];
                    $_SESSION['login'] = $matuser['login'];
                    $_SESSION['iduser'] = $matuser['id'];
                    break;
                endforeach;
            }
            if (!empty($url)) {
                header('Location: ' . $url);
            } else {
                header('Location: ' . BASEURL . 'index.php');
            }
        }
    }
}

/**
 * Ajusta Menu com item ATIVO
 */
function selecionamenu($selecao)
{
    $segments = explode('/', $selecao);
    $_SESSION['SELMENU'] = $segments[1];
}

/**
 * Start Sessao
 */
function abresessao()
{

    session_start();
    ob_start();
    if (!$_SESSION['conectado']) {
        header('Location: ' . BASEURL . 'login.php');
    }
}

/**
 * Close Sessao
 */
function excluisessao()
{

    if (isset($_SESSION['conectado'])) {
        session_unset();
        session_destroy();
        header('Location: ' . BASEURL . 'index.php');
    }
}

/**
 *  Pesquisa Todos os Registros de uma Tabela
 */
function find_all($table)
{
    return find($table);
}

/**
 *  Insere um registro no BD
 */
function save($table = null, $data = null)
{

    $database = open_database();

    $columns = null;
    $values = null;

    print_r($data);

    foreach ($data as $key => $value) {
        $columns .= trim($key, "'") . ",";
        $values .= "'$value',";
    }

    // remove a ultima virgula
    $columns = rtrim($columns, ',');
    $values = rtrim($values, ',');

    $sql = "INSERT INTO " . $table . "($columns)" . " VALUES " . "($values);";
    echo $sql;

    try {
        $database->query($sql);
        //sqlsrv_query($database, $sql);


        $_SESSION['message'] = 'Registro cadastrado com sucesso.';
        $_SESSION['type'] = 'success';
    } catch (PDOException $e) {

        $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
        $_SESSION['type'] = 'danger';
    }

    close_database($database);
}

/**
 *  Atualiza um registro em uma tabela, por ID
 */
function update($table = null, $id = 0, $data = null)
{

    $database = open_database();

    $items = null;

    foreach ($data as $key => $value) {
        $items .= trim($key, "'") . "='$value',";
    }

    // remove a ultima virgula
    $items = rtrim($items, ',');

    $sql = "UPDATE " . $table;
    $sql .= " SET $items";
    $sql .= " WHERE id=" . $id . ";";

    try {
        $database->query($sql);

        $_SESSION['message'] = 'Registro atualizado com sucesso.';
        $_SESSION['type'] = 'success';
    } catch (PDOException $e) {

        $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
        $_SESSION['type'] = 'danger';
    }

    close_database($database);
}

function updatenoticia($table = null, $id = 0, $data = null)
{

    $database = open_database();

    $items = null;

    foreach ($data as $key => $value) {
        $items .= trim($key, "'") . "='$value',";
    }

    // remove a ultima virgula
    $items = rtrim($items, ',');

    $sql = "UPDATE " . $table;
    $sql .= " SET $items";
    $sql .= " WHERE N_Noticia =" . $id . ";";

    try {
        $database->query($sql);

        $_SESSION['message'] = 'Registro atualizado com sucesso.';
        $_SESSION['type'] = 'success';
    } catch (PDOException $e) {

        $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
        $_SESSION['type'] = 'danger';
    }

    close_database($database);
}

/**
 *  Remove uma linha de uma tabela pelo ID do registro
 */
function remove($table = null, $id = null)
{

    $database = open_database();

    try {
        if ($id) {

            $sql = "DELETE FROM " . $table . " WHERE id = " . $id;
            $result = $database->query($sql);
            //$result= sqlsrv_query($database, $sql);

            if ($result = $database->query($sql)) {
                //if ($result= sqlsrv_query($database, $sql)) {;
                $_SESSION['message'] = "Registro Removido com Sucesso.";
                $_SESSION['type'] = 'success';
            }
        }
    } catch (PDOException $e) {

        $_SESSION['message'] = $e->GetMessage();
        $_SESSION['type'] = 'danger';
    }

    close_database($database);
}

/* Lenoir Schneider */

/**
 *  Retorna a quantidade de registros
 */
function countAll($table, $id)
{
    $database = open_database();
    $sql = "select * from " . $table . " where id = " . $id;
    $regs = current($database->query($sql)->fetch());
    close_database($database);
    return $regs;
}

/**
 *  Conecta no AD
 */
function valida_ldap($srv, $usr, $pwd)
{

    $ldap_server = $srv;
    $auth_user = $usr;
    $auth_pass = $pwd;

    // Tenta se conectar com o servidor
    if (!($connect = @ldap_connect($ldap_server))) {
        return FALSE;
    }

    // Tenta autenticar no servidor
    if (!($bind = @ldap_bind($connect, $auth_user, $auth_pass))) {
        // se nao validar retorna false
        return FALSE;
    } else {
        // se validar retorna true
        return TRUE;
    }
}

// fim funcao conectar ldap

//Retorna o conteudo antes de determinado caractere
function str_before($str, $needle)
{
    $pos = strpos($str, $needle);

    return ($pos !== false) ? substr($str, 0, $pos) : $str;
}

/**
 *  Pesquisa um Registro pelo ID em uma Tabela
 *
 * function finduserRede( $table = null, $id = null, $campo = null, $operador = null ) {
 * //exemplo: table:usuarios - id:5 - campo: matricula = operador: like
 *
 * $database = open_database();
 * $found = null;
 *
 * try {
 * $sql = "SELECT * FROM " . $table . " WHERE " . $campo . " " . $operador . " " . $id;
 * $result = $database->query($sql);
 * $TotReg = countAll($table,$id);
 *
 * if  ($TotReg > 0) {
 * $found = current($database->query($sql)->fetchAll());
 * }
 * }
 * catch (PDOException $e) {
 * $_SESSION['message'] = $e->GetMessage();
 * $_SESSION['type'] = 'danger';
 * }
 *
 *
 * close_database($database);
 * return $found;
 * }
 */

