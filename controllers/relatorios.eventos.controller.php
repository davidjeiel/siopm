<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$controllerFile = "/controllers/relatorios.eventos.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";

	if (!user_has_access("CRI_RELATORIOS_EVENTOS")) $siopm->getHtmlError("Você não possui acesso a este módulo.");

	$entidadesPapeisDAO			= new EntidadesPapeisDAO($em);
	$modalidadesDAO				= new ModalidadesDAO($em);

	$eventosDAO	= new EventosDAO($em);
	$ativosDAO = new AtivosDAO($em);
	$entidadesDAO = new EntidadesDAO($em);

	$result = array();

	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac'];

	switch ($action) {

		case "RELATORIO_EVENTOS_CABECALHO":
			$action = "";
			$titulo_pagina 	= "Gerar Relatório de Eventos Financeiros";
			$papeis 		= $entidadesPapeisDAO->listAll();
			$modalidades 	= $modalidadesDAO->listAll();
			require $siopm->getReportHeader('eventos');
			break;

		case "RELATORIO_EVENTOS":
		case "RELATORIO_EVENTOS_EXCEL":
			

			$action = "";
			$datainicial = $_REQUEST["DataInicial"];
			$datafinal = $_REQUEST["DataFinal"];
			$dataINI = "01/". $datainicial . " 00:00:00";
			$dataINI = PPOEntity::toDateUnicode($dataINI);
			$mes = substr($datafinal, 0, 2);
			$ano = substr($datafinal, 3);
			$ultimo_dia = date("t", mktime(0,0,0,$mes,'01',$ano)); // Mágica, plim!
			
			$dataFIM = "$ultimo_dia/$datafinal 23:59:59";
			$dataFIM = PPOEntity::toDateUnicode($dataFIM);
			$titulo_pagina 	= "Relatório de Eventos Financeiros";

			$EntidadePapelID = $_REQUEST["EntidadePapelID"];

			$eventosHeaderAtivos = array();
			$eventosHeaderPapel = array(); 

			$modalidade = "Todas";
			$whereModalidade = "";
			if (isset($_REQUEST["ModalidadeID"]) && $_REQUEST["ModalidadeID"] > 0){
				$mod = $modalidadesDAO->find($_REQUEST["ModalidadeID"]);
				$modalidade = $mod->getModalidadeNome() . " - " . $mod->getModalidadeSetor();
				$whereModalidade = " AND (a.ModalidadeID = " . $_REQUEST["ModalidadeID"] . ")";
			}



			$sqlEventos =	"SELECT e.EventoTipoID, et.EventoTipoNome, 
								SUM(e.EventoValor) AS TOTALEVENTO
								FROM tblAtivos as a INNER JOIN
								     tblTransacoes as t ON a.AtivoID = t.AtivoID INNER JOIN
								     tblEventos as e ON t.TransacaoID = e.TransacaoID INNER JOIN 
								     tblEventosTipos as et ON e.EventoTipoID = et.EventoTipoID
								WHERE (a.AtivoID in (:ativoid)) 
									AND t.TransacaoData BETWEEN '$dataINI' AND '$dataFIM' $whereModalidade
							GROUP BY e.EventoTipoID, et.EventoTipoNome
							ORDER BY et.EventoTipoNome";

			$tipo_relatorio 	= "Por Ativos";
			if ($EntidadePapelID == "1")  $tipo_relatorio = "Por Emissor";
			if ($EntidadePapelID == "3")  $tipo_relatorio = "Por Cedente";
			

			if ($_REQUEST['ac'] == "RELATORIO_EVENTOS_EXCEL"){						
				downloadExcel($titulo_pagina."-".$tipo_relatorio."-".$modalidade);
			}
			
			switch ($EntidadePapelID) {

				case "0":
					/* Relatório por ativo */
					
					$ativos = $ativosDAO->listAllFinalizados();

					foreach ($ativos as &$row) {
						$arrEvento = array();
						$eventos = $eventosDAO->getArrayBySql($sqlEventos, array(":ativoid" => $row["AtivoID"]));
						foreach ($eventos as $evento) {
							$arrEvento[$evento["EventoTipoID"]] = $evento;
							if (!isset($eventosHeaderAtivos[$evento["EventoTipoID"]])){
								$eventosHeaderAtivos[$evento["EventoTipoID"]] = $evento["EventoTipoNome"];
							}
						}
						ksort($eventosHeaderAtivos);

						$row["Eventos"] = $arrEvento;
					}
					unset($row);
					
					require $siopm->getReportBody('eventos');

					break;

				case "1":
				case "3":
					/* Relatório por Emissor ou Cedente */
					

					//http://blog.sqlauthority.com/2012/09/14/sql-server-grouping-by-multiple-columns-to-single-column-as-a-string/
					$ativosEntidades = $ativosDAO->listarEntidadesAtivosByPapel($_REQUEST["EntidadePapelID"]);

					if (isset($ativosEntidades)) foreach ($ativosEntidades as &$row) {
						$arrEvento = array();
						//$eventos = $eventosDAO->getArrayBySql($sqlEventos, array(":entidadeid" => $row["EntidadeID"]));
						$eventos = $eventosDAO->getArrayBySql($sqlEventos, array(":ativoid" => $row["Ativos"]));
						foreach ($eventos as $evento) {
							$arrEvento[$evento["EventoTipoID"]] = $evento;
							if (!isset($eventosHeaderPapel[$evento["EventoTipoID"]])){
								$eventosHeaderPapel[$evento["EventoTipoID"]] = $evento["EventoTipoNome"];
							}
						}
						$row["Eventos"] = $arrEvento;
					}
					
					unset($row);

					require $siopm->getReportBody('eventos');
					break;

				default:
					die("Ocorreu um erro ao selecionar Relatório");
					break;
			}

			break;

		default:

			if (isset($_REQUEST['ac'])) {

				$post_acao = $_REQUEST['ac'];

				if (!in_array($post_acao, array('"RELATORIO_EVENTOS_CABECALHO','"RELATORIO_EVENTOS'))) {
					echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O campo "ação" não foi indicado corretamente.'));
					exit;
				}

			} else {
				echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O post ac não foi definido.'));
			}

			break;

	}

?>
