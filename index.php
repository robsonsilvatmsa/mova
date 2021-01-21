<?php
require_once('config.php');
require_once('functions.php');
abresessao();
index();

//Nome do pai do menu para identificar
$_SESSION['menu'] = '';

?>

<?php include(ESTILO_TEMPLATE); ?>
<?php include(HEADER_TEMPLATE); ?>
<?php include(MENU_TEMPLATE); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Página Inicial</h2>

        <div class="right-wrapper pull-right">
            <ul class="breadcrumbs">
                <li>
                    <a href="">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Página Inicial</span></li>
            </ul>
            <p class="sidebar-right-toggle"></p>
        </div>

    </header>

    <section class="panel">


    </section>
</section>


<?php include(FOOTER_TEMPLATE); ?>
