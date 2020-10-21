<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$controllerFile = "/controllers/relatorio.orcamentos.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";

	if (!user_has_access("CRI_RELATORIOS_ORCAMENTOS_APLICACOES")) $siopm->getHtmlError("Você não possui acesso a este módulo.");

	$saldosDAO		= new AtivosSaldosDAO($em);
	$ativosDAO 		= new AtivosDAO($em);
	$eventosDAO 	= new EventosDAO($em);
	$modalidadesDAO	= new ModalidadesDAO($em);
	$orcamentosDAO = new OrcamentosDAO($em);
	
	$result = array();

	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac'];

	switch ($action) {

		case "RELATORIO_ORCAMENTOS_CABECALHO":
			$action = "";
			$tituloPagina 	= "Gerar Relatório de Orçamentos e Aplicações";			
			$anosOrcamentarios = $orcamentosDAO->getAnosOrcamentarios();
			require $siopm->getReportHeader('orcamentos');
			break;

		case "RELATORIO_ORCAMENTOS":
		case "RELATORIO_ORCAMENTOS_EXCEL":
			
			$action 		= "";
			$tituloPagina 	="Relatório de Orçamentos e Aplicações";
			$relatorioOrcamento = array();

			$anoInicial 	= $_REQUEST["DataInicial"];
			$anoFinal 		= $_REQUEST["DataFinal"];			
			
			if ($_REQUEST["TipoRelatorio"] == '1'){		
				$tipoRelatorio = "Por CRI";
				$relatorioOrcamento= $ativosDAO->listOrcamentoPorCRI($anoInicial,$anoFinal);

			}elseif ($_REQUEST["TipoRelatorio"] == '2'){
				$entidadePapelID = 1;
				$tipoRelatorio = "Por Emissor";
				$relatorioOrcamento= $ativosDAO->listOrcamentoPorTipo($entidadePapelID, $anoInicial,$anoFinal);

			}else{
				$entidadePapelID = 3;
				$tipoRelatorio = "Por Cedente";
				$relatorioOrcamento= $ativosDAO->listOrcamentoPorTipo($entidadePapelID, $anoInicial,$anoFinal);
			}	

			if ($_REQUEST['ac'] == "RELATORIO_ORCAMENTOS_EXCEL"){
				downloadExcel($tituloPagina."-".$tipoRelatorio);
			}

			require $siopm->getReportBody('orcamentos');
			break;
			

		default:

			if (isset($_REQUEST['ac'])) {

				$post_acao = $_REQUEST['ac'];

				if (!in_array($post_acao, array('"RELATORIO_ORCAMENTOS_CABECALHO','"RELATORIO_ORCAMENTOS_EXCEL'))) {
					echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O campo "ação" não foi indicado corretamente.'));
					exit;
				}

			} else {
				echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O post ac não foi definido.'));
			}

			break;

	}

?>
