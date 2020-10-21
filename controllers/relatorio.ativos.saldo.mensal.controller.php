<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$controllerFile = "/controllers/relatorio.ativos.saldo.mensal.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";

	if (!user_has_access("CRI_RELATORIOS_SALDOS")) $siopm->getHtmlError("Você não possui acesso a este módulo.");

	$saldosDAO		= new AtivosSaldosDAO($em);
	$ativosDAO 		= new AtivosDAO($em);
	$eventosDAO 	= new EventosDAO($em);
	$modalidadesDAO	= new ModalidadesDAO($em);
	
	$result = array();

	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac'];

	switch ($action) {

		case "RELATORIO_SALDOS_CABECALHO":
			$action = "";
			$tituloPagina 	= "Gerar Relatório de Saldos Contábeis Mensais";
			$modalidades 	= $modalidadesDAO->listAll();
			require $siopm->getReportHeader('ativos.saldo.mensal');
			break;

		case "RELATORIO_SALDOS":
		case "RELATORIO_SALDOS_EXCEL":
			
			$action 		= "";
			$tituloPagina 	="Relatório de Saldos Contábeis Mensais";

			$modalidade = "Todas";
			$whereModalidade = "";

			if (isset($_REQUEST["ModalidadeID"]) && $_REQUEST["ModalidadeID"] > 0){
				$mod = $modalidadesDAO->find($_REQUEST["ModalidadeID"]);
				$modalidade = $mod->getModalidadeNome() . " - " . $mod->getModalidadeSetor();
				$whereModalidade = " AND (a.ModalidadeID = " . $_REQUEST["ModalidadeID"] . ")";
			}

			$periodoInicial 	= $_REQUEST["DataInicial"];
			$periodoFinal 		= $_REQUEST["DataFinal"];

			$dataInicial = "01/". $periodoInicial . " 00:00:00";
			$dataInicial = implode('-', array_reverse(explode('/', substr($dataInicial, 0, 10)))).substr($dataInicial, 10);
			$dataInicial = new DateTime($dataInicial);

			$mesPeriodoFinal = substr($periodoFinal, 0, 2);
			$anoPeriodoFinal = substr($periodoFinal, 3);

			$ultimoDia = date("t", mktime(0,0,0,$mesPeriodoFinal,'01',$anoPeriodoFinal)); // Mágica, plim!
			$dataFinal = "$ultimoDia/$periodoFinal 00:00:00";
			$dataFinal = implode('-', array_reverse(explode('/', substr($dataFinal, 0, 10)))).substr($dataFinal, 10);
			$dataFinal = new DateTime($dataFinal);
			
			$dateRange = array();
			$eventosHeader = array();
			
			$modalidade = "Todas";
			$whereModalidade = "";
			if (isset($_REQUEST["ModalidadeID"]) && $_REQUEST["ModalidadeID"] > 0){
				$mod = $modalidadesDAO->find($_REQUEST["ModalidadeID"]);
				$modalidade = $mod->getModalidadeNome() . " - " . $mod->getModalidadeSetor();
				$whereModalidade = " AND (a.ModalidadeID = " . $_REQUEST["ModalidadeID"] . ")";
			}

			$sqlEventos = "SELECT a.AtivoID, e.EventoTipoID, et.EventoTipoNome, SUM(e.EventoValor) AS TOTALEVENTO, COUNT(e.EventoID) AS COUNTEVENTO
				FROM tblAtivos as a INNER JOIN tblTransacoes as t ON a.AtivoID = t.AtivoID INNER JOIN
					tblEventos as e ON t.TransacaoID = e.TransacaoID INNER JOIN tblEventosTipos as et ON e.EventoTipoID = et.EventoTipoID
				WHERE (a.AtivoID in (:ativoid))	 AND t.TransacaoData BETWEEN ':dataini' AND ':datafim' $whereModalidade ";
			
			if ($_REQUEST["TipoRelatorio"] == '1'){
				$tipoRelatorio = "Saldo Total";
			}else{
				$tipoRelatorio = "Saldo FGTS";
				//$sqlEventos .= " AND e.EventoTipoID in (1,2,3) ";
				$sqlEventos .= " AND e.EventoTipoID NOT IN (4) ";
			}

			$sqlEventos .= "	GROUP BY a.AtivoID, e.EventoTipoID, et.EventoTipoNome";
			
			$competencias = array();

			while($dataInicial <= $dataFinal){

				/* Cria a data final do dentro do mês */
				$dataMesFim = new DateTime($dataInicial->format('Y-m-d'));
				$dataMesFim = $dataMesFim->modify('+1 month');
				$dataMesFim = $dataMesFim->modify('-1 day');

				$competencia = new DateTime($dataInicial->format('Y-m'));
				$competenciaAnterior = new DateTime($dataInicial->format('Y-m'));
				$competenciaAnterior = $competenciaAnterior->modify('-1 month');

				$ativos = $ativosDAO->listAllFinalizados();
				//echo "<pre>";
				//$em->pr($ativos);exit;



				$eventosHeader = array();
				if (isset($ativos)) foreach ($ativos as &$row) {
					$arrEvento = array();

					// echo $eventosDAO->getSql($sqlEventos, array(":ativoid" => $row["AtivoID"],
					// 		":dataini" => $dataInicial->format('Y-m-d'), ":datafim" => $dataMesFim->format('Y-m-d')));
					// echo "<br>";

					$eventos = $eventosDAO->getArrayBySql($sqlEventos, array(":ativoid" => $row["AtivoID"],
							":dataini" => $dataInicial->format('Y-m-d'), ":datafim" => $dataMesFim->format('Y-m-d')));


					foreach ($eventos as $evento) {
						$arrEvento[$evento["EventoTipoID"]] = $evento;
						if (!isset($eventosHeader[$evento["EventoTipoID"]])){
							$eventosHeader[$evento["EventoTipoID"]] = $evento["EventoTipoNome"];
						}
					}

					if ($_REQUEST["TipoRelatorio"] == '1'){
						$row["saldo_anterior"] = $saldosDAO->getLastSaldoByAtivoCompetencia($row["AtivoID"], $competenciaAnterior->format('Y-m'));
						$row["saldo_atual"] = $saldosDAO->getLastSaldoByAtivoCompetencia($row["AtivoID"], $competencia->format('Y-m'));
					}else {
						$row["saldo_anterior"] = $saldosDAO->getLastSaldoFGTSByAtivoCompetencia($row["AtivoID"], $competenciaAnterior->format('Y-m'));
						$row["saldo_atual"] = $saldosDAO->getLastSaldoFGTSByAtivoCompetencia($row["AtivoID"], $competencia->format('Y-m'));
					}
					$row["eventos"] = $arrEvento;
				}
				

				$competencias[$dataInicial->format('m/Y')]["competencia_saldo_anterior"] = $competenciaAnterior->format('m/Y');
				$competencias[$dataInicial->format('m/Y')]["headers"] = $eventosHeader;
				$competencias[$dataInicial->format('m/Y')]["ativos"] = $ativos;

				unset($row);
	
				/* Incrementa o mes de inicio */
				$dataInicial = $dataInicial->modify('+1 month');

			}

			//$em->pr($competencias);
			//exit;

			if ($_REQUEST['ac'] == "RELATORIO_SALDOS_EXCEL"){

				downloadExcel($tituloPagina."-".$tipoRelatorio."-".$modalidade);
			}
			require $siopm->getReportBody('ativos.saldo.mensal');
			break;
			

		default:

			if (isset($_REQUEST['ac'])) {

				$post_acao = $_REQUEST['ac'];

				if (!in_array($post_acao, array('"RELATORIO_SALDOS_CABECALHO','"RELATORIO_SALDOS'))) {
					echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O campo "ação" não foi indicado corretamente.'));
					exit;
				}

			} else {
				echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O post ac não foi definido.'));
			}

			break;

	}

?>
