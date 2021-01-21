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
 *  Adicionar usuarios
 */
function add() {
	
	$now = date_create('now', new DateTimeZone('America/Sao_Paulo'));

  if (!empty($_POST['user'])) {
    
    $today = 
      date_create('now', new DateTimeZone('America/Sao_Paulo'));

    $user = $_POST['user'];
    $user['modificado'] = $now->format("Y-m-d H:i:s");
	
	  if (isset($_POST['admin'])) {
		$user['admin'] = 1;
	  } else {
		$user['admin'] = 0;
	  }	
    
    save('usuarios', $user);
    header('location: index.php');
  }
}

/**
 *	Atualizacao/Edicao de id
 */
function edit() {

  if (isset($_GET['id'])) {
    $id = $_GET['id'];

    global $user;
    $user = find('usuarios', $id);
 
  } else {
    header('location: index.php');
  }
}


/**
  *	Busca permissoes para o usuario
*/

function buscaPermissoes($idUser, $idSeg, $Ativo){
	$database = open_database();
	$found = null;
	
	//Se parametro $ativo for true
	If ($Ativo) {
	$sql = "SELECT s.id
				from SEGURANCA as s inner join ACESSOS as a on s.id = a.idseguranca
				where a.idusuarios = $idUser and s.id = $idSeg and a.ativo = 1";
	} else {
	$sql = "SELECT s.id
				from SEGURANCA as s inner join ACESSOS as a on s.id = a.idseguranca
				where a.idusuarios = $idUser and s.id = $idSeg";		
	}
			
	$result = $database->query($sql);
    if ($result) {
		$found = $result->fetchAll();
   	  if (count($found) > 0) {
		  return true;
	  } else {
		  return false;
	  }
	
	close_database($database);
	
	}
}

/**
 *  Visualização de um id
 */
function view($id = null) {
  global $user;
  $user = find('usuarios', $id);
}


/**
 *	Ativa permissao do usuario
 */
function ativa($idSeg,$idUser,$tipo) {
	
	If ($tipo == 1) {
	
		If (buscaPermissoes($idUser,$idSeg,false)) {
			$database = open_database();
			$sql = "UPDATE ACESSOS SET ATIVO = 1 WHERE idseguranca = $idSeg and idusuarios = $idUser ";
			$result = $database->prepare($sql);
			$result->setFetchMode(PDO::FETCH_ASSOC);
			$result->execute();
			close_database($database);
		} else {
			$database = open_database();
			$sql = "INSERT ACESSOS VALUES ($idSeg,$idUser,1) ";
			$result = $database->prepare($sql);
			$result->setFetchMode(PDO::FETCH_ASSOC);
			$result->execute();
			close_database($database);		
		}
	
	} else {
		If (buscaPermissoes($idUser,$idSeg,false)) {
			$database = open_database();
			$sql = "UPDATE ACESSOS SET ATIVO = 0 WHERE idseguranca = $idSeg and idusuarios = $idUser ";
			$result = $database->prepare($sql);
			$result->setFetchMode(PDO::FETCH_ASSOC);
			$result->execute();
			close_database($database);
		}	
	}

	header('location: edit.php?id='.$idUser);
	
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
  *	Excluir
*/
function delete($id = null) {

  global $customer;
  $customer = remove('usuarios', $id);

  header('location: index.php');
}

/**
  *	Busca texto dentro de string - antes de algum caractere
*/

function after ($that, $inthat)
{
	if (!is_bool(strpos($inthat, $this)))
	return substr($inthat, strpos($inthat,$that)+strlen($that));
}




/**
  *	Busca foto
*/

function foto($matricula){

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
    echo '<img src="data:image/jpeg;base64,'.base64_encode($image).'" width="150" class="img-thumbnail" />';
	} else {
	echo '<img src="../../assets/img/avatars/SemImagem.gif" class="img-thumbnail" />';	
	}

}


?>
