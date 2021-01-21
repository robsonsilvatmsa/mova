<?php
$logado = $_SESSION['login'];
?>

<section class="body">

    <!-- start: header -->
    <header class="header">
        <div class="logo-container">
            <a href="<?=BASEURL?>" class="logo">
                <img src="<?= BASEURL ?>assets/images/LogoMOVA.png" height="35" alt="JSOFT Admin" />
            </a>
            <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
                <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
            </div>
        </div>

        <!-- start: search & user box -->
        <div class="header-right">

            <form action="pages-search-results.html" class="search nav-form">
                <div class="input-group input-search">
                    <input type="text" class="form-control" name="q" id="q" placeholder="Search...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>




            <span class="separator"></span>

            <div id="userbox" class="userbox">
                <a href="#" data-toggle="dropdown">
                    <div class="profile-info">
                        <span class="name"><?= $_SESSION['nome'] ?></span>
                    </div>

                    <i class="fa custom-caret"></i>
                </a>

                <div class="dropdown-menu">
                    <ul class="list-unstyled">
                        <li class="divider"></li>

                        <li>
                            <a role="menuitem" tabindex="-1" href="?fn=sair"><i class="fa fa-power-off"></i> Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- end: search & user box -->
    </header>

    <!-- Encerra conexao -->
    <?php
    //check if the get variable exists
    if (isset($_GET['fn'])) {
        excluisessao();
    }
    ?>		