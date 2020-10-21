<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$controllerFile = "/controllers/ativos.subscricoes.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";

	$result = array();	

	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac']; 
	if (!user_has_access("CRI_ATIVOS")) $siopm->getHtmlError("Você não possui acesso a este módulo");

	$ativosDAO					= new AtivosDAO($em);
	$subscricoesDAO 			= new SubscricoesDAO($em);
	$integralizacoesDAO			= new IntegralizacoesDAO($em);

	switch ($action) {


		case 'LISTAR_ATIVO_SUBSCRICOES':		
			
			$listasubscricoes = $subscricoesDAO->listAllByIDAtivo($_REQUEST["AtivoID"]);
			require $siopm->getForm('ativos.subscricoes.list');
			
			break;
		
		case 'EDITAR_ATIVO_SUBSCRICAO':

			if (!user_has_access("CRI_ATIVOS_SUBSCRICAO")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-subscricoes" );
				die();
			}			

			$tituloForm = "Ativo Financeiro - Cadastrar Subscrições";
			$subscricao 			= array();
			$listasubscricoes 		= array();			

			if (isset($_REQUEST["AtivoID"]) && $_REQUEST["AtivoID"] != ""){
					$listasubscricoes = $subscricoesDAO->listAllByIDAtivo($_REQUEST["AtivoID"]);
					//$em->pr($listasubscricoes);					
			}

			if (isset($_REQUEST["AtivoID"]) && $_REQUEST["AtivoID"] > 0) {
			 		$ativoDadoBasico = $ativosDAO->findByID($_REQUEST["AtivoID"]);			 	
			}
			
			if (isset($_REQUEST["SubscricoesID"]) && $_REQUEST["SubscricoesID"] > 0) {				
			 		$subscricao = $subscricoesDAO->findByID($_REQUEST["SubscricoesID"]);			 		
			}	
			
			require $siopm->getForm('ativos.subscricoes');
			
			break;

		case 'SALVAR_ATIVO_SUBSCRICAO':

			if (!user_has_access("CRI_ATIVOS_SUBSCRICAO")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-subscricoes" );
				die();
			}			

			$result = "[]";
			$result = true;	

			$result = validaDados($_REQUEST);
			
			if ($result === true) try{

				$em->beginTransaction();				
				$vo =  new Subscricoes();
				$vo = $subscricoesDAO->fillEntitybyRequest($_REQUEST);		
				$logger->prepararLog($vo);
				$subscricoesID = $subscricoesDAO->persist($vo);
				$logger->logar($vo);	
				$em->commit();		
		
				$result = json_encode(array("resultado"=> true,
										 	"mensagem"=> "Subscrição salva com sucesso!",
											"subscricoesid" => $subscricoesID
										 	));

			}catch (Exception $e){

				$em->rollBack();
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
							": Erro ao gravar Informações de Subscrição do Ativo Financeiro !", "exception" => $e->getTraceAsString()
						)
					);

			}						

			echo $result;
			break;

		case 'EXCLUIR_ATIVO_SUBSCRICAO':

			if (!user_has_access("CRI_ATIVOS_SUBSCRICAO_EXCLUIR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-subscricoes" );
				die();
			}			

			$result = "[]";
			$result = true;					

			if ($result === true) {
		
				try {

					$em->beginTransaction();


					$listaintegralizacoes = $integralizacoesDAO->listVoBySubscricaoID($_REQUEST["SubscricoesID"]);

					foreach ($listaintegralizacoes as $voInt) {

						$logger->logarExclusao($voInt);
						$integralizacoesDAO->delete($voInt);
						
					}

					//$integralizacoesDAO->execute("DELETE tblIntegralizacoes 
					//where SubscricoesID = ':subscricoesid'", array(":subscricoesid" => $_REQUEST["SubscricoesID"]));
					//$subscricoesDAO->execute("DELETE tblSubscricoes where SubscricoesID = ':subscricoesid'", array(":subscricoesid" => $_REQUEST["SubscricoesID"]));
					$voSub = $subscricoesDAO->find($_REQUEST["SubscricoesID"]);
					$logger->logarExclusao($voSub);
					$subscricoesDAO->delete($voSub);


					$em->commit();					

					$result = json_encode(array("resultado" => true,
												"mensagem" => "Subscrição excluída com sucesso!"));

				} catch (Exception $e) {

					$em->rollBack();
					$result = 
						json_encode(
							array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
								": Erro ao excluir Subscrição", "exception" => $e->getTraceAsString()
							)
						);

				}

			}

			echo $result;
			break;

		default:

			if (isset($_REQUEST['ac'])) {

				$post_acao = $_REQUEST['ac'];

				if (!in_array($post_acao, array('LISTAR_ATIVO_SUBSCRICOES','EDITAR_ATIVO_SUBSCRICAO','SALVAR_ATIVO_SUBSCRICAO', 'EXCLUIR_ATIVO_SUBSCRICAO'))) {
					echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O campo "ação" não foi indicado corretamente.'));
					exit;
				}

			} else {
				echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': USUARIO POST AC NAO DEFINIDO.'));
			}

			break;

	}
	

	function validaDados($post){



		if(!(is_null($post['AtivoDataEmissao']))){	

			if (strtotime(PPOEntity::toDateBr($post['AtivoDataEmissao'], "Y-m-d")) > strtotime(PPOEntity::toDateBr($post['SubscricoesData'], "Y-m-d"))) 
				return json_encode(array("resultado" => false, "mensagem"=>'A data da subscrição não deve ser menor que a data de Emissão.'));	
	
		}

		if(!(is_null($post['AtivoDataVencimento']))){	

			if (strtotime(PPOEntity::toDateBr($post['SubscricoesData'], "Y-m-d")) > strtotime(PPOEntity::toDateBr($post['AtivoDataVencimento'], "Y-m-d"))) 
				return json_encode(array("resultado" => false, "mensagem"=>'A data da subscrição não deve ser maior que a data de Vencimento do Ativo.'));	
	
		}		
	
		return true;
	}

?>
