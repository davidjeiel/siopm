<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$controllerFile = "/controllers/ativos.finalizar.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";

	$result = array();	

	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac']; 
	if (!user_has_access("CRI_ATIVOS")) $siopm->getHtmlError("Você não possui acesso a este módulo");


	$ativosDAO					= new AtivosDAO($em);
	$ativoMsgErroDAO			= new AtivosMensagensErrosFinalizacoesDAO($em);

	switch ($action) {

		case 'LISTAR_ATIVO_ERROS':		
			
			$inconsistencias = $ativoMsgErroDAO->listInconsistenciasAtivo($_REQUEST["AtivoID"]);	
			
			require $siopm->getForm('ativos.finalizar.list');
			
			break;
		
		case 'FINALIZAR_ATIVO':

			$tituloForm = "Ativo Financeiro - Finalizar";


			if (!user_has_access("CRI_ATIVOS_FINALIZAR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-ativo-finalizar" );
				die();
			}

			$ativoDadoBasico 				= array();

			 if (isset($_REQUEST["AtivoID"]) && $_REQUEST["AtivoID"] > 0) {
			 	$ativoDadoBasico = $ativosDAO->findByID($_REQUEST["AtivoID"]);			 	
			 } 

			 $ativoDadoBasico["AtivoDataFinalizacao"] =	PPOEntity::toDateBr(date("Y-m-d H:i:s", time()));
			 $inconsistencias = $ativoMsgErroDAO->listInconsistenciasAtivo($_REQUEST["AtivoID"]);		
			 
			 //$em->pr($inconsistencias);

			require $siopm->getForm('ativos.finalizar');
			
			break;

		case 'SALVAR_ATIVO_FINALIZACAO':	 

			if (!user_has_access("CRI_ATIVOS_FINALIZAR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-ativo-finalizar" );
				die();
			}			

			$result = "[]";
			$result = true;	
 			
 			$inconsistencias = $ativoMsgErroDAO->listInconsistenciasAtivo($_REQUEST["AtivoID"]);
			$result = validaDadosFinalizacao($_REQUEST, $inconsistencias );
			
			if ($result === true) try{

				$em->beginTransaction();				
				$vo =  new Ativos();
				$vo = $ativosDAO->fillEntitybyRequest($_REQUEST);
				$logger->prepararLog($vo);
				$ativoID = $ativosDAO->persist($vo, null, true);
				$logger->logar($vo);
				$em->commit();				
				$result = json_encode(array("resultado"=> true, "mensagem"=> "Finalização do cadastro do Ativo Financeiro salvos com Sucesso!" , "ativoid" => $ativoID));

			}catch (Exception $e){

				$em->rollBack();
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
							": Erro ao gravar Finalização do cadastro do  Ativo Financeiro !", "exception" => $e->getTraceAsString()
						)
					);

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

	function validaDadosFinalizacao($post, $inconsistencias ){		 

		if(count($inconsistencias)>0){
			echo json_encode(array("resultado" => false,"mensagem"=> 'O Ativo Financeiro possui pendências que impedem a finalização do cadastro.'));
			exit;
		}

		return true;
	}	
	
?>
