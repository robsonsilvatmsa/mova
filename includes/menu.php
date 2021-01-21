<?php


use Source\models\UserGroup;
use Source\models\Group;


$loguser = $_SESSION['login'];
$permissoes = find_query("select us.nome as nomeuser, 
								us.login,
								us.id as codusu,   
								ac.*,
								seg.*
							from usuarios as us, acessos as ac, seguranca as seg
							where us.login = '$loguser' and us.id = ac.idusuarios and ac.idseguranca = seg.id and ac.ativo = 1");

$liberar = false;
/**
 * Query para trazer a consulta completa do usuario pelo grupo.
 * $permissoes = find_query("select us.nome as nomeuser,
 * us.login,
 * us.id as codusu,
 * ac.*,
 * seg.*,
 * gr.name_group,
 * grup.idgrupo
 * from usuarios as us, acessos as ac, seguranca as seg, usuariogrupo as grup, Grupo as gr
 * where us.login = '$loguser' and us.id = ac.idusuarios and ac.idseguranca = seg.id and ac.ativo = 1 and grup.idusuario = ac.idusuarios and grup.idgrupo = gr.id");
 */

$aDados = array();
if ($permissoes) :
    foreach ($permissoes as $permis) :
        $aDados[] = $permis['nome'];

        $idusuario = $permis['codusu'];
        $usergrup = find_query("select * from usuariogrupo where idusuario = $idusuario");

        if (!empty($usergrup)) {
            foreach ($usergrup as $item) {
                $_SESSION['idgrupo'] = $item['idgrupo'];
                $idgrupo = $item['idgrupo'];
            }
        }

        if (!empty($idgrupo))
            $Group = find_query("select * from Grupo where id = $idgrupo");
        if (!empty($Group))
            foreach ($Group as $value)
                $_SESSION['grupo'] = $value["name_group"];

        if (in_array("Menu Melhoria/Projeto", $aDados) && empty($_SESSION['grupo'])) {
            $aDados = null;
        }

        $_SESSION['idusuario'] = $permis['codusu'];


    endforeach;


endif;

?>
<div class="inner-wrapper">
    <!-- start: sidebar -->
    <aside id="sidebar-left" class="sidebar-left">

        <div class="sidebar-header">
            <div class="sidebar-title">

            </div>
            <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html"
                 data-fire-event="sidebar-left-toggle">
                <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
            </div>
        </div>

        <div class="nano">
            <div class="nano-content">
                <nav id="menu" class="nav-main" role="navigation">
                    <ul class="nav nav-main">
                        <?php if ($_SESSION['menu'] == "-") { ?>
                    <li class="nav-active">
                    <?php } else { ?>
                        <li>
                            <?php } ?>

                            <a href="<?php echo BASEURL; ?>">
                                <i class="fa fa-home" aria-hidden="true"></i>
                                <span>Página Inicial</span>
                            </a>
                        </li>

                        <?php if ((in_array("Menu Administrador", $aDados)) || (in_array("Menu CadastraGrupo", $aDados))) { ?>
                            <li class="nav-parent">
                                <!--<li class="dropdown">-->
                                <a href="javascript:;">
                                    <i class="fa fa-file-text"></i>
                                    <span>Administrador</span>
                                </a>
                                <ul class="nav nav-children">

                                    <li>
                                        <a href="<?= BASEURL; ?>administrador/usuarios/"><i class="fa fa-users"></i>
                                            Usuários
                                        </a>
                                    </li>

                                    <li class="nav-parent">
                                        <a><i class="fa fa-table"></i>
                                            Cadastrar
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a href="<?= BASEURL ?>Cadastros/grupos">Grupos</a>
                                            </li>
                                            <li>
                                                <a href="<?= BASEURL ?>Cadastros/areas">Áreas</a>
                                            </li>
                                            <li>
                                                <a href="<?= BASEURL ?>Cadastros/Foco">Foco</a>
                                            </li>
                                            <li class="nav-parent">
                                                <a>Analisadores</a>
                                                <ul class="nav nav-children">
                                                    <li>
                                                        <a href="<?= BASEURL ?>Cadastros/aprovadoresmelhoria">Melhoria</a>

                                                    </li>
                                                    <li>
                                                        <a href="<?= BASEURL ?>Cadastros/aprovadoresmelhoria/melhoriasemanalise.php ">Editar
                                                            Analisadores Melhoria</a>

                                                    </li>

                                                    <li>
                                                        <a href="<?= BASEURL ?>Cadastros/aprovadoresprojeto">
                                                            Projeto</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?= BASEURL ?>Cadastros/aprovadoresprojeto/projetoemanalise.php">
                                                            Editar Analisadores Projeto</a>
                                                    </li>

                                                </ul>
                                            </li>
                                            <li>
                                                <a href="<?= BASEURL ?>Cadastros/Valores">Valores</a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li>
                                        <a href="<?= BASEURL; ?>acompanhamentoAprovacao/"><i class="fa fa-file-text-o"></i>
                                            Acompanhar Fluxo de Aprovação
                                        </a>
                                    </li>
									<li>
                                        <a href="<?= BASEURL; ?>relatorio/"><i class="fa fa-bar-chart-o"></i>
                                            Relatórios
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>

                        <?php if ((in_array("Menu Administrador", $aDados)) || (in_array("Menu Melhoria/Projeto", $aDados)) || (in_array("Menu Analisadores", $aDados)) || (in_array("Menu AvaliadorEficacia/Auditoria", $aDados))) { ?>
                            <li class="nav-parent">
                                <!--<li class="dropdown">-->
                                <a href="javascript:;">
                                    <i class="fa  fa-list-alt"></i>
                                    <span>Melhoria</span>
                                </a>
                                <ul class="nav nav-children">
                                    <?php if ((in_array("Menu Administrador", $aDados)) || (in_array("Menu Melhoria/Projeto", $aDados))): ?>
                                        <li>
                                            <a href="<?= BASEURL ?>melhoria"><i class="fa  fa-paper-plane-o"></i>
                                                Incluir Melhoria
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ((in_array("Menu Administrador", $aDados)) || (in_array("Menu Analisadores", $aDados)) || (in_array("Menu AvaliadorEficacia/Auditoria", $aDados))): ?>
                                        <li class="nav-parent">
                                            <a><i class="fa  fa-check"></i>
                                                Analise
                                            </a>
                                            <ul class="nav nav-children">
                                                <?php if ((in_array("Menu Administrador", $aDados)) || (in_array("Menu Analisadores", $aDados))): ?>
                                                    <li>
                                                        <a href="<?= BASEURL ?>/Melhoria/Analise">Melhoria</a>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if ((in_array("Menu Administrador", $aDados)) || (in_array("Menu AvaliadorEficacia/Auditoria", $aDados))): ?>
                                                    <li>
                                                        <a href="<?= BASEURL ?>/Melhoria/eficacia">Eficácia</a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>


                            <li class="nav-parent">
                                <!--<li class="dropdown">-->
                                <a href="javascript:;">
                                    <i class="fa  fa-list-alt"></i>
                                    <span>Projeto</span>
                                </a>
                                <ul class="nav nav-children">
                                    <?php if ((in_array("Menu Administrador", $aDados)) || (in_array("Menu Melhoria/Projeto", $aDados))): ?>
                                        <li>
                                            <a href="<?= BASEURL ?>Projeto"><i class="fa  fa-paper-plane-o"></i>
                                                Incluir Projeto
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ((in_array("Menu Administrador", $aDados)) || (in_array("Menu Analisadores", $aDados)) || (in_array("Menu AvaliadorEficacia/Auditoria", $aDados))): ?>
                                        <li class="nav-parent">
                                            <a><i class="fa  fa-check"></i>
                                                Analise
                                            </a>
                                            <ul class="nav nav-children">
                                                <?php if ((in_array("Menu Administrador", $aDados)) || (in_array("Menu Analisadores", $aDados))): ?>
                                                    <li>
                                                        <a href="<?= BASEURL ?>/Projeto/Analise">Projeto</a>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if ((in_array("Menu Administrador", $aDados)) || (in_array("Menu AvaliadorEficacia/Auditoria", $aDados))): ?>
                                                    <li>
                                                        <a href="<?= BASEURL ?>/Projeto/eficacia">Eficácia</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?= BASEURL ?>/Projeto/auditoria">Auditoria</a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                            <?php if ((in_array("Menu Administrador", $aDados)) || (in_array("Menu CadastraGrupo", $aDados))): ?>
                                <li class="nav-parent">
                                    <!--<li class="dropdown">-->
                                    <a href="javascript:;">
                                        <i class="fa  fa-list-alt"></i>
                                        <span>Resgate</span>
                                    </a>
                                    <ul class="nav nav-children">

                                        <li>
                                            <a href="<?= BASEURL ?>Resgate"><i class="fa  fa-paper-plane-o"></i>
                                                Resgatar Valores
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                            <?php endif; ?>
                        <?php } ?>

                    </ul>
                </nav>

                <hr class="separator"/>

            </div>

        </div>

    </aside>
    <!-- end: sidebar -->


