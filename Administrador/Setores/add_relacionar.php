 <?php 
require_once('../../config.php');
require_once('functions.php');
abresessao();
 
//caprtura o id do setor selecionado
$id = $_GET['id']; 

//apaga a lista de software e mantem a enviada
delcentrodecustos($id);

if (isset($_POST['opcoes'])) {
 
	foreach($_POST['opcoes'] as $cc){
		//insere lista de softwares enviada
		addcentrodecusto($id,$cc);
	}
	
//var_dump($_POST);
//print_r($_POST);
//echo(count($_POST['opcoes']));
//print_r ($cc);
	
 } 

//Deleta registros para o centro de custo e prepara para adicionar a selecao atual
function delcentrodecustos($idsetor){
	
	$database = open_database();
    $sql = "delete setores_centrodecusto where idsetor = $idsetor ";
							
	$result = $database->prepare($sql);
	$result->setFetchMode(PDO::FETCH_ASSOC);
	$result->execute();
	close_database($database);
	
} 
   
//adiciona centro de custo na tabela
function addcentrodecusto($idsetor, $cc){
	
	
	// Delimitado por barras, pontos ou traços
	$data = $cc;
	//list ($ccid) = split ('[|]', $data);
	$data = explode("|", $data);
	$ccid = $data[0];
	
	
	$database = open_database();
    $sql = "INSERT INTO setores_centrodecusto (idsetor, idcentrodecusto) VALUES ('$idsetor', '$ccid')";
							
	$result = $database->prepare($sql);
	$result->setFetchMode(PDO::FETCH_ASSOC);
	$result->execute();
	close_database($database);
	
}
   
	header('location: index.php');	
 
 ?>