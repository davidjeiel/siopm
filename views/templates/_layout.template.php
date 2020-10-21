<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="description" content="">
    <meta name="author" content="c066868 - Alan Ferreira de Lima Filho">
    <meta http-equiv="X-UA-Compatible" content="IE=10" />

    <title><?php echo $siopm->getTitle(); ?></title>
    <!-- Javascript files. -->
    <script src='/lib/JSON/json2.js'></script>
    <script src='/lib/JSON/json_parse.js'></script>
    <script src='/lib/jquery/1.10.2/jquery.js'></script>    
    <script src='/lib/jquery-ui/1.9.2/jquery-ui.js'></script>    
    <script src='/lib/plupload/js/plupload.full.min.js'></script>    
    <script src='/lib/flot/jquery.flot.js'></script>
    <script src='/lib/bignumber/BigNumber.js'></script>
    <script src='/lib/bootbox/bootbox.min.js'></script>
    <script src='/lib/bootstrap/js/bootstrap.js'></script>
    <script src='/lib/bootstrap-datepicker/js/bootstrap-datepicker.js'></script>
    <script src='/lib/bootstrap-datepicker/js/locales/bootstrap-datepicker.pt-BR.js'></script>
    <script src='/lib/datatables/jquery.dataTables.min.js'></script>
    <script src='/lib/datatables/jquery.datatables.sorting-plugins.js'></script>
    <script src='/lib/jquery-mask/jquery.maskedinput.min.js'></script>
    <script src='/lib/jquery-price-format/jquery.price_format.2.0.js'></script>
    <script src='/lib/jquery-validate/jquery.validate.min.js'></script>

    <script src='/lib/plupload/js/i18n/pt_BR.js'></script>
    <script src='/lib/plupload/js/jquery.plupload.queue/jquery.plupload.queue.min.js'></script>
    <script src='/lib/plupload/js/jquery.ui.plupload/jquery.ui.plupload.min.js'></script>
    <script src='/lib/plupload/js/moxie.js'></script>
    <script src='/lib/plupload/js/moxie.min.js'></script>

    <script src='/views/js/default.js'></script>
    <!-- CSSs -->
    <link href='/lib/bootstrap/css/bootstrap.min.css' rel='stylesheet'>
    <link href='/lib/bootstrap-extra-icons/glyphicon-sprite.css' rel='stylesheet'>
    <link href='/lib/bootstrap-datepicker/css/datepicker.css' rel='stylesheet'>
    <link href='/lib/bootstrap-datepicker/css/datepicker3.css' rel='stylesheet'>
    <link href='/lib/datatables/css/jquery.dataTables.css' rel='stylesheet'>
    <link href='/lib/datatables/css/jquery.dataTables.min.css' rel='stylesheet'>
    <link href='/lib/datatables/css/jquery.dataTables_themeroller.css' rel='stylesheet'>
    <link href='/lib/datatables/dataTables.bootstrap.css' rel='stylesheet'>
    <link href='/lib/jquery/css/jquery-ui.css' rel='stylesheet'>
    <link href='/lib/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css' rel='stylesheet'>
    <link href='/lib/plupload/js/jquery.ui.plupload/css/jquery.ui.plupload.css' rel='stylesheet'>    
    
    <link href='/views/css/default.css' rel='stylesheet'>
    <link href='/views/css/menu.css' rel='stylesheet'>
    <link href='/views/css/btn.css' rel='stylesheet'>
    <link rel="shortcut icon" href="/lib/bootstrap-extra-icons/favicon.ico" />
    <!-- <link rel="icon" href="/lib/bootstrap-extra-icons/favicon.ico" type="image/x-icon" /> -->
    

    <script> var app_path = '<?php echo $siopm->getAppPath() ?>'; </script>
    <?php echo isset($custom_head) ? $custom_head : ""; ?>

</head>

<body id='topo_sistema'>
    <!--Navigation-->
<?php
    if ($_SERVER["SERVER_NAME"] != "siopm.caixa"){
        echo "<div id='homologacao_container'>";
        echo "<h4>Ambiente de homologação</h4>";
        echo "</div>";
    }
?>
    <div id='menuPrincipal' class="navbar navbar-fixed-top">
        <div class="navbar-inner container-fluid">
            <a class="btn btn-navbar" data-target=".navbar-responsive-collapse" data-toggle="collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="<?php $siopm->getRootPath(); ?>index.php">SIOPM</a>
            
            <ul id='primary-nav' class="nav navbar-nav nav-collapse collapse navbar-responsive-collapse">

                <li class="dropdown">
                    <a tabindex="-1" id="dCadastros" href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-white nav-icon-cadastros"></i><span>Cadastros</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dCadastros">
                    <?php
                        echo (user_has_access("CADASTRO_USUARIOS" )) ? '<li><a href="index.php?usuarios">Usuários</a></li>' : '<li class="disabled"><a href="#">Usuários</a></li>';
                        echo (user_has_access("CADASTRO_ENTIDADE" )) ? '<li><a href="index.php?entidades">Entidades</a></li>' : '<li class="disabled"><a href="#">Entidades</a></li>';
                        echo (user_has_access("CADASTRO_PERFIL"   )) ? '<li><a href="index.php?perfis">Perfis</a></li>' : '<li class="disabled"><a href="#">Perfis</a></li>';
                    ?>
                    </ul>
                </li>

                <li class="dropdown">
                    <a tabindex="-1" id="dHabilitacoes" href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-white nav-icon-habilitacoes"></i><span>Habilitações</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dHabilitacoes">
                    <?php
                        echo (user_has_access("HABILITACAO" )) ? '<li><a href="index.php?habilitacao">Entidades</a></li>' : '<li class="disabled"><a href="#">Entidades</a></li>';
                    ?>
                    </ul>
                </li>

                <li class="dropdown">
                    <a tabindex="-1" id="dCRI" href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-white nav-icon-cri"></i><span>CRI</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dCRI">
                    <?php
                        echo (user_has_access("CRI_ORCAMENTO" )) ? '<li><a href="index.php?orcamentoscri">Orçamentos</a></li>' : '<li class="disabled"><a href="#">Orçamentos</a></li>';
                        echo (user_has_access("CRI_PRELIMINAR")) ? '<li><a href="index.php?propostapreliminar">Propostas Preliminares</a></li>' : '<li class="disabled"><a href="#">Propostas Preliminares</a></li>';
                        echo (user_has_access("CRI_DEFINITIVA")) ? '<li><a href="index.php?propostadefinitiva">Propostas Definitivas</a></li>' : '<li class="disabled"><a href="#">Propostas Definitivas</a></li>';
                        echo (user_has_access("CRI_ATIVOS"    )) ? '<li><a href="index.php?ativoscri">Ativos Financeiros</a></li>' : '<li class="disabled"><a href="#">Ativos Financeiros</a></li>';
                        // echo (user_has_access("CRI_EVENTOS"   )) ? '<li><a href="index.php?eventoscri">Eventos Financeiros</a></li>' : '<li class="disabled"><a href="#">Eventos Financeiros</a></li>';
                        // echo (user_has_access("CRI_CAPTURA_EVENTOS"   )) ? '<li><a href="index.php?capturaeventoscri">Captura de Eventos Financeiros</a></li>' : '<li class="disabled"><a href="#">Captura de Eventos Financeiros</a></li>';
                    ?>
                        <li class="divider"></li>
                        <li class="dropdown-submenu dropdown-header <?php echo (user_has_access("CRI_EVENTOS") || user_has_access("CRI_CAPTURA_EVENTOS")) ? "" : "disabled"; ?>">
                            <a tabindex="-1" href="#" onclick="javascript:void(0);">Eventos Financeiros</a>
                            <ul class="dropdown-menu">
                            <?php
                                echo (user_has_access("CRI_EVENTOS")) ? '<li><a href="index.php?eventoscri">Visualização de Eventos</a></li>' : '<li class="disabled"><a href="#">Visualização de Eventos</a></li>';
                                echo (user_has_access("CRI_CAPTURA_EVENTOS" )) ? '<li><a href="index.php?capturaeventoscri">Captura de Eventos</a></li>' : '<li class="disabled"><a href="#"">Captura de Eventos</a></li>';
                                echo (user_has_access("CRI_CAPTURA_SALDO_MENSAL" )) ? '<li><a href="index.php?capturasaldomensal">Captura de Saldos Contábeis Mensais</a></li>' : '<li class="disabled"><a href="#"">Captura de Saldos Contábeis Mensais</a></li>';
                                echo (user_has_access("CRI_FECHAMENTO_COMPETENCIA" )) ? '<li><a href="index.php?fechamentocompetenciascri">Fechamento de competência</a></li>' : '<li class="disabled"><a href="#"">Fechamento de competência</a></li>';                                                             
                            ?>
                            </ul>
                        </li>
                        <li class="dropdown-submenu dropdown-header <?php echo (user_has_access("CRI_RELATORIOS_EVENTOS") || user_has_access("CRI_RELATORIOS_SALDOS")) ? "" : "disabled"; ?>">
                            <a tabindex="-1" href="#" onclick="javascript:void(0);">Relatórios</a>
                            <ul class="dropdown-menu">
                            <?php
                                echo (user_has_access("CRI_RELATORIOS_EVENTOS")) ? '<li><a href="index.php?eventos-report">Eventos Financeiros</a></li>' : '<li class="disabled"><a href="#">Eventos Financeiros</a></li>';
                                echo (user_has_access("CRI_RELATORIOS_ORCAMENTOS_APLICACOES" )) ? '<li><a href="index.php?orcamentos-report">Orçamentos e Aplicações</a></li>' : '<li class="disabled"><a href="#"">Orçamentos e Aplicações</a></li>';
                                echo (user_has_access("CRI_RELATORIOS_SALDOS" )) ? '<li><a href="index.php?ativo-saldo-mensal-report">Saldos Contábeis Mensais</a></li>' : '<li class="disabled"><a href="#"">Saldos Contábeis Mensais</a></li>';                               
                            ?>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul id="secondary-nav" class="nav navbar-nav pull-right">
                <?php if (user_has_access("RELATORIO_LOG") || user_has_access("RELATORIO_ACESSO")) { ?>    
                     <li class="dropdown">
                        <a tabindex="-1" id="dlogs" href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-white icon-list-alt"></i><span>&nbsp; Logs</span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dlogs">
                            <?php
                                echo (user_has_access("RELATORIO_LOG")) ? '<li><a href="index.php?log">Log de dados</a></li>' : '<li class="disabled"><a href="#">Log de dados</a></li>';
                                echo (user_has_access("RELATORIO_ACESSO")) ? '<li><a href="index.php?acessos">Log de acessos</a></li>' : '<li class="disabled"><a href="#">Log de acessos</a></li>';
                            ?>
                        </ul>
                    </li>
                <?php } ?>

                <li><a data-toggle="modal" href="#"><i class="icon-user icon-white"></i>&nbsp;  <?php echo $user->getUsuarioNome(); ?>  </a></li>
                <li class="dropdown hide"><a href="#" data-toggle="dropdown"><i class="icon-cog icon-white">
                </i><span>Configurações</span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="icon-wrench"></i>&nbsp;Manutenção</a></li>
                    </ul>
                </li>
                <li><a data-toggle="modal" href="#dialog-form-sobre"><i class="icon-question-sign icon-white">
                </i>&nbsp;  Sobre </a></li>
            </ul>
        </div>
    </div>

    <div id='divConteudo' class=" container-fluid">
        <span id='spanConteudo'><?php echo $contents ?></span>
        <span id='spanFormAuxiliar'></span>
        <span id='spanForm'></span>
    </div>


    <!-- SOBRE -->

    <div id="modal_loader" class='modal-loader'> </div>

    <div id='divFormSobre' class='container-fluid'>

        <div id='dialog-form-sobre' class = 'modal hide fade in'>

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="titulo-sobre">Sobre</h3>
            </div>

           <div class="modal-body">
                <H3>SIOPM - Sistema de Operações de Mercado</H3>
                <p>
                    O Sistema de Gerenciamento das Operações de Mercado do FGTS (SIOPM) tem o
                    objetivo de registrar as operações realizadas pelo FGTS em mercado de capitais
                    e fornecer os meios adequados para a consulta dos dados cadastrados dessas
                    operações.
                </p>
                <hr>
                <br />
                <small class="pull-right"><i>Desenvolvedores</i></small>
                <br />
                <small class="pull-right"><i><strong> Alan Ferreira de Lima Filho </strong></i></small>
                <br />
                <small class="pull-right"><i><strong> Paulo Cesar Vidal Souto </strong></i></small>
                <br />
                <small >Versão: 2.0 - Jun/2015</small>
            </div>

            <div class="modal-footer">

                <div class="pull-left" id="manual">
                    <a clas="left" target='_blank' href='../files/manual/Manual_Operacional_Siopm.pdf'>
                        <span class="glyphicon glyphicon-download"></span>&nbsp; Manual Operacional &nbsp;&nbsp;
                    </a>  
                </div>

                <div class="pull-left" id="manual">
                    <a clas="left" target='_blank' href='../files/macro/MacroCapturaSISFIN.zip'>
                        <span class="glyphicon glyphicon-download"></span>&nbsp; Macro de Captura
                    </a>  
                </div>

                <button id="btn_sair" class="btn_sair btn" data-dismiss="modal" aria-hidden="true" >Sair</button>
            </div>

        </div>
    </div>
</body>
</html>


