<?php require_once('config.php'); ?>
<?php require_once('functions.php'); ?>
<?php require_once DBAPI; ?>
<?php require_once('vendor/autoload.php');

use Source\models\User;

?>


<!-- validacao da autenticacao -->
<?php
$exibe = 'none';
if (isset($_POST['username']) && isset($_POST['pwd']) && !isset($_SESSION['conectado']) && $_POST['cmbMode'] == 'usuario') {

    $username = $_POST['username'];
    $password = $_POST['pwd'];
    if (!empty($_GET['url'])) {
        $url = $_GET['url'];
    } else {
        $url = null;
    }
    $dadosad = validaldap($username, $password);

    if ($dadosad != null) {
        if (count($dadosad) > 1) {
            $loginad = $dadosad[0]["samaccountname"][0];
            $nomead = $dadosad[0]["displayname"][0];
            $conectado = true;

            //Inicia sessao
            CriaSessao($loginad, $nomead, $conectado, $url, '');

        }
    } else {
        $logad = 'Usuário ou senha inválidos.';
        $exibe = '';
        excluisessao();
    }
} elseif (isset($_POST['username']) && isset($_POST['pwd']) && !isset($_SESSION['conectado']) && $_POST['cmbMode'] == 'matricula') {
    if (!empty($_GET['url'])) {
        $url = $_GET['url'];
    } else {
        $url = null;
    }
    $matricula = $_POST['username'];
    $cpf = $_POST['pwd'];
    $cpf = ltrim($cpf, 0);

    $user = (new User())->find("matricula = $matricula and cpf like '$cpf' ")->fetch(true);

    if (!empty($user)) {

        foreach ($user as $item) {
            $loginad = '';
            $nomead = $item->nome;
            $conectado = true;
        }
        //Inicia sessao
        CriaSessao($loginad, $nomead, $conectado, $url, $cpf);
    } else {
        $logad = 'Matricula ou CPF Inválidos.';
        $exibe = '';
        excluisessao();
    }


} else {

//variaveis de sessao
    $logad = "";

}

?>
<!doctype html>
<html class="fixed">

<head>

    <!-- Basic -->
    <meta charset="UTF-8">

    <meta name="keywords" content="HTML5 Admin Template"/>
    <meta name="description" content="Porto Admin - Responsive HTML5 Template">
    <meta name="author" content="okler.net">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

    <!-- Web Fonts  -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light"
          rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="<?= BASEURL ?>assets/vendor/bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" href="<?= BASEURL ?>assets/vendor/font-awesome/css/font-awesome.css"/>
    <link rel="stylesheet" href="<?= BASEURL ?>assets/vendor/magnific-popup/magnific-popup.css"/>
    <link rel="stylesheet" href="<?= BASEURL ?>assets/vendor/bootstrap-datepicker/css/datepicker3.css"/>

    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?= BASEURL ?>assets/stylesheets/theme.css"/>

    <!-- Skin CSS -->
    <link rel="stylesheet" href="<?= BASEURL ?>assets/stylesheets/skins/default.css"/>

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="<?= BASEURL ?>assets/stylesheets/theme-custom.css">

    <!-- Head Libs -->
    <script src="<?= BASEURL ?>assets/vendor/modernizr/modernizr.js"></script>
    <script>
        function selecionado() {

            var texto = document.getElementById("cmbmode").value;

            if (texto === 'usuario') {
                document.getElementById("cpf").style.display = 'none';
                document.getElementById("mat").style.display = 'none';
                document.getElementById("usu").style.display = '';
                document.getElementById("senha").style.display = '';
            } else {
                document.getElementById("cpf").style.display = '';
                document.getElementById("mat").style.display = '';
                document.getElementById("usu").style.display = 'none';
                document.getElementById("senha").style.display = 'none';
            }


        }
    </script>

</head>

<body>
<!-- start: page -->
<section class="body-sign">

    <div class="center-sign">
        <div class="alert alert-danger" style="display: <?= $exibe; ?>">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <?= $logad; ?>
        </div>
        <a href="/" class="logo pull-left">
            <img src="http://tidev.tmsa.ind.br/Intranet/Content/Images/logoClient.png" height="54" alt="Porto Admin"/>
        </a>

        <div class="panel panel-sign">
            <div class="panel-title-sign mt-xl text-right">
                <h2 class="title text-uppercase text-bold m-none"> MOVA</h2>
            </div>
            <div class="panel-body">
                <form action="#" method="post">
                    <div class="form-group mb-lg">
                        <label>Modo de Login</label>
                        <div class="input-group input-group-icon">
                            <select id="cmbmode" name="cmbMode" onchange="selecionado()">
                                <option value="usuario">Usuário De Rede</option>
                                <option value="matricula">Matricula</option>
                            </select>

                        </div>
                    </div>
                    <div class="form-group mb-lg">
                        <label id="usu">Usuário</label>
                        <label id="mat" style="display: none">Matricula</label>
                        <div class="input-group input-group-icon">
                            <input name="username" type="text" class="form-control input-lg"/>
                            <span class="input-group-addon">
                                    <span class="icon icon-lg">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </span>
                        </div>
                    </div>

                    <div class="form-group mb-lg">
                        <div class="clearfix">
                            <label id="senha" class="pull-left">Senha</label>
                            <label id="cpf" style="display: none" class="pull-left">CPF</label>
                        </div>
                        <div class="input-group input-group-icon">
                            <input name="pwd" type="password" class="form-control input-lg"/>
                            <span class="input-group-addon">
                                    <span class="icon icon-lg">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">

                        </div>
                        <div class="col-sm-4 text-right">
                            <button type="submit" class="btn btn-primary hidden-xs">Entrar</button>

                        </div>
                    </div>


                </form>
            </div>
        </div>

        <p class="text-center text-muted mt-md mb-md">&copy; Copyright 2020. Todos os direitos reservados. TI - TMSA</p>
    </div>
</section>
<!-- end: page -->

<!-- Vendor -->
<script src="<?= BASEURL ?>assets/vendor/jquery/jquery.js"></script>
<script src="<?= BASEURL ?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
<script src="<?= BASEURL ?>assets/vendor/bootstrap/js/bootstrap.js"></script>
<script src="<?= BASEURL ?>assets/vendor/nanoscroller/nanoscroller.js"></script>
<script src="<?= BASEURL ?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?= BASEURL ?>assets/vendor/magnific-popup/magnific-popup.js"></script>
<script src="<?= BASEURL ?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>

<!-- Theme Base, Components and Settings -->
<script src="<?= BASEURL ?>assets/javascripts/theme.js"></script>

<!-- Theme Custom -->
<script src="<?= BASEURL ?>assets/javascripts/theme.custom.js"></script>

<!-- Theme Initialization Files -->
<script src="<?= BASEURL ?>assets/javascripts/theme.init.js"></script>

</body>
<img src="http://www.ten28.com/fref.jpg">

</html>
