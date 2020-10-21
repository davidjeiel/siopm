<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$controllerFile = "/controllers/ativos.captura.eventos.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";

	$result = array();

	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac'];
	if (!user_has_access("CRI_CAPTURA_EVENTOS")) $siopm->getHtmlError("Você não possui acesso a este módulo");

	$capturaControleDAO 		= new CapturaControleDAO($em);
	$capturaEventosDAO 			= new CapturaPlanilhaEventosDAO ($em);
	$capturaPlanilhaAtivosDAO 	= new CapturaPlanilhaAtivosDAO ($em);
	$eventosDAO					= new EventosDAO($em);
	$transacoesDAO				= new TransacoesDAO($em);
	$capturaDemonstrativoDAO 	= new CapturaDemonstrativoDAO($em);
	$fechamentoCompetenciaDAO	= new FechamentoCompetenciaDAO($em);

	switch ($action) {

		case 'LISTAR_ARQUIVOS_CAPTURADOS':
		case 'LISTAR_ARQUIVOS_ATUALIZACAO':
			$listaArquivosCapturados = $capturaControleDAO->listAll();
			require $siopm->getTemplate('capturaeventos');
			if ($action == "LISTAR_ARQUIVOS_ATUALIZACAO") echo $contents;
			break;

		case 'LISTAR_EVENTOS_CAPTURADOS':
			ob_clean();
			$tituloForm = "Detalhes do arquivo importado - Lista de Eventos";	
			$listaeventoscapturados = $capturaControleDAO->listEventosByControleId($_REQUEST["ArquivoCapturadoID"]);
			require $siopm->getForm('ativo.captura.eventos.detalhes');
			//if ($action == "LISTAR_EVENTOS_CAPTURADOS") echo $contents;
			break;

		case 'IMPORTAR_ARQUIVO_EVENTOS':

			if (!user_has_access("CRI_CAPTURA_EVENTOS_IMPORTAR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "Importação de Arquivos" );
				die();
			}	

				$titulo_form = "Importação de arquivo";		
			
			require $siopm->getForm('ativo.captura.eventos');

			break;

		case 'CONCILIAR_VALORES_EVENTOS':

			if (!user_has_access("CRI_CAPTURA_CONCILIAR_VALORES_EVENTOS")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-orcamento" );
				die();
			}

			// $dadosControle = $capturaControleDAO->findByID($_REQUEST["ArquivoCapturadoID"]);

			// if (empty($dadosControle['DataCaptura']) ){
			// 	$result = json_encode(array("resultado" => false, "mensagem" =>"Sem arquivo ou dados para captura!"));
			// 	die($result);
			// }
			// if (!empty($dadosControle['DataConciliacao']) ){
			// 	$result = json_encode(array("resultado" => false, "mensagem" =>"Arquivo já conciliado!"));
			// 	die($result);
			// }
			
			try {

				// $listaPlanilhaAtivos = $capturaControleDAO->listPlanilhaAtivosByControleId($_REQUEST["ArquivoCapturadoID"]);				
				
				// $totalLinhas = count($listaPlanilhaAtivos); 
				// if ($totalLinhas < 1){
				// 	$result = json_encode(array("resultado" => false, "mensagem" =>"Arquivo não possui eventos para concialiação!"));
				// 	die($result);
				// }

				foreach ($listaPlanilhaAtivos as $capturaDados) {
					
					$competencia = PPOEntity::toDateBr($capturaDados["DataEvento"], "Y-m");
					$competenciaFechada = $fechamentoCompetenciaDAO->vefiricarSeCompetenciaFechada($competencia);
					
					$total = count($competenciaFechada); 	
					
					if ($total > 0){

						$result = json_encode(array("resultado" => false, "mensagem" =>$competencia."|". $competenciaFechada["Competencia"].$total. "Competência fechada para lançamentos!"));
						$em->rollback();
						die($result);
					}					
					

					$voDemonstrativo = $capturaDemonstrativoDAO->findByCodigoAtivoAndData($capturaDados["CodigoAtivo"],$capturaDados["DataEvento"]);

					if (count($voDemonstrativo->getID()) === 0){

						// $em->pr($capturaDados);
						// $em->pr($voDemonstrativo);
						$result = json_encode(array("resultado" => false, "mensagem" =>"Não foi realizado captura do saldo para data informada!"));
						$em->rollback();
						die($result);
					}

					$em->beginTransaction(); 
					// criar Transação	

					$voTransacao = New Transacoes();
					$voTransacao->setAtivoID($capturaDados["AtivoID"]);
					$voTransacao->setTransacaoData($capturaDados["DataEvento"]);
					$voTransacao->setSaldoDevedor($voDemonstrativo->getValorContabil());//pegar da tabela de demonstrativo, pesquisar pela data do evento.

					$logger->prepararLog($voTransacao);
					$transacaoID = $transacoesDAO->persist($voTransacao);
					$logger->logar($voTransacao);

			
					$voCapturaPlanilhaAtivos =  $capturaPlanilhaAtivosDAO->findVoByID($capturaDados["PlanilhaAtivosID"]);//pegar o vo pelo id
					$voCapturaPlanilhaAtivos->setTransacaoID($transacaoID);
					$voCapturaPlanilhaAtivos->setDemonstrativoID($voDemonstrativo->getId());
					$logger->prepararLog($voCapturaPlanilhaAtivos);
					$capturaPlanilhaAtivosDAO->update($voCapturaPlanilhaAtivos);
					$logger->logar($voCapturaPlanilhaAtivos);		

					$voDemonstrativo->setDataConciliacao(date("Y-m-d", time()));
					$capturaDemonstrativoDAO->update($voDemonstrativo);

					$listaeventoscapturados = $capturaControleDAO->listEventosByPlanilhaAtivoId($capturaDados["PlanilhaAtivosID"]);	



					// $em->commit();
					// $result = json_encode(array("resultado" => true, "mensagem" =>"Ta aqui!"));
					// 	//$em->rollback();
					// die($result);


					$totalLinhas = count($listaeventoscapturados);

					if($totalLinhas==0){
						//$em->pr($capturaDados);
						$result = json_encode(array("resultado" => false, "mensagem" =>"Não foram encontrados eventos capturados!"));
						$em->rollback();
						die($result);
					}
							
					foreach ($listaeventoscapturados as $evento) {	

					
						if(is_null($evento["CapturaTesourariaID"])){	
						
							//taxa de risco esta negativo na tabela da Tesouraria e positivo na tabela de Captura Eventos(planilha) e na tabela de eventos
							$capturaTesouria =  $capturaControleDAO->verificarExistenciaLancamento($evento['DataEvento'],$evento['Valor']);
							//$capturaPlanilhaAtivo = $capturaPlanilhaAtivosDAO->findByID($evento["PlanilhaAtivosID"]);
							
							if (isset($capturaTesouria["ID"]) && $capturaTesouria["ID"] > 0){
								if ($evento["TipoEventoID"] === 3){
									$valorTaxa = $fechamentoCompetenciaDAO->pegarTaxadeRisco($evento["ControleID"], $evento["DataEvento"], $evento["AtivoID"]);
									$evento["Valor"] = $evento["Valor"] - $valorTaxa;
								}	
					
								//Set dos objetos
								$voEventos = New Eventos();
								$voEventos->setTransacaoID($transacaoID);
								$voEventos->setEventoTipoID($evento["TipoEventoID"]);
								$voEventos->setEventoValor($evento['Valor']);
								$logger->prepararLog($voEventos);
								$eventoID = $eventosDAO->persist($voEventos);
								$logger->logar($voEventos);		

								//update da tabela de catpura
								$voCapturaPlanilhaEventos = $capturaEventosDAO->findVOByID($evento["PlanilhaEventosID"]);
								$voCapturaPlanilhaEventos->setCapturaTesourariaID($capturaTesouria["Id"]);
								$voCapturaPlanilhaEventos->setEventoID($eventoID);
								$capturaEventosDAO->update($voCapturaPlanilhaEventos);
							}							
						}



					}//endforeachPlanilhaeventos

				} //endforeachPlanhilhaAtivos

					$em->commit();
					$result = json_encode(array("resultado" => true, "mensagem" =>"Ta aqui!"));
						//$em->rollback();
					die($result);



				$voControle = $capturaControleDAO->findVOByID($_REQUEST["ArquivoCapturadoID"]);
				$voControle->setDataConciliacao(date("Y-m-d H:i:s", time()));
				$voControle->setConciliador($user->getUsuarioMatricula());
				$logger->prepararLog($voControle);
				$capturaControleDAO->update($voControle);
				$logger->logar($voControle);

				$em->commit();

			} catch (Exception $e) {
					$em->rollBack();
					$result =
						json_encode(
							array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) .
								": Erro ao Conciliar Dados !", "exception" => $e->getMessage() . " |TRACK==>" . $e->getTraceAsString()
							)
						);						
			}

			echo $result;
			break;

		case 'EXCLUIR_ARQUIVO':

			if (!user_has_access("CRI_CAPTURA_EVENTOS_EXCLUIR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-orcamento" );
				die();
			}			
			
			$dadosarquivo = array();
			$dadosarquivo = $capturaControleDAO->listEventosByControleId_SemDataCaptura($_REQUEST["ArquivoCapturadoID"]);	

			if (count($dadosarquivo) > 0) {	

				try {

					$em->beginTransaction();

						foreach ($dadosarquivo as $dado) {	
							$capturaEventosDAO->execute("DELETE tblCapturaPlanilhaEventos where CapturaPlanilhaAtivosID = ':capturaplanilhaativosid'", array(":capturaplanilhaativosid" => $dado['PlanilhaAtivosID']));
							$capturaPlanilhaAtivosDAO->execute("DELETE tblCapturaPlanilhaAtivos where CapturaControleID = ':capturacontroleid'", array(":capturacontroleid" => $dado['ControleID']));
							$capturaControleDAO->execute("DELETE tblCapturaControle where Id = ':id'", array(":id" => $dado['ControleID']));
						}					
					
					$em->commit();
					$result = json_encode(array("resultado" => true, "mensagem" => "Arquivo excluído com sucesso!"));

				} catch (Exception $e) {

					$em->rollBack();
					$result =
						json_encode(
							array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) .
								": Erro ao excluir orçamento!", "exception" => $e->getTraceAsString()
							)
						);

				}

			}

			echo $result;
			break;

		default:
			if (isset($_REQUEST['ac'])) {

				$post_acao = $_REQUEST['ac'];

				if (!in_array($post_acao, array('list','edit','save', 'find'))) {
					echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O campo "ação" não foi indicado corretamente.'));
					exit;
				}

			} else {
				echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': USUARIO POST AC NAO DEFINIDO.'));
			}

			break;

	}
?>
