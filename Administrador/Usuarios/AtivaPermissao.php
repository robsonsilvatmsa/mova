<?php 
  require_once('functions.php'); 

  if (isset($_GET['idSeg'])){
	
	$idSeg = $_GET['idSeg'];
	$idUser = $_GET['idUser'];
	$Tipo = $_GET['tipo'];
	  
    ativa($idSeg,$idUser,$Tipo);
  } else {
    die("ERRO: ID não definido.");
  }
?>