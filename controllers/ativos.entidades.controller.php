<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$controllerFile = "/controllers/ativos.entidades.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";

	$result = array();	

	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac']; 
	if (!user_has_access("CRI_ATIVOS")) $siopm->getHtmlError("Você não possui acesso a este módulo");

	$entidadesDAO 				= new EntidadesDAO($em);
	$entidadesPapeisDAO			= new EntidadesPapeisDAO($em);
	$ativosEntidadesDAO			= new AtivosEntidadesDAO($em);
	$ativosDAO					= new AtivosDAO($em);

	switch ($action) {

		case 'LISTAR_ATIVO_ENTIDADES':		
			
			$listaentidades = $ativosEntidadesDAO->listAllByIDAtivo($_REQUEST["AtivoID"]);	
			
			require $siopm->getForm('ativos.entidades.list');
			
			break;

		case 'EDITAR_ATIVO_ENTIDADE':	

			if (!user_has_access("CRI_ATIVOS_ENTIDADE")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-ativo-entidades" );
				die();
			}			

			$tituloForm = "Ativo Financeiro - Vincular Entidades";

			$ativoDadoBasico = array();
			$ativoEntidades = array();
			$listaentidades = array();					
			$entidades = $entidadesDAO->listAll();			
			$entidadesPapeis = $entidadesPapeisDAO->listAll();

			if (isset($_REQUEST["AtivoID"]) && $_REQUEST["AtivoID"] != ""){
					$listaentidades = $ativosEntidadesDAO->listAllByIDAtivo($_REQUEST["AtivoID"]);
			}

			if (isset($_REQUEST["AtivoID"]) && $_REQUEST["AtivoID"] > 0) {
			 	$ativoDadoBasico = $ativosDAO->findByID($_REQUEST["AtivoID"]);			 	
			}
			
			if (isset($_REQUEST["AtivoEntidadeID"]) && $_REQUEST["AtivoEntidadeID"] > 0) {
			 	$ativoEntidades = $ativosEntidadesDAO->findByID($_REQUEST["AtivoEntidadeID"]);			 	
			}
						
			require $siopm->getForm('ativos.entidades');
			
			break;

		case 'SALVAR_ATIVO_ENTIDADE':

			if (!user_has_access("CRI_ATIVOS_ENTIDADE")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-ativo-entidades" );
				die();
			}			

			$result = "[]";
			$result = true;
			
			if ($result === true) try{

				$em->beginTransaction();				
				$vo =  new AtivosEntidades();
				$vo = $ativosEntidadesDAO->fillEntitybyRequest($_REQUEST);			
				$logger->prepararLog($vo);
				$ativoEntidadeID = $ativosEntidadesDAO->persist($vo);
				$logger->logar($vo);
				$possuiEmissor = $ativosEntidadesDAO->hasTwoEmissor($_REQUEST["AtivoID"]);

				if($possuiEmissor){
					$em->rollBack();
						$result = json_encode(array("resultado"=> false, 
								  "mensagem"=>"Só é permitido vincular um emissor por ativo."));
				}else{

					$em->commit();
					$dadosEmpresa = $ativosEntidadesDAO->findDadosEmpresaByID($ativoEntidadeID);
					$result = json_encode(array("resultado"=> true, 
												"mensagem"=> "Entidade do Ativo Financeiro vinculada com Sucesso!",
												"ativoid"=> $dadosEmpresa["AtivoID"]												
												));
				}
	
			}catch (Exception $e){

				$em->rollBack();
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
							": Erro ao gravar Informações de Entidade do Ativo Financeiro !", "exception" => $e->getTraceAsString()));

			}						

			echo $result;
			break;			

		case 'EXCLUIR_ATIVO_ENTIDADE':

			if (!user_has_access("CRI_ATIVOS_ENTIDADE_EXCLUIR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-ativo-entidades" );
				die();
			}			

			$result = "[]";
			$result = true;

			if ($result === true) {

				$ativoentidadeid = $_REQUEST["AtivoEntidadeID"];

				try {
					$em->beginTransaction();

					$voEn = $ativosEntidadesDAO->find($ativoentidadeid);
					$logger->logarExclusao($voEn);
					$ativosEntidadesDAO->delete($voEn);
					//$ativosEntidadesDAO->execute("DELETE tblAtivosEntidades where AtivoEntidadeID = ':ativoentidadeid'", array(":ativoentidadeid" => $ativoentidadeid));
					$em->commit();
					$result = json_encode(array("resultado" => true, "mensagem" => "Vinculação de entidade excluída com sucesso!"));

				} catch (Exception $e) {

					$em->rollBack();
					$result = 
						json_encode(
							array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
								": Erro ao excluir Entidade $ativoentidadeid!", "exception" => $e->getTraceAsString()
							)
						);
				}

			}

			echo $result;
			break;

		default:

			if (isset($_REQUEST['ac'])) {

				$post_acao = $_REQUEST['ac'];

				if (!in_array($post_acao, array('LISTAR_ATIVO_ENTIDADES','EXCLUIR_ATIVO_ENTIDADE','SALVAR_ATIVO_ENTIDADE', 'EDITAR_ATIVO_ENTIDADE'))) {
					echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O campo "ação" não foi indicado corretamente.'));
					exit;
				}

			} else {
				echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': USUARIO POST AC NAO DEFINIDO.'));
			}

			break;

	}

?>
