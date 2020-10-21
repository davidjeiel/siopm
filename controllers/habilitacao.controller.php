<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$controllerFile = "/controllers/habilitacao.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";

	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac']; 

	$entidadesDAO 		= new EntidadesDAO($em);
	$habilitacaoDAO 	= new HabilitacoesDAO($em);
	$unidadesDAO 		= new UnidadesDAO($em);
	$ufDAO 				= new UnidadesFederacaoDAO($em);
	$conclusoesDAO 		= new ConclusoesDAO($em); 
	$hab_riscoDAO 		= new HabilitacoesAnalisesRiscosDAO($em); 
	$hab_juridicaDAO 	= new HabilitacoesAnalisesJuridicasDAO($em);  
	$hab_risco_extDAO 	= new HabilitacoesAnalisesRiscosExternosDAO($em); 
	$hab_certDAO	    = new HabilitacoesCertificacoesDAO($em);

	if (!user_has_access("HABILITACAO")) $siopm->getHtmlError("Você não possui acesso a este módulo");

	switch ($action) {

		case 'LISTAR_HABILITACOES':
			
			$habilitacoes = null;
			$habilitacoes = $habilitacaoDAO->listAllLastHabilitacoes();
			require $siopm->getTemplate('habilitacao');			
			break;

		case 'VISUALIZAR_HISTORICO_HABILITACAO':

			if (!user_has_access("HABILITACAO_HISTORICO")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-historico-habilitacao" );
				die();
			}				
		
			$historico_habilitacao = null;
			if (isset($_REQUEST["EntidadeID"]) && $_REQUEST["EntidadeID"] != ""){
				$historico_habilitacao = $habilitacaoDAO->listAllHabilitacoesByIDEntidade($_REQUEST["EntidadeID"]);
			}			
			require $siopm->getForm('habilitacao.historico');
			break;

		case 'EDITAR_HABILITACAO':
		case 'VISUALIZAR_HABILITACAO':
		case 'EDITAR_FINALIZAR_HABILITACAO':

			if ($action=="EDITAR_HABILITACAO" and !user_has_access("HABILITACAO_EDITAR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-habilitacao" );
				die();
			}			
			if ($action=="VISUALIZAR_HABILITACAO" and !user_has_access("HABILITACAO_VISUALIZAR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-habilitacao" );
				die();
			}			
			if ($action=="EDITAR_FINALIZAR_HABILITACAO" and !user_has_access("HABILITACAO_FINALIZAR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-habilitacao" );
				die();
			}			

			$titulo_form 	= "Nova Habilitação";		
						
			$unidades 			= $unidadesDAO->listAllPodeHabilitar();
			$unidades_federacao = $ufDAO->listAll();
			$conclusoes 		= $conclusoesDAO->listAllConclusoesAnalises();
			//$em->pr($conclusoes);
			$entidadesrating 	= $entidadesDAO->listAllAgentesRating(); 
				
			if (isset($_REQUEST["HabilitacaoID"]) && $_REQUEST["HabilitacaoID"] != ""){

				if ($action == 'EDITAR_HABILITACAO') $titulo_form = "Alterar Habilitação"; else $titulo_form = "Visualizando Habilitação"; 
			
				$habilitacao 	= $habilitacaoDAO->listByID($_REQUEST["HabilitacaoID"]);				
				$hab_risco 		= $hab_riscoDAO->findByHabilitacaoID($_REQUEST["HabilitacaoID"]);
				$hab_juridica 	= $hab_juridicaDAO->findByHabilitacaoID($_REQUEST["HabilitacaoID"]);
				$hab_risco_ext 	= $hab_risco_extDAO->findByHabilitacaoID($_REQUEST["HabilitacaoID"]); 
				$hab_cert 		= $hab_certDAO->findByHabilitacaoID($_REQUEST["HabilitacaoID"]); 
				$entidades 		= $entidadesDAO->listAll();

			} else{

				$entidades 			= $entidadesDAO->listAllEntidadesPodeHabilitar();
			}				

			if ($action == "EDITAR_FINALIZAR_HABILITACAO") 
				require $siopm->getForm('habilitacao.finalizar');				
			else
				require $siopm->getForm('habilitacao');		

			break;

		case 'SALVAR_HABILITACAO': 
		case 'SALVAR_FINALIZACAO_HABILITACAO':

			if ($action=="SALVAR_HABILITACAO" and !user_has_access("HABILITACAO_EDITAR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-habilitacao" );
				die();
			}			

			$result = "[]";
			$result = validaDados($_REQUEST);
			
			try{

				$em->beginTransaction();

				$vo = new Habilitacoes();

				$vo = $habilitacaoDAO->fillEntityByRequest($_REQUEST);	
	
				if ( !isset($_REQUEST["HabilitacaoConclusaoID"]) or $_REQUEST["HabilitacaoConclusaoID"] == "" ) {
					//Da tabela de conclusões: 1 -> Em Análise
					$vo->setHabilitacaoConclusaoID(1);
				} 	

				if (!( (int) $vo->getHabilitacaoID() > 0)) 
					$vo->setHabilitacaoDataCadastro( 
						PPOEntity::toDateBr(date("Y-m-d H:i:s", time())) 
					);

				$voHabRisco 	= $hab_riscoDAO->fillEntitybyRequest($_REQUEST);
				$voAnaliseJur 	= $hab_juridicaDAO->fillEntitybyRequest($_REQUEST);
				$voHabRiscoExt 	= $hab_risco_extDAO->fillEntitybyRequest($_REQUEST);
				$voHabCert	 	= $hab_certDAO->fillEntitybyRequest($_REQUEST);

				if (isset($_REQUEST["HabRiscoRating"])) {$voHabRisco->setHabRiscoRating(strtoupper($_REQUEST["HabRiscoRating"]));}
				if (isset($_REQUEST["HabRiscoExtRating"])) {$voHabRiscoExt->setHabRiscoExtRating(strtoupper($_REQUEST["HabRiscoExtRating"]));}
				if (isset($_REQUEST["HabilitacaoRating"])) {$vo->setHabilitacaoRating(strtoupper($_REQUEST["HabilitacaoRating"]));}
				$vo->setHabilitacaoDataUltimoUpdate( PPOEntity::toDateBr(date("Y-m-d H:i:s", time())) );
				$vo->setHabilitacaoMatriculaCadastro($user->getUsuarioMatricula());

				//$em->pr($voHabRisco);
				
				
				if ($action == "SALVAR_FINALIZACAO_HABILITACAO"){

					$logger->prepararLog($vo);	
					$habilitacaoDAO->persist($vo, null, true);
					$logger->logar($vo);

				}else{

					$logger->prepararLog($vo);	
					$vo->setHabilitacaoID((int)$habilitacaoDAO->persist($vo));	
					$logger->logar($vo);		

					$voHabRisco->setHabilitacaoID($vo->getHabilitacaoID());					
					$logger->prepararLog($voHabRisco);
					$voHabRisco->setHabRiscoID((int) $hab_riscoDAO->persist($voHabRisco));
					$logger->logar($voHabRisco);
					
					$voAnaliseJur->setHabilitacaoID($vo->getHabilitacaoID());
					$logger->prepararLog($voAnaliseJur);
					$voAnaliseJur->setHabJuridicaID((int) $hab_juridicaDAO->persist($voAnaliseJur));
					$logger->logar($voAnaliseJur);
					
					$voHabRiscoExt->setHabilitacaoID($vo->getHabilitacaoID());
					$logger->prepararLog($voHabRiscoExt);
					$voHabRiscoExt->setHabRiscoExtID((int) $hab_risco_extDAO->persist($voHabRiscoExt));
					$logger->logar($voHabRiscoExt);

					$voHabCert->setHabilitacaoID($vo->getHabilitacaoID());
					$logger->prepararLog($voHabCert);
					$voHabCert->setHabCertID((int) $hab_certDAO->persist($voHabCert));
					$logger->logar($voHabCert);

				}				
				
				$em->commit();

				$result = json_encode(array("resultado"=> true,
											 "habilitacaoid" =>$vo->getHabilitacaoID(),
											 "entidadeid"=>$vo->getEntidadeID(),
											 "habilitacaodatacadastro" => $vo->getHabilitacaoDataCadastro(),
											 "habriscoid" => $voHabRisco->getHabRiscoID(),
											 "habjuridicaid" => $voAnaliseJur->getHabJuridicaID(),
											 "habriscoextid" => $voHabRiscoExt->getHabRiscoExtID(),
											 "habcertid" => $voHabCert->getHabCertID(),
											  "mensagem"=> "Dados da habilitação salvos com sucesso!" ));

			}catch (Exception $e){

				$em->rollBack();
				
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
							": Erro ao gravar dados da habilitação!", "exception" => $e->getTraceAsString())
					);


			}

			echo $result;
			
			break;

		case 'FINALIZAR_HABILITACAO':

			if (!user_has_access("HABILITACAO_FINALIZAR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-finalizar-habilitacao" );
				die();
			}			

			if (isset($_REQUEST["HabilitacaoID"]) && $_REQUEST["HabilitacaoID"] != ""){

				$id = $_REQUEST["HabilitacaoID"];
				
				try{

					$em->beginTransaction();

					$genericDAO->execute(
						"UPDATE tblHabilitacoes SET habilitacaoObservacoes = '" . $_REQUEST["HabilitacaoObservacoes"] . "',
						habilitacaoMatriculaFinalizacao = '" . $usuarioLDAP->getMatricula(). "', 
						habilitacaoDataFinalizacao = '" . PPOEntity::toDateBr(date("Y-m-d H:i:s", time())) . "' 
						WHERE HabilitacaoID = :habilitacaoid", array(":habilitacaoid" => $id)
					);
					
					$em->commit();

					$result = json_encode(array("resultado" => true, "mensagem" => "Habilitação finalizada com sucesso!"));

				}catch (Exception $e){

					$em->rollBack();
					$result = 
						json_encode(
							array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
								": Erro ao finalizar habilitação $id!", "exception" => $e->getTraceAsString()
							)
						);
				}

			}else{
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
							": Identificador da habilitação não enviado. Erro ao tentar finalizar.", "exception" => $e->getTraceAsString()
						)
					);
			}
			
			echo $result;
			break;

		case 'EXCLUIR_HABILITACAO':	

			if (!user_has_access("HABILITACAO_EXCLUIR")) {

				$result = json_encode(array("resultado" => false, "mensagem" => "Você não possui permissão para excluida uma habilitação!"));
									
			}else if (isset($_REQUEST["HabilitacaoID"]) && $_REQUEST["HabilitacaoID"] != ""){

				$id = $_REQUEST["HabilitacaoID"];
				
				try{

					$habilitacoes = $habilitacaoDAO->listByID($_REQUEST["HabilitacaoID"]);
					
					if ($habilitacoes["HabilitacaoConclusaoID"] ==1 ){

						$em->beginTransaction();

						$vo = $habilitacaoDAO->find($id);
						$logger->prepararLog($vo);				
						$vo->setHabilitacaoAtiva(0);
						$habilitacaoDAO->update($vo);
						$logger->logar($vo);
						//$habilitacaoDAO->execute("UPDATE tblHabilitacoes SET HabilitacaoAtiva = 0 WHERE HabilitacaoConclusaoID = 1 and HabilitacaoID = :HabilitacaoID", array(":HabilitacaoID" => $id));					
						$em->commit();

						$result = json_encode(array("resultado" => true, "mensagem" => "Habilitação excluida com sucesso!"));
						
					} else{

						$result = json_encode(array("resultado" => false, "mensagem" => "Habilitação finalizada! Não é possível a exclusão."));
					
					}

				}catch (Exception $e){

					$em->rollBack();
					$result = 
						json_encode(
							array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
								": Erro ao excluir habilitação $id!", "exception" => $e->getTraceAsString()
							)
						);
				}

			}else{
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
							": Identificador da habilitação não enviado. Erro ao tentar excluir.", "exception" => $e->getTraceAsString()
						)
					);
			}
			
			
			echo $result;
			break;	

		default:
			if (isset($_REQUEST['ac'])){
				$post_acao = $_REQUEST['ac'];
				if (!in_array($post_acao, array('LISTAR_HABILITACOES','EDITAR_HABILITACAO','SALVAR_HABILITACAO','SALVAR_FINALIZACAO_HABILITACAO','EXCLUIR_HABILITACAO','FINALIZAR_HABILITACAO'))) {
					echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O campo "ação" não foi indicado corretamente.'));
					exit;
				}
			} else echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': USUARIO POST AC NAO DEFINIDO.'));
			break;
	}

	function validaDados($post){

		if (isset($post['HabilitacaoDataRecebimento']) && strtotime( PPOEntity::toDateBr(date("Y-m-d", time())) ) > 
			strtotime(PPOEntity::toDateBr($post['HabilitacaoDataRecebimento'], "Y-m-d"))) 
			return json_encode(array("resultado" => false, 
			"mensagem"=>'A data do Recebimento não pode ser uma data futura.'));


		if (isset($post['HabJuridicaData']) && strtotime(PPOEntity::toDateBr($post['HabilitacaoDataRecebimento'], "Y-m-d")) > 
			strtotime(PPOEntity::toDateBr($post['HabJuridicaData'], "Y-m-d"))) 
			return json_encode(array("resultado" => false, 
			"mensagem"=>'A data da Análise Jurídica não deve ser maior que a data de Recebimento Ofício.'));

		if (isset($post['HabRiscoData']) && strtotime(PPOEntity::toDateBr($post['HabilitacaoDataRecebimento'], "Y-m-d")) > 
			strtotime(PPOEntity::toDateBr($post['HabRiscoData'], "Y-m-d"))) 
			return json_encode(array("resultado" => false, 
			"mensagem"=>'A data da Análise de Risco não deve ser maior que a data de Recebimento Ofício.'));

		if (isset($post['HabRiscoValidade']) && isset($post['HabRiscoData']) 
			&& strtotime(PPOEntity::toDateBr($post['HabRiscoData'], "Y-m-d")) > 
			strtotime(PPOEntity::toDateBr($post['HabRiscoData'], "Y-m-d"))) 
			return json_encode(array("resultado" => false, 
			"mensagem"=>'A data da Análise de Risco não deve ser maior que a data de validade da análise.'));

		// if (isset($post['HabCertData']) && strtotime(PPOEntity::toDateBr($post['HabilitacaoDataRecebimento'], "Y-m-d")) > 
		// 	strtotime(PPOEntity::toDateBr($post['HabCertData'], "Y-m-d"))) 
		// 	return json_encode(array("resultado" => false, 
		// 	"mensagem"=>'A data da Certificação não deve ser maior que a data de Recebimento Ofício.'));

		if (isset($post['HabCertValidade']) && strtotime(PPOEntity::toDateBr($post['HabilitacaoDataRecebimento'], "Y-m-d")) > 
			strtotime(PPOEntity::toDateBr($post['HabCertValidade'], "Y-m-d"))) 
			return json_encode(array("resultado" => false, 
			"mensagem"=>'A data da de validade da certificação não deve ser menor que a data de Recebimento Ofício.'));

		if (isset($post['HabCertValidade']) && isset($post['HabCertData']) 
			&& strtotime(PPOEntity::toDateBr($post['HabCertData'], "Y-m-d")) > 
			strtotime(PPOEntity::toDateBr($post['HabCertData'], "Y-m-d"))) 
			return json_encode(array("resultado" => false, 
			"mensagem"=>'A data da Certificação não deve ser maior que a data de validade da vertificação.'));

		return true;

	}
?>
