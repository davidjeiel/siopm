<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$controllerFile = "/controllers/relatorio.acessos.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";

	if (!user_has_access("RELATORIO_ACESSO")) $siopm->getHtmlError("Você não possui acesso a este módulo.");

	$acessosDAO		= new AcessosDAO($em);
	
	$result = array();

	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac'];

	switch ($action) {

		case "REPORT_HEADER":
			$action = "";
			$tituloPagina 	= "Gerar Relatório de Acessos ao SIOPM";			
			$usuarios = $acessosDAO->listarUsuarios();
			$controllers =  $acessosDAO->listarControllers();
			require $siopm->getReportHeader('acessos');
			break;

		case "REPORT_BODY":
			$tituloPagina 	= "Relatório de Acessos ao SIOPM";
			$matricula = "";
			$dataInicial = "";
			$dataFinal = "";
			$acessos = array();
			$matricula = $_REQUEST['Matricula'];
			$controller = $_REQUEST['Controller'];
			$dataInicial = $_REQUEST['DataInicial'];
			$dataFinal = $_REQUEST['DataFinal'];
			$acessos = $acessosDAO->listar($matricula, $controller, $dataInicial, $dataFinal);
			$matricula = ($matricula == "0") ? "&#60;Todas&#62;" : $matricula;
			$controller = ($controller == "0") ? "&#60;Todos&#62;" : $controller;
			require $siopm->getReportBody('acessos');
			break;
			
		default:

			if (isset($_REQUEST['ac'])) {

				$post_acao = $_REQUEST['ac'];

				if (!in_array($post_acao, array("REPORT_HEADER"))) {
					echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O campo ACAO não foi indicado corretamente.'));	
				}

			} else {
				echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O post ac não foi definido.'));
			}

			break;

	}

?>
