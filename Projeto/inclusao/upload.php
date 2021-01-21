<?php
require_once('../../config.php');
require_once('functions.php');
abresessao();

function before($that, $inthat)
{
    return substr($inthat, 0, strpos($inthat, $that));
}

;

// use strrevpos function in case your php version does not include it
function strrevpos($instr, $needle)
{
    $rev_pos = strpos(strrev($instr), strrev($needle));
    if ($rev_pos === false)
        return false;
    else
        return strlen($instr) - $rev_pos - strlen($needle);
}

;
?>

<?php
// Flag que indica se há erro ou não
$erro = null;
// Quando enviado o formulário
if (isset($_FILES['arquivo'])) {
    // Configurações
    $extensoes = array(".dwg", ".txt", ".pdf", ".docx", ".jpg", ".xlsx", ".png", ".doc", ".msg");
    $caminho = "uploads/";

    // Recuperando informações do arquivo
    $nome = $_FILES['arquivo']['name'];
    $temp = $_FILES['arquivo']['tmp_name'];
    $codprov = $_SESSION['codprovisorio'];


    // Verifica se a extensão é permitida
    if (!in_array(strtolower(strrchr($nome, ".")), $extensoes)) {
        $erro = 'Extensão inválida';
    }
    // Se não houver erro
    if (!$erro) {
        // Gerando um nome aleatório para a imagem
        $nomeAleatorio = before(".", $nome) . strrchr($nome, ".");
        $nomeAleatorio = str_replace("'", "", $nomeAleatorio); //especifico para remover aspas simples
        $nomeAleatorio = $codprov . "_" . $nomeAleatorio;

        //insere registros no sql server
        $database = open_database();
        $sql = "INSERT INTO Anexos (idProvisorio, arquivo,origem) VALUES ('$codprov', '$nomeAleatorio','projeto')";

        $result = $database->prepare($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        close_database($database);


        // Movendo arquivo para servidor
        if (!move_uploaded_file($temp, $caminho . $nomeAleatorio))
            $erro = 'Não foi possível anexar o arquivo';
    }
}
?>
<?php include(ESTILO_TEMPLATE); ?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript">
    $(function ($) {
        // Definindo página pai
        var pai = window.parent.document;

        <?php if (isset($erro)): // Se houver algum erro   ?>

        // Exibimos o erro
        alert('<?php echo $erro ?>');

        <?php elseif (isset($nome)): // Se não houver erro e o arquivo foi enviado   ?>

        // Adicionamos um item na lista (ul) que tem ID igual a "anexos"
        $('#anexos', pai).append('<li lang="<?php echo $nomeAleatorio ?>"><?php echo $nomeAleatorio ?> <img src="image/remove.png" alt="Remover" class="remover" onclick="removeAnexo(this)" \/> </li>');

        <?php endif ?>

        // Quando enviado o arquivo
        $("#arquivo").change(function () {
            // Se o arquivo foi selecionado
            if (this.value != "") {
                // Exibimos o loder
                $("#status").show();
                // Enviamos o formulário
                $("#upload").submit();
            }
        });
    });
</script>


<form id="upload" action="upload.php" method="post" enctype="multipart/form-data" style="background-color: white">
    <input class="btn btn-default " type="file" name="arquivo" id="arquivo" style="background-color: white"/>
</form>

