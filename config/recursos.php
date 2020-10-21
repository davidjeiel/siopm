<?php

	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	ini_set('display_startup_errors',1);

	global $apresentacao;
	$apresentacao = true;

	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/siopm.class.php";
	
	$siopm 	= new Siopm($app_path);

	$siopm->includePHP("models", "GenericDAO.class.php");
	$siopm->includePHP("models");
	$siopm->includePHP("helpers");
	
	include_once $siopm->getRootPath() . "/lib/LDAP/UsuarioLDAP.Class.php";
	include_once $siopm->getRootPath() . "/lib/ppo/PPO.Class.php";
	include_once $siopm->getRootPath() . "/config/dbconf.php";
	include_once $siopm->getRootPath() . "/lib/php-excel-reader-2.2/excel_reader2.php";
	include_once $siopm->getRootPath() . "/controllers/Contador.Class.php";
	include_once $siopm->getRootPath() . "/controllers/Logger.Class.php";
	
	
	$custom_head = "";
	$contents 	 = "";
	$action 	 = "";
	
	$userLDAP  	 = new UsuarioLDAP();
	$arrFuncionalidadesExistentes = array();

	$emf 	= new PPOEntityManagerFactory();
	$em 	= $emf->getEntityManager($driver, $server, $database, $port, $user, $password, $encode);

	$vetorUsr = explode("\\",$_SERVER["LOGON_USER"]);
	$matricula = $vetorUsr[1];

	if (class_exists("UsuariosDAO") && class_exists("PerfisFuncionalidadesDAO")){
		$usuariosDAO 	= new UsuariosDAO($em);
		$user = $usuariosDAO->find($matricula);
		$perfisFuncDAO 	= new PerfisFuncionalidadesDAO($em);
		if ( strlen($user->getUsuarioMatricula()) == 7){

			
			$arrFuncionalidades = $perfisFuncDAO->listByPerfilID($user->getPerfilID());

			foreach ($arrFuncionalidades as $key => $value) {
				$arrFuncionalidadesExistentes[] = $value["FuncionalidadeNome"];
			}

		}else{

echo <<<HEREDOC
<html><head><title>Erro</title><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style>
p{font-family:Arial;color:#93200d;font-size:16px;font-weight:bold;text-align: center;line-height: 90px;}
</style></head><body><p>USUARIO NAO CADASTRADO NO SISTEMA.</p></body></html>
HEREDOC;
		die;

		}
	}else{
		die("Falha no sistema.");
	}
	
	// if ($user->getUsuarioMatricula() != "c066868") {
	// 	die("<h1> SITE EM MANUTENCAO. FAVOR TENTAR MAIS TARDE </h1>");
	// }

	// Geramos as tags I desabilitadas para serem utilizadas no template PHP.
	define("TAG_I_VISUALIZAR"	, "<div class='nav-icon-table'><i class='icon-search' 		></i></div>");
	define("TAG_I_HISTORICO"	, "<div class='nav-icon-table'><i class='icon-list-alt'		></i></div>");
	define("TAG_I_EDITAR"		, "<div class='nav-icon-table'><i class='icon-edit' 		></i></div>");
	define("TAG_I_FINALIZAR"	, "<div class='nav-icon-table'><i class='icon-warning-sign' ></i></div>");
	define("TAG_I_EXCLUIR"		, "<div class='nav-icon-table'><i class='icon-trash' 		></i></div>");
	define("TAG_I_SALVAR"		, "<div class='nav-icon-table'><i class='icon-ok' 			></i></div>");
	define("TAG_I_CANCELAR"		, "<div class='nav-icon-table'><i class='icon-remove' 		></i></div>");
	define("TAG_I_ARQUIVOS"		, "<div class='nav-icon-table'><i class='icon-folder-open'	></i></div>");
	define("TAG_I_CONTATOS"		, "<div class='nav-icon-table'><i class='icon-user'			></i></div>");
	define("TAG_I_NOVO"			, "<div class='nav-icon-table'><i class='icon-file'			></i></div>");

	define("TAG_I_DETALHES"		, "<div class='nav-icon-table'><i class='icon-align-justify'></i></div>");
	
	define("TAG_I_ATIVO_SALDO"		, "<div class='nav-icon-table'><i class='icon-tags'		></i></div>");
	define("TAG_I_ATIVO_TRANSACOES"	, "<div class='nav-icon-table'><i class='icon-random'	></i></div>");
	
	define("TAG_I_ENTIDADES"	, "<div class='nav-icon-table'><i class='icon-briefcase'	></i></div>");
	define("TAG_I_JUROS"		, "<div class='nav-icon-table'><i class='icon-plus-sign'	></i></div>");
	define("TAG_I_GARANTIAS"	, "<div class='nav-icon-table'><i class='icon-gift'			></i></div>");
	
	define("TAG_I_SUBSCRICAO",	 	 "<div class='nav-icon-table'><i class='icon-pencil'	>	</i></div>");
	define("TAG_I_INTEGRALIZACAO",	 "<div class='nav-icon-table'><i class='icon-tasks'		>	</i></div>");

	define("TAG_I_DADOS_GERAIS"						, "<div class='nav-icon-table'><i class='icon-list'			></i></div>");
	define("TAG_I_DADOS_BASICOS"					, "<div class='nav-icon-table'><i class='icon-list'			></i></div>");
	define("TAG_I_PROP_ENQUADRAMENTO_ANALISES"		, "<div class='nav-icon-table'><i class='icon-filter' 		></i></div>");
	define("TAG_I_PROP_MANIFESTACAO_SECURITIZADORA"	, "<div class='nav-icon-table'><i class='icon-check'		></i></div>");
	define("TAG_I_PROP_MANIFESTACAO_AG_OPERADOR"	, "<div class='nav-icon-table'><i class='icon-ok-circle'	></i></div>");
	define("TAG_I_CONCILIAR_CAPTURA"				, "<div class='nav-icon-table'><i class='icon-ok-sign'		></i></div>");
	define("TAG_I_CONFIRMAR_CAPTURA"				, "<div class='nav-icon-table'><i class='icon-ok-sign'		></i></div>");
	define("TAG_I_DEMONSTRATIVO_CAPTURA"			, "<div class='nav-icon-table'><i class='icon-th-large'		></i></div>");

	


	// Geramos as tags para serem utilizadas no JavaScript e no template PHP.
	define("TAG_A_VISUALIZAR"						, "<a rel='tooltip' class='nav-link-table visualizar'							title='Visualizar'						href='javascript:void(0);'>" . TAG_I_VISUALIZAR 						. "</a>");
	define("TAG_A_HISTORICO"						, "<a rel='tooltip' class='nav-link-table historico'							title='Historico'						href='javascript:void(0);'>" . TAG_I_HISTORICO 							. "</a>");
	define("TAG_A_EDITAR"							, "<a rel='tooltip' class='nav-link-table editar'								title='Editar' 							href='javascript:void(0);'>" . TAG_I_EDITAR 							. "</a>");
	define("TAG_A_FINALIZAR"						, "<a rel='tooltip' class='nav-link-table finalizar'							title='Finalizar'						href='javascript:void(0);'>" . TAG_I_FINALIZAR 							. "</a>");
	define("TAG_A_EXCLUIR"							, "<a rel='tooltip' class='nav-link-table excluir'								title='Excluir' 						href='javascript:void(0);'>" . TAG_I_EXCLUIR 							. "</a>");
	define("TAG_A_SALVAR"							, "<a rel='tooltip' class='nav-link-table salvar'								title='Salvar'							href='javascript:void(0);'>" . TAG_I_SALVAR 							. "</a>");
	define("TAG_A_CANCELAR"							, "<a rel='tooltip' class='nav-link-table cancelar'								title='Cancelar'						href='javascript:void(0);'>" . TAG_I_CANCELAR 							. "</a>");
	define("TAG_A_ARQUIVOS"							, "<a rel='tooltip' class='nav-link-table arquivos'								title='Cadastrar Arquivos'				href='javascript:void(0);'>" . TAG_I_ARQUIVOS 							. "</a>");
	define("TAG_A_CONTATOS"							, "<a rel='tooltip' class='nav-link-table contatos'								title='Contatos'						href='javascript:void(0);'>" . TAG_I_CONTATOS 							. "</a>");
	define("TAG_A_NOVO"								, "<a rel='tooltip' class='nav-link-table novo'									title='Novo'							href='javascript:void(0);'>" . TAG_I_NOVO 								. "</a>");
	define("TAG_A_DETALHES"							, "<a rel='tooltip' class='nav-link-table detalhes'								title='Detalhes'						href='javascript:void(0);'>" . TAG_I_DETALHES 							. "</a>");
	define("TAG_A_ATIVO_SALDO"						, "<a rel='tooltip' class='nav-link-table ativo-saldo'							title='Saldos Contábeis Mensais' 		href='javascript:void(0);'>" . TAG_I_ATIVO_SALDO 						. "</a>");
	define("TAG_A_ATIVO_TRANSACOES"					, "<a rel='tooltip' class='nav-link-table ativo-transacoes'						title='Transações Financeiras'			href='javascript:void(0);'>" . TAG_I_ATIVO_TRANSACOES 					. "</a>");
	define("TAG_A_ENTIDADES"						, "<a rel='tooltip' class='nav-link-table entidades'							title='Cadastrar Entidades'				href='javascript:void(0);'>" . TAG_I_ENTIDADES 							. "</a>");
	define("TAG_A_JUROS"							, "<a rel='tooltip' class='nav-link-table juros' 								title='Cadastrar Juros'					href='javascript:void(0);'>" . TAG_I_JUROS 								. "</a>");
	define("TAG_A_GARANTIAS"						, "<a rel='tooltip' class='nav-link-table garantias'							title='Cadastrar Garantias'				href='javascript:void(0);'>" . TAG_I_GARANTIAS 							. "</a>");
	define("TAG_A_SUBSCRICAO"						, "<a rel='tooltip' class='nav-link-table subscricao'							title='Cadastrar Subscrições'			href='javascript:void(0);'>" . TAG_I_SUBSCRICAO 						. "</a>");
	define("TAG_A_INTEGRALIZACAO"					, "<a rel='tooltip' class='nav-link-table integralizacao'						title='Cadastrar Integralizações'		href='javascript:void(0);'>" . TAG_I_INTEGRALIZACAO 					. "</a>");
	define("TAG_A_DADOS_GERAIS"						, "<a rel='tooltip' class='nav-link-table dados-gerais'							title='Cadastrar Dados Gerais'			href='javascript:void(0);'>" . TAG_I_DADOS_GERAIS 						. "</a>");
	define("TAG_A_DADOS_BASICOS"					, "<a rel='tooltip' class='nav-link-table dados-basicos'						title='Cadastrar Dados Básicos'			href='javascript:void(0);'>" . TAG_I_DADOS_BASICOS 						. "</a>");
	define("TAG_A_PROP_ENQUADRAMENTO_ANALISES"		, "<a rel='tooltip' class='nav-link-table prop-enquadramento-analises'			title='Enquadramento e Análises'		href='javascript:void(0);'>" . TAG_I_PROP_ENQUADRAMENTO_ANALISES 		. "</a>");
	define("TAG_A_PROP_MANIFESTACAO_SECURITIZADORA"	, "<a rel='tooltip' class='nav-link-table prop-manifestacao-securitizadora'		title='Manifestações da Securitizadora'	href='javascript:void(0);'>" . TAG_I_PROP_MANIFESTACAO_SECURITIZADORA 	. "</a>");
	define("TAG_A_PROP_MANIFESTACAO_AG_OPERADOR"	, "<a rel='tooltip' class='nav-link-table prop-manifestacao-agente-operador'	title='Manifestação do Agente Operador'	href='javascript:void(0);'>" . TAG_I_PROP_MANIFESTACAO_AG_OPERADOR 		. "</a>");
	define("TAG_A_CONCILIAR_CAPTURA"				, "<a rel='tooltip' class='nav-link-table conciliar-captura'					title='Conciliar'						href='javascript:void(0);'>" . TAG_I_CONCILIAR_CAPTURA 					. "</a>");
	define("TAG_A_CONFIRMAR_CAPTURA"				, "<a rel='tooltip' class='nav-link-table confirmar-captura'					title='Confirmar'						href='javascript:void(0);'>" . TAG_I_CONFIRMAR_CAPTURA 					. "</a>");
	define("TAG_A_DEMONSTRATIVO_CAPTURA"			, "<a rel='tooltip' class='nav-link-table demonstrativo-captura'				title='Demonstrativo'					href='javascript:void(0);'>" . TAG_I_DEMONSTRATIVO_CAPTURA 				. "</a>");


	// Adicionamos os tags das imagens padrão ao JavaScript da página
	$custom_head .= "<script>\r\n";

	$custom_head .= "\t\t" . "TAG_A_VISUALIZAR 	= " . json_encode(TAG_A_VISUALIZAR  ) . ";\r\n";
	$custom_head .= "\t\t" . "TAG_A_HISTORICO 	= " . json_encode(TAG_A_HISTORICO	) . ";\r\n";
	$custom_head .= "\t\t" . "TAG_A_EDITAR 		= " . json_encode(TAG_A_EDITAR		) . ";\r\n";
	$custom_head .= "\t\t" . "TAG_A_FINALIZAR 	= " . json_encode(TAG_A_FINALIZAR	) . ";\r\n";
	$custom_head .= "\t\t" . "TAG_A_EXCLUIR 	= " . json_encode(TAG_A_EXCLUIR		) . ";\r\n";
	$custom_head .= "\t\t" . "TAG_A_SALVAR 		= " . json_encode(TAG_A_SALVAR		) . ";\r\n";
	$custom_head .= "\t\t" . "TAG_A_CANCELAR 	= " . json_encode(TAG_A_CANCELAR	) . ";\r\n";
	$custom_head .= "\t\t" . "TAG_A_ARQUIVOS 	= " . json_encode(TAG_A_ARQUIVOS	) . ";\r\n";
	$custom_head .= "\t\t" . "TAG_A_CONTATOS 	= " . json_encode(TAG_A_CONTATOS	) . ";\r\n";
	$custom_head .= "\t\t" . "TAG_A_NOVO 		= " . json_encode(TAG_A_NOVO		) . ";\r\n";

	$custom_head .= "\t\t" . "TAG_A_DETALHES 	= " . json_encode(TAG_A_DETALHES	) . ";\r\n";


	$custom_head .= "\t\t" . "TAG_A_ATIVO_SALDO 		= " . json_encode(TAG_A_ATIVO_SALDO		) . ";\r\n";
	$custom_head .= "\t\t" . "TAG_A_ATIVO_TRANSACOES 	= " . json_encode(TAG_A_ATIVO_TRANSACOES) . ";\r\n";

	$custom_head .= "\t\t" . "TAG_A_CONCILIAR_CAPTURA 	= " . json_encode(TAG_A_CONCILIAR_CAPTURA). ";\r\n";
	$custom_head .= "\t\t" . "TAG_A_CONFIRMAR_CAPTURA 	= " . json_encode(TAG_A_CONFIRMAR_CAPTURA). ";\r\n";	
	$custom_head .= "\t\t" . "TAG_A_ENTIDADES 			= " . json_encode(TAG_A_ENTIDADES		) . ";\r\n";
	$custom_head .= "\t\t" . "TAG_A_JUROS 				= " . json_encode(TAG_A_JUROS			) . ";\r\n";
	$custom_head .= "\t\t" . "TAG_A_GARANTIAS 			= " . json_encode(TAG_A_GARANTIAS		) . ";\r\n";
	$custom_head .= "\t\t" . "TAG_A_SUBSCRICAO	 		= " . json_encode(TAG_A_SUBSCRICAO		) . ";\r\n";
	$custom_head .= "\t\t" . "TAG_A_INTEGRALIZACAO 		= " . json_encode(TAG_A_INTEGRALIZACAO	) . ";\r\n";
	
	$custom_head .= "\t\t" . "TAG_A_DEMONSTRATIVO_CAPTURA 				= " . json_encode(TAG_A_DEMONSTRATIVO_CAPTURA)				. ";\r\n";
	$custom_head .= "\t\t" . "TAG_A_DADOS_GERAIS 						= " . json_encode(TAG_A_DADOS_BASICOS) 						. ";\r\n";
	$custom_head .= "\t\t" . "TAG_A_DADOS_BASICOS 						= " . json_encode(TAG_A_DADOS_BASICOS) 						. ";\r\n";
	$custom_head .= "\t\t" . "TAG_A_PROP_ENQUADRAMENTO_ANALISES 		= " . json_encode(TAG_A_PROP_ENQUADRAMENTO_ANALISES)		. ";\r\n";
	$custom_head .= "\t\t" . "TAG_A_PROP_MANIFESTACAO_SECURITIZADORA 	= " . json_encode(TAG_A_PROP_MANIFESTACAO_SECURITIZADORA)	. ";\r\n";
	$custom_head .= "\t\t" . "TAG_A_PROP_MANIFESTACAO_AG_OPERADOR	 	= " . json_encode(TAG_A_PROP_MANIFESTACAO_AG_OPERADOR)		. ";\r\n";

	$custom_head .= "</script>\r\n";

	new Contador($em, $user, $controllerFile);
	$logger = new Logger($em, $user);
	/*
	* Verifica se o navegador é o Mozilla Firefox.
	**/

	$arrdados=explode(';',$_SERVER["HTTP_USER_AGENT"]);
	$navegador=(string)substr($arrdados[1],0,5);
	if (trim($navegador)=="MSIE" && $userLDAP->getMatricula() != "c066868"){
		echo <<<HEREDOC
<html><head><title>Erro</title><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style>
p{font-family:Arial;color:#93200d;font-size:16px;font-weight:bold;text-align: center;line-height: 90px;}
</style></head><body><p>Prezado Usuário, este sistema funciona apenas no Mozilla Firefox.</p></body></html>
HEREDOC;
		die;
	}

	function user_has_access($funcionalidade){
		global $user;
		global $arrFuncionalidadesExistentes;
		global $navegacao;

		/*if ($user->getUsuarioMatricula() == "c066868" ||
			$user->getUsuarioMatricula() == "c091636") return 1; else{
			return (in_array($funcionalidade, $arrFuncionalidadesExistentes) && $user->getUsuarioAtivo()) ? 1 : 0;
		}*/
		return (in_array($funcionalidade, $arrFuncionalidadesExistentes) && $user->getUsuarioAtivo()) ? 1 : 0;
	}
	// if $user autorizado, prosseguir...
	
?>
