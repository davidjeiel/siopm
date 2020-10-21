<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$controllerFile = "/controllers/ativos.captura.saldo.mensal.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";
	include_once $siopm->getRootPath() . "/controllers/CapturaControleSaldoMensal.Class.php";

	$result = array();

	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac'];
	if (!user_has_access("CRI_CAPTURA_SALDO_MENSAL")) $siopm->getHtmlError("Você não possui acesso a este módulo");
		
	$capturaControleSaldoMensal = new CapturaControleSaldoMensal($em, $user);
	$capturaDemonstrativoDAO 	= new CapturaDemonstrativoDAO($em);
	$fechamentoCompetenciaDAO	= new FechamentoCompetenciaDAO($em);

	switch ($action) {

		case 'LISTAR_ARQUIVOS_CAPTURADOS':
		case 'LISTAR_ARQUIVOS_ATUALIZACAO':
			$listaSaldosMensaisCapturados = $capturaDemonstrativoDAO->listarCapturadeSaldoMensal();
			require $siopm->getTemplate('capturasaldomensal');
			if ($action == "LISTAR_ARQUIVOS_ATUALIZACAO") echo $contents;
			break;

		case 'LISTAR_SALDOS_MENSAIS_CAPTURADOS':
			ob_clean();
			$tituloForm = "Detalhes da captura de saldo mensal - Lista de Saldo";					
			$listasaldomensaiscapturados = $capturaDemonstrativoDAO->listSaldosByDataCaptura(PPOEntity::toDateBr($_REQUEST["CapturaData"], "Y-m-d"));
			require $siopm->getForm('ativo.captura.saldo.mensal.detalhes');
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

		case 'CONCILIAR_VALORES_SALDOS':

			if (!user_has_access("CRI_CAPTURA_CONCILIAR_VALORES_SALDOS")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-saldo-mensal" );
				die();
			}

			try {

				$em->beginTransaction(); 				
				$capturaControleSaldoMensal->conciliarValores(PPOEntity::toDateBr($_REQUEST["CapturaData"], "Y-m-d"));
				$em->commit();
				$result = json_encode(array("resultado" => true, "mensagem" =>"Dados Confirmados!"));
			
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
								": Erro ao excluir arquivo!", "exception" => $e->getTraceAsString()
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
