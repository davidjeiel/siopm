<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$controllerFile = "/controllers/ativos.integralizacoes.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";
	
	$result = array();	

	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac']; 
	if (!user_has_access("CRI_ATIVOS")) $siopm->getHtmlError("Você não possui acesso a este módulo");

	$ativosDAO					= new AtivosDAO($em);
	$integralizacoesDAO			= new IntegralizacoesDAO($em);
	$subscricoesDAO				= new SubscricoesDAO($em);
	$transacoesDAO				= new TransacoesDAO($em);
	$eventosDAO					= new EventosDAO($em);

	switch ($action) {


		case 'LISTAR_ATIVO_INTEGRALIZACOES':		
			
			$listaintegralizacoes = $integralizacoesDAO->listAllBySubscricaoID($_REQUEST["SubscricoesID"]);	
			
			require $siopm->getForm('ativos.integralizacoes.list');
			
			break;
		
		case 'EDITAR_ATIVO_INTEGRALIZACAO':

			if (!user_has_access("CRI_ATIVOS_INTEGRALIZACAO")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-integralizacoes" );
				die();
			}			

			$tituloForm= "Ativo Financeiro - Cadastrar Integralizações";
			$integralizacao 		= array();
			$listaintegralizacoes 	= array();
			$somatorio 				= array();

			if (isset($_REQUEST["SubscricoesID"]) && $_REQUEST["SubscricoesID"] != ""){
					$listaintegralizacoes = $integralizacoesDAO->listAllBySubscricaoID($_REQUEST["SubscricoesID"]);
					$ativoSubscricao	  = $subscricoesDAO->findByID($_REQUEST["SubscricoesID"]);
					$somatorio = $integralizacoesDAO->GetSomatoriobySubscricoesID($_REQUEST["SubscricoesID"]);	
			}

			if (isset($ativoSubscricao["AtivoID"]) && $ativoSubscricao["AtivoID"] > 0) {
			 		$ativoDadoBasico = $ativosDAO->findByID($ativoSubscricao["AtivoID"]);			 					 	
			}
			

			// if (isset($_REQUEST["IntegralizacaoID"]) && $_REQUEST["IntegralizacaoID"] > 0) {				
			//  		$integralizacao = $integralizacoesDAO->findByID($_REQUEST["IntegralizacaoID"]);			 		
			// }	
			
			require $siopm->getForm('ativos.integralizacoes');
			
			break;

		case 'SALVAR_ATIVO_INTEGRALIZACAO':

			if (!user_has_access("CRI_ATIVOS_INTEGRALIZACAO")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-integralizacoes" );
				die();
			}			

			$result = "[]";
			$result = true;
			$somario =  array();
 
			$result = validaDados($_REQUEST);
			
			if ($result === true) try{

				$em->beginTransaction();				

				//Salva a informações de integralizacao
				$vo =  new Integralizacoes();
				$vo = $integralizacoesDAO->fillEntitybyRequest($_REQUEST);
				$logger->prepararLog($vo);			
				$integralizacoesID = $integralizacoesDAO->persist($vo);
				$logger->logar($vo);
				
				
				// Cria uma nova Transação apra registrar a nova interalizacao na tabela de eventos
				$voTransacao = new Transacoes();

				$voTransacao->setAtivoID($_REQUEST['AtivoID']);
				$voTransacao->setTransacaoData($vo->getIntegralizacaoData());
				$voTransacao->setSaldoDevedor(0.00);

				$logger->prepararLog($voTransacao);
				$transacaoID = $transacoesDAO->persist($voTransacao);
				$logger->logar($voTransacao);

				// Salva as informações de integralizacao na tabela de eventos

				$voEventos = new Eventos();
				$voEventos->setTransacaoID($transacaoID);
				$voEventos->setEventoTipoID((int)16);
				$voEventos->setEventoValor(-$vo->getIntegralizacaoVolume());
				$logger->prepararLog($voEventos);
				$eventosDAO->persist($voEventos);
				$logger->logar($voEventos);		

				$em->commit();
				
				if (isset($integralizacoesID) && $integralizacoesID > 0){
					//$integralizacoesDAO->makeSomatoriobyAtivoID($_REQUEST["AtivoID"]);
					$somario = $integralizacoesDAO->GetSomatoriobySubscricoesID($_REQUEST["SubscricoesID"]);
				}				

				$result = json_encode(array("resultado"=> true,
						 "mensagem"=> "Integralização salva com sucesso!",						 
						 "integralizacoesid" => $integralizacoesID,
						 "ativoquantidade" => $somario["AtivoQuantidade"],
 						 "ativomedia" => "R$ ". PPOEntity::toMoneyBr($somario["media"],8),
 						 "ativovolume" => "R$ ". PPOEntity::toMoneyBr($somario["AtivoVolume"],8)));

			}catch (Exception $e){

				$em->rollBack();
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
							": Erro ao gravar Informações de Juros do Ativo Financeiro !", "exception" => $e->getTraceAsString()
						)
					);

			}						

			echo $result;
			break;

		case 'EXCLUIR_ATIVO_INTEGRALIZACAO':

			if (!user_has_access("CRI_ATIVOS_INTEGRALIZACAO_EXCLUIR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-integralizacoes" );
				die();
			}			

			$result = "[]";
			$result = true;
			$ativoIntegralizacoes = array();
			$somatorio = array();

			if ($result === true) {

				$ativoIntegralizacoes = $integralizacoesDAO->findByID($_REQUEST["IntegralizacaoID"]);
				$integralizacaoID = $ativoIntegralizacoes["IntegralizacaoID"];

				try {

					$em->beginTransaction();
					
					$voint = $integralizacoesDAO->find($integralizacaoID);
					$logger->logarExclusao($voint);
					$integralizacoesDAO->delete($voint);
					//$integralizacoesDAO->execute("DELETE tblIntegralizacoes where integralizacaoID = ':integralizacaoid'", array(":integralizacaoid" => $integralizacaoID));


					$em->commit();					

					if (isset($integralizacaoID) && $integralizacaoID > 0){
						//$integralizacoesDAO->makeSomatoriobyAtivoID($ativoIntegralizacoes["AtivoID"]);
						$somatorio = $integralizacoesDAO->GetSomatoriobySubscricoesID($ativoIntegralizacoes["SubscricoesID"]);
					}

					$result = json_encode(array("resultado" => true,
												"mensagem" => "Integralização excluída com sucesso!",
												"subscricoesid" =>$ativoIntegralizacoes["SubscricoesID"],
												"ativoquantidade" => $somatorio["AtivoQuantidade"],
						 						"ativomedia" => ("R$ ". PPOEntity::toMoneyBr($somatorio["media"])),
						 						"ativovolume" => "R$ ". PPOEntity::toMoneyBr($somatorio["AtivoVolume"])));

				} catch (Exception $e) {

					$em->rollBack();
					$result = 
						json_encode(
							array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
								": Erro ao excluir Integralizacao $jurosid!", "exception" => $e->getTraceAsString()
							)
						);

				}

			}

			echo $result;
			break;

		default:

			if (isset($_REQUEST['ac'])) {

				$post_acao = $_REQUEST['ac'];

				if (!in_array($post_acao, array('LISTAR_ATIVO_INTEGRALIZACOES','EDITAR_ATIVO_INTEGRALIZACAO','SALVAR_ATIVO_INTEGRALIZACAO', 'EXCLUIR_ATIVO_INTEGRALIZACAO'))) {
					echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O campo "ação" não foi indicado corretamente.'));
					exit;
				}

			} else {
				echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': USUARIO POST AC NAO DEFINIDO.'));
			}

			break;

	}

	function validaDados($post){


		if(!(is_null($post['SubscricoesData']))){	

			if (strtotime(PPOEntity::toDateBr($post['SubscricoesData'], "Y-m-d")) > strtotime(PPOEntity::toDateBr($post['IntegralizacaoData'], "Y-m-d"))) 
				return json_encode(array("resultado" => false, "mensagem"=>'A data da integralização não deve ser maior que a data da subscrição.'));	
	
		}

		if(!(is_null($post['AtivoDataVencimento']))){	

			if (strtotime(PPOEntity::toDateBr($post['IntegralizacaoData'], "Y-m-d")) > strtotime(PPOEntity::toDateBr($post['AtivoDataVencimento'], "Y-m-d"))) 
				return json_encode(array("resultado" => false, "mensagem"=>'A data da integralização não deve ser maior que a data de Vencimento do Ativo.'));	
	
		}		
	
		return true;
	}
	
?>
