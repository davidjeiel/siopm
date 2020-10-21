<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$controllerFile = "/controllers/ativos.captura.eventos.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";
	include_once $siopm->getRootPath() . "/controllers/CapturaControleEventos.Class.php";
	

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
	$capturaControleEventos 	= new CapturaControleEventos($em, $user);

	switch ($action) {

		case "ZERAR_DADOS_CAPTURA" :

			try {

				$em->beginTransaction();

				$eventosCriados =  $capturaEventosDAO->listAll();
				foreach ($eventosCriados as $eventoCriado) {
					$eventosDAO->deleteByID($eventoCriado["EventoID"]);
				}

				$transacoesCriadas = $capturaPlanilhaAtivosDAO->listAll();
				foreach ($transacoesCriadas as $transacaoCriada) {
					$transacoesDAO->deleteByID($transacaoCriada["TransacaoID"]);	

				}

				$em->execute("TRUNCATE TABLE tblCapturaControle");
				$em->execute("TRUNCATE TABLE tblCapturaDadosConta");
				$em->execute("TRUNCATE TABLE tblCapturaDemonstrativo");
				$em->execute("TRUNCATE TABLE tblCapturaPlanilhaAtivos");
				$em->execute("TRUNCATE TABLE tblCapturaPlanilhaEventos");
				$em->execute("TRUNCATE TABLE tblCapturaTesouraria");

				$em->commit();
				$result = json_encode(
					array("resultado"=> true, "mensagem"=>"Dados Zerados Com Sucesso!")
				);	
				
			} catch (Exception $e) {
				$em->rollBack();
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) .
							": Erro ao Zerar Dados da Captura !", "exception" => $e->getMessage() . " |TRACK==>" . $e->getTraceAsString()
						)
					);	
			}

			echo $result;
			break;

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

		case 'LISTAR_DEMONSTRATIVO_CAPTURADOS':
			ob_clean();
			$tituloForm = "Detalhes do arquivo importado - Demonstrativo";	
			$listademonstrativocapturados = $capturaControleDAO->listDemonstrativoByControleId($_REQUEST["ArquivoCapturadoID"]);
			require $siopm->getForm('ativo.captura.demonstrativo.detalhes');
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

			try {

				$em->beginTransaction(); 
				$capturaControleEventos->conciliarValores($_REQUEST["ArquivoCapturadoID"]);
				$em->commit();
				$result = json_encode(array("resultado" => true, "mensagem" =>"Dados Conciliados!"));
			
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
			$dadosarquivo = $capturaControleDAO->listEventosByControleId_SemDataConciliacao($_REQUEST["ArquivoCapturadoID"]);	

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
