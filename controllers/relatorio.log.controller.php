<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$controllerFile = "/controllers/relatorio.log.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";

	if (!user_has_access("RELATORIO_LOG")) $siopm->getHtmlError("Você não possui acesso a este módulo.");

	$tipos = array();
	$logDAO	= new LogDAO($em);
	$tipos = $logDAO->listarTipos();

	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac'];
	
	switch ($action) {

		case "REPORT_HEADER":
			$action = "";
			$tituloPagina 	= "Gerar Relatório de LOG do SIOPM";			
			$usuarios = $logDAO->listarUsuarios();
			$modulos =  $logDAO->listarModulos();
			
			require $siopm->getReportHeader('log');
			break;

		case "REPORT_BODY":
			$tituloPagina 	= "Relatório de LOG do SIOPM";	
			$matricula = "";
			$dataInicial = "";
			$dataFinal = "";
			$logs = array();
			$matricula = $_REQUEST['Matricula'];
			$modulo = $_REQUEST['Modulo'];
			$tipo = $_REQUEST['Tipo'];
			$dataInicial = $_REQUEST['DataInicial'];
			$dataFinal = $_REQUEST['DataFinal'];

			$logs = $logDAO->listar($matricula, $modulo, $tipo, $dataInicial, $dataFinal);
			

			if ($matricula == '0') $matricula = '&#60;Todas&#62;';
			if ($modulo == "0") $modulo = '&#60;Todos&#62;';
			if ($tipo == "0") $tipo =  '&#60;Todos&#62;';else{
				foreach ($tipos as $tp) {
					if ($tipo == $tp['Tipo']) $tipo = $tp['Descricao'];
				}
			} 
			require $siopm->getReportBody('log');
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