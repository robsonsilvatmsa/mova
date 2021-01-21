<?php

require_once('../../config.php');
require_once(DBAPI);

$usuarios = null;
$user = null;
/**
 *  Listagem de usuarios
 */
function index() {
	global $usuarios;
	$usuarios = find_all('usuarios');
}

/**
 *	Atualizacao/Edicao de Cliente
 */
function edit() {

  $now = date_create('now', new DateTimeZone('America/Sao_Paulo'));

  if (isset($_GET['id'])) {

    $id = $_GET['id'];

    if (isset($_POST['user'])) {

      $user = $_POST['user'];
      $user['modificado'] = $now->format("Y-m-d H:i:s");

	  if (isset($_POST['admin'])) {
		$user['admin'] = 1;
	  } else {
		$user['admin'] = 0;
	  }

      update('usuarios', $id, $user);
      header('location: index.php');
    } else {

      global $user;
      $user = find('usuarios', $id);
    }
  } else {
    header('location: index.php');
  }
}

/**
 *  Visualização de um Cliente
 */
function view($id = null) {
  global $user;
  $user = find('usuarios', $id);
}

/**
  *	Busca Login na rede (base AD), utilizado para sugerir amarração
*/

function buscaloginAD($loginrede){
	$database = open_database();
	$found = null;
	$sql = "SELECT samAccountName 
				FROM OPENQUERY(ADSI, 
						'SELECT samAccountName,userAccountControl 
								FROM ''LDAP://DC=tecno,DC=local'' 
								WHERE objectClass = ''User'' AND objectCategory = ''Person'' AND samAccountName = ''". $loginrede ."*''')
				WHERE userAccountControl & 2 = 0 ";
	//$regs = current($database->query($sql)->fetch());
	//close_database($database);
	//if ($regs > 0) { return $regs; } else { return 0; };

    $result = $database->query($sql);
    if ($result) {
      $found = $result->fetchAll();

	close_database($database);

	}
}

/**
  *	Busca foto
*/

function foto($empresa, $matricula){

	require_once('../../config.php');
	require_once(DBAPI);

	$database = open_database();
	$found = null;

	$sql = "select fotemp from [tm-seniordb01].senior_prod.dbo.R034FOT where numcad = ". $matricula;

    //$sth = $medi_conn->prepare("select fotemp from [tm-seniordb01].senior_prod.dbo.R034FOT where numcad = '1792'") or die("Invalid query: " . $sth->errorInfo());
    //$sth->bindParam(':id',  $_GET['d']);

	$result = $database->prepare($sql);
	$result->setFetchMode(PDO::FETCH_ASSOC);
	$result->execute();

    //$sth->execute();
    $result->bindColumn(1, $image, PDO::PARAM_LOB, 0, PDO::SQLSRV_ENCODING_BINARY);
    $result->fetch(PDO::FETCH_ASSOC);

	if ($image) {
    echo '<img src="data:image/jpeg;base64,'.base64_encode($image).'" class="img-thumbnail" />';
	} else {
	echo '<img src="../../assets/images/SemImagem.gif" class="img-thumbnail" />';
	}

}


/**
  *	Busca texto dentro de string - antes de algum caractere
*/

/*
function after ($this, $inthat)
{
	if (!is_bool(strpos($inthat, $this)))
	return substr($inthat, strpos($inthat,$this)+strlen($this));
}
*/

?>
