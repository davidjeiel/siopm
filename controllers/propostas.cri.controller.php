<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$controllerFile = "/controllers/propostas.cri.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";
	
	$result = array();

	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac']; 

	$propMsgErroDAO			= new PropostasMensagensErrosFinalizacoesDAO($em);	 

	$modoVisualizacao = false;

	$propostasDAO 			= new PropostasDAO($em);
	$orcamentoDAO			= new OrcamentosDAO($em);
	$propostasDetalhesDAO   = new PropostasDetalhesDAO($em);
	$entidadesDAO 			= new EntidadesDAO($em);
	$programasDAO 			= new ProgramasDAO($em);
	$unidadesDAO 			= new UnidadesDAO($em);
	$garantiasDAO			= new GarantiasDAO($em);
	$propostasFaixasDAO 	= new PropostasFaixasDAO($em);
	$propEmpreendTiposDAO 	= new PropostasEmpreendimentosTiposDAO($em);
	$propPesqSecurDAO		= new PropostasPesquisasSecuritizadoraDAO($em);

	$conclusoesDAO 				= new ConclusoesDAO($em);
	$propostasStatusDAO			= new PropostasStatusDAO($em);

	$propAnaliseJurDAO 			= new PropostasAnalisesJuridicasDAO($em);
	$propAnaliseRiscoDAO 		= new PropostasAnalisesRiscosDAO($em);
	$propAnaliseRiscoRatingDAO	= new PropostasAnalisesRiscosRatingDAO($em);
	$propEnquadramentosDAO 		= new PropostasEnquadramentosDAO($em);
	$propPesqSecuritizadoraDAO 	= new PropostasPesquisasSecuritizadoraDAO($em);

	$propManifSecuritizadoraDAO	= new PropostasManifSecuritizadorasDAO($em);
	$propManifSecurGarantiasDAO	= new PropostasManifSecurGarantiasDAO($em);

	$propManifGifugDAO			= new PropostasManifGifugDAO($em);
	$propManifGefomDAO			= new PropostasManifGefomDAO($em);
	$propResolucaoDAO			= new PropostasResolucoesDAO($em);

	$propConfigDAO			= new PropostasConfigDAO($em);

	$propContatosDAO		= new PropostasContatosDAO($em);
	$ContatosDAO			= new ContatosDAO($em);

	$ativosDAO				= new AtivosDAO($em);
	$ativoEntidadesDAO		= new AtivosEntidadesDAO($em);
	$ativosGarantiasDAO		= new AtivosGarantiasDAO($em);

	$propArquivosDAO = new PropostasArquivosDAO($em);
	$propArquivosTiposDAO = new PropostasArquivosTiposDAO($em);

	$titulo_form  		= "Proposta";
	$titulo_da_pagina  	= "";
	$fase 				= 0;

	switch ($action) {

		case 'LISTAR_PROPOSTAS':
		case 'LISTAR_PROPOSTAS_ATUALIZACAO':
			$fase = null;
			$titulo_da_pagina = "Propostas Preliminares e Definitivas";
			$propostas = $propostasDAO->listAll();
			require $siopm->getTemplate('propostas.cri');
			if($action == 'list_ajax') echo $contents;
			break;

		case 'LISTAR_PROPOSTA_PRELIMINAR':
		case 'LISTAR_PROPOSTA_PRELIMINAR_ATUALIZACAO':
			$fase = 1;
			$titulo_da_pagina = "Propostas Preliminares";
			$propostas = $propostasDAO->listAllPreliminares();
			require $siopm->getTemplate('propostas.cri');
			if($action == 'LISTAR_PROPOSTA_PRELIMINAR_ATUALIZACAO') echo $contents;
			break;

		case 'LISTAR_PROPOSTA_DEFINITIVA':
		case 'LISTAR_PROPOSTA_DEFINITIVA_ATUALIZACAO':
			$fase = 2;
			$titulo_da_pagina = "Propostas Definitivas";
			$propostas = $propostasDAO->listAllDefinitivas();
			require $siopm->getTemplate('propostas.cri');
			if($action == 'LISTAR_PROPOSTA_DEFINITIVA_ATUALIZACAO') echo $contents;
			break;

		case 'arquivos':
			$titulo_form .= " - Arquivos";

			if (isset($_REQUEST["PropostaDetalheID"]) && $_REQUEST["PropostaDetalheID"] > 0){	
				$proposta = $propostasDAO->findArrayByPropostaDetalheID($_REQUEST["PropostaDetalheID"]);
				$arquivos = $propArquivosDAO->listAquivosByPropostaDetalheID($_REQUEST["PropostaDetalheID"]);
				$arquivosTipos = $propArquivosTiposDAO->listAll();			
				require $siopm->getForm('proposta.cri.arquivos');
			} else {
				echo $siopm->getErrorModal("Não foi passado o id de detalhe da proposta corretamente");
			}
			break;

		case 'VISUALIZAR_PROPOSTA':


			if (!isset($_REQUEST["PropostaDetalheID"]) || !($_REQUEST["PropostaDetalheID"] > 0)){
				echo $siopm->getErrorModal("Não foi passado o id de detalhe da proposta corretamente");
				break;
			}

			$conclusoes 			= $conclusoesDAO->listAllConclusoesAnalises();
			$programas 				= $programasDAO->listAll();			
			$unidades  				= $unidadesDAO->listAll();
			$securitizadoras 		= $entidadesDAO->listAllSecuritizadoras();
			$agentesFiduciarios		= $entidadesDAO->listAllAgentesFiduciarios();
			$coordenadoresLideres	= $entidadesDAO->listAllCoordenadoresLideres();
			$originadoresCreditos	= $entidadesDAO->listAllOriginadoresCreditos();
			$faixas 				= $propostasFaixasDAO->listAllVigentes();
			$empreendTipos 			= $propEmpreendTiposDAO->listAll();
			$orcamentos 			= $orcamentoDAO->listAllCRI();

			$proposta  		= $propostasDAO->findViewArrayByPropostaDetalheID($_REQUEST["PropostaDetalheID"]);
			$contatos 		= $propContatosDAO->listAllContatosByPropostaID($proposta["PropostaID"]);
			
			$manifGifug 	= $propManifGifugDAO->findByPropostaDetalheID($proposta["PropostaDetalheID"]);
			$manifGefom 	= $propManifGefomDAO->findByPropostaDetalheID($proposta["PropostaDetalheID"]);
			$resolucao 		= $propResolucaoDAO->findByPropostaDetalheID($proposta["PropostaDetalheID"]);
			
			$config 		= $propostasDAO->findArrayByPropostaDetalheID($_REQUEST["PropostaDetalheID"]);
			$analiseJur 	= $propAnaliseJurDAO->findByPropostaDetalheID($proposta["PropostaDetalheID"]);
			$analiseRisco 	= $propAnaliseRiscoDAO->findByPropostaDetalheID($proposta["PropostaDetalheID"]);
			$propPesqSecur 	= $propPesqSecuritizadoraDAO->findByPropostaDetalheID($proposta["PropostaDetalheID"]);
			$propEnquad  	= $propEnquadramentosDAO->findByPropostaDetalheID($proposta["PropostaDetalheID"]);
			$manifSecuritizadora 	= $propManifSecuritizadoraDAO->findByPropostaDetalheID($proposta["PropostaDetalheID"]);

			$manifSecurGarantias = array();
			if (isset($manifSecuritizadora["PropManifSecurID"]) && $manifSecuritizadora["PropManifSecurID"] > 0)
				$manifSecurGarantias 	= $propManifSecurGarantiasDAO->listByPropManifSecurID($manifSecuritizadora["PropManifSecurID"]);
			
			$manifSecurGarantiasExistentes[] = null;
			if (isset($manifSecurGarantias)) foreach ($manifSecurGarantias as $key => $value) {
				if(isset($value["GarantiaID"])) $manifSecurGarantiasExistentes[] = $value["GarantiaID"];
			}
			$garantias = $garantiasDAO->listAll();
			$arquivos = $propArquivosDAO->listAquivosByPropostaDetalheID($_REQUEST["PropostaDetalheID"]);
			/* Contém o prazo e o juros máximos para as propostas.. */
			$propConfig 	= $propConfigDAO->findAtivo();
			$fase = 0;
			if (isset($proposta["PropostaFaseID"]) && $proposta["PropostaFaseID"] == 2) {
				$fase = "2";
				$titulo_form .= " Definitiva ";
			}else{
				$fase = "1";
				$titulo_form .= " Preliminar ";
			}
			$titulo_form .= " - Visualizar";	
			require $siopm->getForm('proposta.cri.visualizar');

			break;

		case 'EDITAR_CONTATO_PROPOSTA':

			$titulo_form .= " - Contatos";
			if (isset($_REQUEST["PropostaDetalheID"]) && $_REQUEST["PropostaDetalheID"] > 0){		
				$proposta = $propostasDAO->findArrayByPropostaDetalheID($_REQUEST["PropostaDetalheID"]);
				$contatos = $propContatosDAO->listAllContatosByPropostaID($proposta["PropostaID"]);
				require $siopm->getForm('proposta.cri.contatos');
			} else {
				echo $siopm->getErrorModal("Não foi passado o id de detalhe da proposta corretamente");
			}
			break;

		case 'EDITAR_PROPOSTA_DADOS_BASICOS':

			$proposta = array();
			$conclusoes 			= $conclusoesDAO->listAllConclusoesAnalises();
			$programas 				= $programasDAO->listAll();			
			$unidades  				= $unidadesDAO->listAll();
			$securitizadoras 		= $entidadesDAO->listAllSecuritizadoras();
			$agentesFiduciarios		= $entidadesDAO->listAllAgentesFiduciarios();
			$coordenadoresLideres	= $entidadesDAO->listAllCoordenadoresLideres();
			$originadoresCreditos	= $entidadesDAO->listAllOriginadoresCreditos();
			$faixas 				= $propostasFaixasDAO->listAllVigentes();
			$empreendTipos 			= $propEmpreendTiposDAO->listAll();
			$orcamentos 			= $orcamentoDAO->listAllCRI();

			if (isset($_REQUEST["PropostaDetalheID"]) && $_REQUEST["PropostaDetalheID"] > 0) 			
				$proposta = $propostasDAO->findArrayByPropostaDetalheID($_REQUEST["PropostaDetalheID"]);
	
			if (isset($proposta["PropostaFaseID"]) && $proposta["PropostaFaseID"] == 2) {
				$fase = "2";
				$titulo_form .= " Definitiva ";
			}else{
				$fase = "1";
				$titulo_form .= " Preliminar ";
			}
			$titulo_form .= " - Dados Básicos";

			if (isset($proposta["DataFinalizacao"]) && $proposta["DataFinalizacao"] > 0) $disabled = " disabled ";
			require $siopm->getForm('proposta.cri.dados.basicos');
			break;

		case 'EDITAR_PROPOSTA_MANIFESTACAO_AGENTES':

			$conclusoes = $conclusoesDAO->listAllConclusoesAnalises();

			$propConfig = array();

			if (isset($_REQUEST["PropostaDetalheID"]) && $_REQUEST["PropostaDetalheID"] > 0) {

				$proposta 		= $propostasDAO->findArrayByPropostaDetalheID($_REQUEST["PropostaDetalheID"]);
				$manifGifug 	= $propManifGifugDAO->findByPropostaDetalheID($proposta["PropostaDetalheID"]);
				$manifGefom 	= $propManifGefomDAO->findByPropostaDetalheID($proposta["PropostaDetalheID"]);
				$resolucao 		= $propResolucaoDAO->findByPropostaDetalheID($proposta["PropostaDetalheID"]);

				if (isset($proposta["PropostaFaseID"]) && $proposta["PropostaFaseID"] == 2) {
					$fase = "2";
					$titulo_form .= " Definitiva ";
				}else{
					$fase = "1";
					$titulo_form .= " Preliminar ";
				}

				$titulo_form .= " - Manifestações do Agente Operador";
				
				require $siopm->getForm('proposta.cri.manif.agentes');

			} else {
				echo $siopm->getErrorModal("Não foi passado o id de detalhe da proposta corretamente");
			}
			break;

		case 'EDITAR_PROPOSTA_ENQUADRAMENTO_ANALISE':

			$conclusoes = $conclusoesDAO->listAllConclusoesAnalises();
			$rating		= $propAnaliseRiscoRatingDAO->listAll();

			if (isset($_REQUEST["PropostaDetalheID"]) && $_REQUEST["PropostaDetalheID"] > 0) {

				$proposta 		= $propostasDAO->findArrayByPropostaDetalheID($_REQUEST["PropostaDetalheID"]);
				$config 		= $propostasDAO->findArrayByPropostaDetalheID($_REQUEST["PropostaDetalheID"]);
				$analiseJur 	= $propAnaliseJurDAO->findByPropostaDetalheID($proposta["PropostaDetalheID"]);
				$analiseRisco 	= $propAnaliseRiscoDAO->findByPropostaDetalheID($proposta["PropostaDetalheID"]);
				$propPesqSecur 	= $propPesqSecuritizadoraDAO->findByPropostaDetalheID($proposta["PropostaDetalheID"]);
				$propEnquad  	= $propEnquadramentosDAO->findByPropostaDetalheID($proposta["PropostaDetalheID"]);

				/* Contém o prazo e o juros máximos para as propostas.. */
				$propConfig 	= $propConfigDAO->findAtivo();

				if (isset($proposta["PropostaFaseID"]) && $proposta["PropostaFaseID"] == 2) {
					$fase = "2";
					$titulo_form .= " Definitiva ";
				}else{
					$fase = "1";
					$titulo_form .= " Preliminar ";
				}

				$titulo_form .= " - Enquadramento e Análises";

				require $siopm->getForm('proposta.cri.enquad.analises');

			} else {
				echo $siopm->getErrorModal("Não foi passado o id de detalhe da proposta corretamente");
			}
			
			break;

		case 'EDITAR_PROPOSTA_MANIFESTACAO_SECURITIZADORA':
			
			$garantias= array();
			$manifSecurGarantias = array();
			$manifSecurGarantiasExistentes = array();

			$conclusoes = $conclusoesDAO->listAllConclusoesAnalises();
			
			if (isset($_REQUEST["PropostaDetalheID"]) && $_REQUEST["PropostaDetalheID"] > 0) {

				$proposta 				= $propostasDAO->findArrayByPropostaDetalheID($_REQUEST["PropostaDetalheID"]);
				$manifSecuritizadora 	= $propManifSecuritizadoraDAO->findByPropostaDetalheID($proposta["PropostaDetalheID"]);

				if (isset($manifSecuritizadora["PropManifSecurID"]) && $manifSecuritizadora["PropManifSecurID"] > 0)
					$manifSecurGarantias 	= $propManifSecurGarantiasDAO->listByPropManifSecurID($manifSecuritizadora["PropManifSecurID"]);
				else $manifSecurGarantias = array();

				if (isset($manifSecurGarantias)) foreach ($manifSecurGarantias as $key => $value) {
					if(isset($value["GarantiaID"])) $manifSecurGarantiasExistentes[] = $value["GarantiaID"];
				}

				$garantias = $garantiasDAO->listAll();

				if (isset($proposta["PropostaFaseID"]) && $proposta["PropostaFaseID"] == 2) {
					$fase = "2";
					$titulo_form .= " Definitiva ";
				}else{
					$fase = "1";
					$titulo_form .= " Preliminar ";
				}

				$titulo_form .= " - Manifestação da Securitizadora";

				require $siopm->getForm('proposta.cri.manif.securitizadora');

			} else {
				echo $siopm->getErrorModal("Não foi passado o id de detalhe da proposta corretamente");
			}

			break;

		case 'FINALIZAR_PROPOSTA':

			$result = validaDadosProposta($_REQUEST);
			if ($result !== true){
				echo $result;
				break;
			}

			if (isset($_REQUEST["PropostaFaseID"])) $fase = $_REQUEST["PropostaFaseID"];

			if (!($fase == 1 or $fase == 2)){
				$result = json_encode(array("resultado"=> false,"mensagem"=> "Dados da fase não foi passado corretamente! $fase"));
			}else try{

				$status = "";

				$em->beginTransaction();

				$id = $_REQUEST["PropostaID"];

				if (isset($_REQUEST["ValorAprovadoGEFOM"]) && $_REQUEST["ValorAprovadoGEFOM"] > 0){ 

					$ValorAprovadoGEFOM = $_REQUEST["ValorAprovadoGEFOM"];
					$propostasDAO->execute("UPDATE tblPropostas SET ValorAprovadoGEFOM = $ValorAprovadoGEFOM WHERE PropostaID = $id");
					
				}				

				$vo	= $propostasDetalhesDAO->fillEntitybyRequest($_REQUEST);

				if ( (int) $vo->getPropostaStatusID() == 2) $status = "Aprovada";
				
				if ( (int) $vo->getPropostaStatusID() == 3) $status = "Não Aprovada";
				
				if ( (int) $vo->getPropostaStatusID() == 4) $status = "Desistência";
				
				$propostaDetalheID = $propostasDetalhesDAO->update($vo, null, true);
			
				if ($fase == 1 && (int) $vo->getPropostaStatusID() == 2){

					$voDef = $propostasDetalhesDAO->find($propostaDetalheID);
					$voDef->setPropostaStatusID(1);
					$voDef->setPropostaDetalheID(null);
					$voDef->setPropostaFaseID(2); //Fase Definitiva
					$voDef->setDataFinalizacao(null);
					$propostasDetalhesDAO->insert($voDef);
					

				}


				if ($fase == 2 && (int) $vo->getPropostaStatusID() == 2){

					$count = $ativosDAO->getCountAtivoByModalidadeID(1) + 1; // 1 = CRI
					$voPropostaDetalhe = $propostasDetalhesDAO->find($vo->getPropostaDetalheID());
					$voProposta = $propostasDAO->find($voPropostaDetalhe->getPropostaID());

					$voAtivo = new Ativos();
					$voAtivo->setAtivoCodigoSIOPM("CRI" .  str_pad($count, 4, "0", STR_PAD_LEFT));
					$voAtivo->setPropostaID($voPropostaDetalhe->getPropostaID());
					$voAtivo->setModalidadeID(1); // 1 = CRI
					$voAtivo->setAtivoTipoID(1); // 1 = CRI

					$arVO = $propAnaliseRiscoDAO->findVOByPropostaDetalheID($voPropostaDetalhe->getPropostaDetalheID());

					$voAtivo->setAtivoTaxaRiscoNominal(PPOEntity::toFloatUnicode($arVO->getPropTaxaNominal(), 8));
					$voAtivo->setAtivoDataCadastro(PPOEntity::toDateBr(date("Y-m-d H:i:s", time())));
					$voAtivo->setAtivoAtivo(1);
					$voAtivo->setAtivoID( (int) $ativosDAO->insert($voAtivo));

					if ($voAtivo->getAtivoID() > 0){
						/* Criando o cadastro da Securitizadora */
						if ($voProposta->getSecuritizadoraID() > 0){
							$voAE = new AtivosEntidades();
							$voAE->setAtivoID($voAtivo->getAtivoID());
							$voAE->setEntidadePapelID(1); // 1 = Securitizadora 
							$voAE->setEntidadeID($voProposta->getSecuritizadoraID());
							$ativoEntidadesDAO->insert($voAE);
						}

						/* Criando o cadastro do Originador */
						if ($voPropostaDetalhe->getOriginadorID() > 0){
							$voAE = new AtivosEntidades();
							$voAE->setAtivoID($voAtivo->getAtivoID());
							$voAE->setEntidadePapelID(3); // 3 = Cedente 
							$voAE->setEntidadeID($voPropostaDetalhe->getOriginadorID());
							$ativoEntidadesDAO->insert($voAE);
						}

						/* Criando o cadastro do Agente Fiduciario */
						if ($voPropostaDetalhe->getAgenteFiduciarioID() > 0){
							$voAE = new AtivosEntidades();
							$voAE->setAtivoID($voAtivo->getAtivoID());
							$voAE->setEntidadePapelID(2); // 2 = Agente Fiduciário 
							$voAE->setEntidadeID($voPropostaDetalhe->getAgenteFiduciarioID());
							$ativoEntidadesDAO->insert($voAE);
						}

						/* Criando o cadastro do Agente Coordenador Lider */
						if ($voPropostaDetalhe->getCoordenadorLiderID() > 0){
							$voAE = new AtivosEntidades();
							$voAE->setAtivoID($voAtivo->getAtivoID());
							$voAE->setEntidadePapelID(8); // 8 = Coordenador Lider 
							$voAE->setEntidadeID($voPropostaDetalhe->getCoordenadorLiderID());
							$ativoEntidadesDAO->insert($voAE);
						}

						$manifSecuritizadora = $propManifSecuritizadoraDAO->findVOByPropostaDetalheID($voPropostaDetalhe->getPropostaDetalheID());
						$manifSecuritizadoraGarantias = $propManifSecurGarantiasDAO->listByPropManifSecurID($manifSecuritizadora->getPropManifSecurID());
						
						if (isset($manifSecuritizadoraGarantias)) foreach ($manifSecuritizadoraGarantias as $msGarantias) {
							$garantia = new AtivosGarantias();
							$garantia->setAtivoID($voAtivo->getAtivoID());
							$garantia->setGarantiaID($msGarantias['GarantiaID']);
							$ativosGarantiasDAO->insert($garantia);
						}
					}else{
						$em->rollBack();
						$result = json_encode(array("resultado" => false, 
							"mensagem" => "Erro ao criar ativo!"));
						die($result);
					}

				}

				
				
				$result = json_encode(array("resultado" => true, 
					"mensagem" => "Proposta finalizada com sucesso!", "statusnome" => $status)
				);

				$em->commit();

			}catch (Exception $e){
					
				$em->rollBack();
				
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
							": Erro ao tentar finalizar proposta!", "exception" => $e->getTraceAsString())
					);

			}

			echo $result;
			break;

		case 'SALVAR_PROPOSTA_CONTATO':

			$result = validaDadosProposta($_REQUEST);
			if ($result !== true){
				echo $result;
				break;
			}

			if (isset($_REQUEST["PropostaID"]) && $_REQUEST["PropostaID"] > 0){
				try{

					$em->beginTransaction();

					$vo = $ContatosDAO->fillEntitybyRequest($_REQUEST);
					$logger->prepararLog($vo);
					$vo->setContatoID((int) $ContatosDAO->persist($vo));
					$logger->logar($vo);

					$voPC = $propContatosDAO->fillEntitybyRequest($_REQUEST);				
					
					$voPC->setContatoID($vo->getContatoID());
					$logger->prepararLog($voPC);
					$voPC->setPropostaContatoID((int)$propContatosDAO->persist($voPC));
					$logger->logar($voPC);

					$em->commit();

					$result = json_encode(array(
						"contatoid" => $vo->getContatoID(),
						"propostacontatoid" => $voPC->getPropostaContatoID(),
						"resultado" => true, 
						"mensagem" => "Dados do contato da proposta salvos com sucesso!")
					);

				}catch (Exception $e){
					
					$em->rollBack();
					
					$result = 
						json_encode(
							array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
								": Erro ao gravar dados do contato da proposta!", "exception" => $e->getTraceAsString())
						);

				}

			}else{
				$result = json_encode(array("resultado"=> false,"mensagem"=> "O ID da proposta não foi enviado corretamente!"));
			}

			echo $result;

			break;

		case 'SALVAR_PROPOSTA_MANIFESTACAO_AGENTES':

			$result = validaDadosProposta($_REQUEST);
			if ($result !== true){
				echo $result;
				break;
			}

			if (isset($_REQUEST["PropostaFaseID"])) $fase = $_REQUEST["PropostaFaseID"];

			if (!($fase == 1 or $fase == 2)){
				$result = json_encode(array("resultado"=> false,"mensagem"=> "Dados da fase não foi passado corretamente! $fase"));
			}else try{

				$em->beginTransaction();

				$idResolucao = 0;

				$voGifug = $propManifGifugDAO->fillEntitybyRequest($_REQUEST);
				
				$logger->prepararLog($voGifug);
				$voGifug->setPropManifGifugID( (int) $propManifGifugDAO->persist($voGifug));
				$logger->logar($voGifug);

				$voGefom = $propManifGefomDAO->fillEntitybyRequest($_REQUEST);
				$logger->prepararLog($voGefom);
				$voGefom->setPropManifGefomID( (int) $propManifGefomDAO->persist($voGefom));
				$logger->logar($voGefom);

				if ($fase == 2) { 
					$voResolucao = $propResolucaoDAO->fillEntitybyRequest($_REQUEST);
					$logger->prepararLog($voResolucao);
					$idResolucao = (int) $propResolucaoDAO->persist($voResolucao);					
					$logger->logar($voResolucao);
					$voResolucao->setPropResolucaoConselhoID($idResolucao);
				}

				if (isset($_REQUEST["ValorAprovadoGEFOM"]) && $_REQUEST["ValorAprovadoGEFOM"] > 0 && $_REQUEST["PropostaID"] > 0){ 
					$id = $_REQUEST["PropostaID"];
					$ValorAprovadoGEFOM = $_REQUEST["ValorAprovadoGEFOM"];
					$sql = "UPDATE tblPropostas SET ValorAprovadoGEFOM = $ValorAprovadoGEFOM WHERE PropostaID = $id";
					$propostasDAO->execute($sql);	
				}

				$result = json_encode(array(
					"propmanifgifugid" => $voGifug->getPropManifGifugID(),
					"propmanifgefomid" => $voGefom->getPropManifGefomID(),
					"propresolucaoconselhoid" => $idResolucao,
					"resultado" => true, 
					"mensagem" => "Dados da manifestação do agente operador salvos com sucesso!")
				);

				$em->commit();

			}catch (Exception $e){
					
				$em->rollBack();
				
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
							": Erro ao gravar dados da manifestação do agente operador!", "exception" => $e->getTraceAsString())
					);

			}

			echo $result;

			break;

		case 'SALVAR_PROPOSTA_ENQUADRAMENTO_ANALISE':

			$result = validaDadosProposta($_REQUEST);
			if ($result !== true){
				echo $result;
				break;
			}

			if (isset($_REQUEST["PropostaFaseID"])) $fase = $_REQUEST["PropostaFaseID"];

			if (!($fase == 1 or $fase == 2)){
				$result = json_encode(array("resultado"=> false,"mensagem"=> "Dados da fase não foi passado corretamente! $fase"));
			}else try{

				$em->beginTransaction();
				
				$arID = 0;
				$hoje = date("Y-m-d H:i:s", time()); 
				
				/* Preenche e grava a Análise Jurícida */
				$voAj = $propAnaliseJurDAO->fillEntitybyRequest($_REQUEST);
				$logger->prepararLog($voAj);
				$voAj->setPropJuridicaID((int) $propAnaliseJurDAO->persist($voAj));
				$logger->logar($voAj);
				/* Preenche e grava Aspectos cadastrais da securitizadora */
				$voPesq = $propPesqSecuritizadoraDAO->fillEntitybyRequest($_REQUEST);
				$logger->prepararLog($voPesq);
				$voPesq->setPropPesqSecurID((int) $propPesqSecuritizadoraDAO->persist($voPesq));
				$logger->logar($voPesq);

				/* Preenche e salva o enquadramenteo da proposta */
				$voEnq = $propEnquadramentosDAO->fillEntitybyRequest($_REQUEST);
				$logger->prepararLog($voEnq);
				$voEnq->setPropostaEnquadramentoID((int) $propEnquadramentosDAO->persist($voEnq));
				$logger->logar($voEnq);

				/* Apenas salva a análise de risco se etiver na etapa DEFINITIVA */	
				if ($fase == 2) {
					/* Preenche e grava a análise de risco */
					$voAr = $propAnaliseRiscoDAO->fillEntitybyRequest($_REQUEST);
					$logger->prepararLog($voAr);
					$arID = (int) $propAnaliseRiscoDAO->persist($voAr);
					$logger->logar($voAr);
					$voAr->setPropRiscoID($arID);
				}

				$result = json_encode(array(
					"propenquadramentoid" => $voEnq->getPropostaEnquadramentoID(),
					"proppesqsecurid" => $voPesq->getPropPesqSecurID(),
					"propjuridicaid" => $voAj->getPropJuridicaID(),
					"propriscoid" => $arID,
					"resultado"=> true, 
					"mensagem"=> "Dados do enquadramento e análise salvos com sucesso!")
				);

				$em->commit();

			}catch (Exception $e){
					
				$em->rollBack();
				
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
							": Erro ao gravar dados do enquadramento e análise!", "exception" => $e->getTraceAsString())
					);

			}

			echo $result;

			break;

		case 'SALVAR_PROPOSTA_DADOS_BASICOS':

			$result = validaDadosProposta($_REQUEST);
			if ($result !== true){
				echo $result;
				break;
			}

			$vo =  new Propostas();
			$voDet = new PropostasDetalhes();

			$vo 	= $propostasDAO->fillEntitybyRequest($_REQUEST);
			$voDet 	= $propostasDetalhesDAO->fillEntitybyRequest($_REQUEST);

			$count 	= $propostasDAO->getCountPropostaByOrcamentoID( $vo->getOrcamentoID() ) + 1;
			$ano 	= $orcamentoDAO->getOrcamentoAnoByID($vo->getOrcamentoID());
			$numprop = str_pad($count, 3, "0", STR_PAD_LEFT) . "/" . $ano;

			if (isset($_REQUEST["PropostaFaseID"])) $fase = $_REQUEST["PropostaFaseID"];

			if (!($fase == 1 or $fase == 2)){
				$result = json_encode(array("resultado"=> false,"mensagem"=> "Dados da fase não foi passado corretamente! $fase"));
			}else try{

				$em->beginTransaction();

				if (!(int) $vo->getPropostaID() > 0) {
					$vo->setPropostaNumero($numprop);
				}

				$logger->prepararLog($vo);
				$vo->setPropostaID((int)$propostasDAO->persist($vo, null, true));
				$logger->logar($vo);
				
				$hoje = date("Y-m-d H:i:s", time());
				
				$voDet->setPropostaFaseID($fase);

				if (!(int) $voDet->getPropostaDetalheID()>0) {
					$voDet->setPropostaStatusID(1);
				}

				$valorSeniorMaior = false;
				if ($_REQUEST["ValorCRISenior"] > $_REQUEST["ValorAprovadoGEFOM"])$valorSeniorMaior = true;

				if ($_REQUEST["QuantidadeSenior"] > 0){

					$ValorUnitarioSenior = $_REQUEST["ValorCRISenior"] / $_REQUEST["QuantidadeSenior"];
					
					$voDet->setPropostaID($vo->getPropostaID());
					$voDet->setValorUnitarioSenior($ValorUnitarioSenior);
					$logger->prepararLog($voDet);
					$voDet->setPropostaDetalheID((int)$propostasDetalhesDAO->persist($voDet, null, true));
					$logger->logar($voDet);
					$em->commit();
					

					$result = json_encode(array(
						"propostaid" 		 	=> $vo->getPropostaID(),
						"propostadetalheid"  	=> $voDet->getPropostaDetalheID(),
						"propostanumero" 	 	=> $vo->getPropostaNumero(),
						"resultado"			 	=> true,
						"valorseniormaior"   	=> $valorSeniorMaior,
						"valorunitariosenior"	=> PPOEntity::toMoneyBr($ValorUnitarioSenior),
						"mensagem"			 	=> "Dados básicos salvos com sucesso!")
					);
				}else{
					$result = json_encode(array("resultado"=> false, "mensagem" => "A quantidade de CRI Sênior deve ser maior que ZERO."));
				}	
			
			}catch (Exception $e){
					
				$em->rollBack();
				
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
							": Erro ao gravar dados do contato!", "exception" => $e->getTraceAsString())
					);

			}

			echo $result;

			break;

		case 'SALVAR_MANIFESTACAO_SECURITIZADORA':

			if (isset($_REQUEST["PropostaFaseID"])) $fase = $_REQUEST["PropostaFaseID"];
			
			$result = validaDadosProposta($_REQUEST);
			if ($result !== true){
				echo $result;
				break;
			}

			if (!($fase == 1 or $fase == 2)){
				$result = json_encode(array("resultado"=> false,"mensagem"=> "Dados da fase não foi passado corretamente! $fase"));
			}else try{

				$em->beginTransaction();

				$PropManifSecurID = $_REQUEST['PropManifSecurID']; 

				if ($PropManifSecurID > 0) $propManifSecurGarantiasDAO->deleteByPropManifSecurID($PropManifSecurID);
				
				$vo = $propManifSecuritizadoraDAO->fillEntitybyRequest($_REQUEST);
				$logger->prepararLog($vo);
				$vo->setPropManifSecurID((int) $propManifSecuritizadoraDAO->persist($vo));
				$logger->logar($vo);

				$garantias = $garantiasDAO->listAll();

				if ($vo->getPropManifSecurID()> 0) $propManifSecurGarantiasDAO->execute("DELETE FROM tblPropManifSecurGarantias WHERE PropManifSecurID = :propmanifsecurid", array(":propmanifsecurid" => $vo->getPropManifSecurID()));

				foreach($garantias as $garantia) {
					if (isset($_REQUEST[$garantia["GarantiaID"]])){
						$voGarantias = New PropostasManifSecurGarantias();
						$voGarantias->setPropManifSecurID((int)$vo->getPropManifSecurID());
						$voGarantias->setGarantiaID($garantia["GarantiaID"]);
						$propManifSecurGarantiasDAO->persist($voGarantias);
					}
				} 	

				$result = json_encode(array(
					"propmanifsecurid" => $vo->getPropManifSecurID(),
					"resultado" => true, 
					"mensagem" => "Dados da manifestação da securitizadora salvos com sucesso!")
				);

				$em->commit();

			}catch (Exception $e){
					
				$em->rollBack();
				
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
							": Erro ao gravar dados do enquadramento e análise!", "exception" => $e->getTraceAsString())
					);

			}

			echo $result;

			break;	
		
		case 'EXCLUIR_PROPOSTA':

			if (isset($_REQUEST["PropostaID"]) && $_REQUEST["PropostaID"] > 0){

				$id = $_REQUEST["PropostaID"];
				
				try{

					$em->beginTransaction();

					$vo = $propostasDAO->find($id);
					$logger->prepararLog($vo);				
					$vo->setPropostaAtiva(0);
					$propostasDAO->update($vo);
					$logger->logar($vo);
					//$propostasDAO->execute("UPDATE tblPropostas SET PropostaAtiva = 0 WHERE PropostaID = $id");
					
					$em->commit();

					$result = json_encode(array("resultado" => true, "mensagem" => "Proposta excluída com sucesso!"));

				}catch (Exception $e){

					$em->rollBack();
					$result = 
						json_encode(
							array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
								": Erro ao excluir proposta $id!", "exception" => $e->getTraceAsString()
							)
						);
				}

			}else{
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
							": Identificador da proposta não enviado. Erro ao tentar excluir.", "exception" => $e->getTraceAsString()
						)
					);
			}
			
			
			echo $result;

			break;

		case 'EXCLUIR_PROPOSTA_CONTATO':

			if (isset($_REQUEST["PropostaContatoID"]) && $_REQUEST["PropostaContatoID"] > 0){
				
				try{

					$em->beginTransaction();

					$voPC = $propContatosDAO->find($_REQUEST["PropostaContatoID"]);
					$voC = $ContatosDAO->find($voPC->getContatoID());
					$ContatosDAO->delete($voPC);
					$propContatosDAO->delete($voPC);

					$em->commit();

					$result = json_encode(array("resultado" => true, "mensagem" => "Contato excluído com sucesso!"));

				}catch (Exception $e){

					$em->rollBack();
					$result = 
						json_encode(
							array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
								": Erro ao excluir contato!", "exception" => $e->getTraceAsString()
							)
						);
				}

			}else{
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
							": Identificador da proposta não enviado. Erro ao tentar excluir.", "exception" => $e->getTraceAsString()
						)
					);
			}
			
			
			echo $result;

			break;

		case 'ATUALIZAR_PROPOSTA_ERROS':

			$PropostaID = 0;
			
			if (isset($_REQUEST["PropostaDetalheID"]) && $_REQUEST["PropostaDetalheID"] > 0) $PropostaID = $_REQUEST["PropostaDetalheID"];
			
			$htmlTabelaErrosProposta = $propMsgErroDAO->criahtmlTabelaErrosProposta($PropostaID);

			echo $htmlTabelaErrosProposta;
			
			break;

		case 'EDITAR_PROPOSTA_FINALIZACAO':	

			if (isset($_REQUEST["PropostaDetalheID"]) && $_REQUEST["PropostaDetalheID"] > 0) {

				$proposta 		= $propostasDAO->findArrayByPropostaDetalheID($_REQUEST["PropostaDetalheID"]);
				$status 		= $propostasStatusDAO->listFinalizacoes();

				$inconsistencias = $propMsgErroDAO->listInconsistenciasProposta($_REQUEST["PropostaDetalheID"]);

				if (isset($proposta["PropostaFaseID"]) && $proposta["PropostaFaseID"] == 2) {
					$fase = "2";
					$titulo_form .= " Definitiva ";
				}else{
					$fase = "1";
					$titulo_form .= " Preliminar ";
				}

				$titulo_form .= " - Finalização";
				require $siopm->getForm('proposta.cri.finalizacao');

			} else {
				echo $siopm->getErrorModal("Não foi passado o id de detalhe da proposta corretamente");
			}

			break;

		default:
		
			if (isset($_REQUEST['ac'])){
				$post_acao = $_REQUEST['ac'];
				if (!in_array($post_acao, array('list', 'listp', 'listd', 'editfz','editdb', 'editma', 'editea', 'editms', 'fnlz', 'savemg', 'savemge', 'saveea', 'savedb', 'savems', 'delete'))) {
					echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' 
						. basename(__FILE__) . ': O campo "ação" não foi indicado corretamente.'));
					exit;
				}
			} else echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': POST AC NAO DEFINIDO.'));
			break;
	}

	function validaDadosProposta($post){


		if (isset($post['DataRecepcao']) && date("Y-m-d", time()) < PPOEntity::toDateBr($post['DataRecepcao'], "Y-m-d")) 
			return json_encode(array("resultado" => false, 
			"mensagem"=>'A data da Recepção não deve ser uma data futura.'));

		if (isset($post['CRFValidade']) && strtotime(PPOEntity::toDateBr($post['DataRecepcao'], "Y-m-d")) > 
			strtotime(PPOEntity::toDateBr($post['CRFValidade'], "Y-m-d"))) 
			return json_encode(array("resultado" => false, 
			"mensagem"=>'A data da Recepção não deve ser maior que a data de validade do CRF.'));
		
		if (isset($post['CADINDataPesquisa']) && strtotime(PPOEntity::toDateBr($post['DataRecepcao'], "Y-m-d")) > 
			strtotime(PPOEntity::toDateBr($post['CADINDataPesquisa'], "Y-m-d"))) 
			return json_encode(array("resultado" => false, 
			"mensagem"=>'A data da Recepção não deve ser maior que a data de pesquisa do CADIN.'));

		if (isset($post['ValorCRISenior']) && isset($post['ValorSubordinado']) && isset($post['ValorGlobalProposta'])){
			if ($post['ValorGlobalProposta'] != ($post['ValorCRISenior']) ){
				return json_encode(array("resultado" => false, 
					"mensagem"=>'O Valor Global da Proposta não poder diferir do Valor do CRI (Sênior)'));
			}
		}

		if (isset($post['PrazoAmortizacao']) && !$post['PrazoAmortizacao']>0){
			return json_encode(array("resultado" => false, 
				"mensagem"=>'O Prazo de amortização (Sênior) não foi informado corretamente.'));
		}
		

		if (isset($post['PropRiscoData']) && $post['PropRiscoData'] > 0 && strtotime(PPOEntity::toDateBr($post['DataRecepcao'], "Y-m-d")) > 
			strtotime(PPOEntity::toDateBr($post['PropRiscoData'], "Y-m-d"))) 
			return json_encode(array("resultado" => false, 
			"mensagem"=>'A data da Recepção não deve ser maior que a data da Análise Jurídica.'));

		if (isset($post['PropJuridicaData']) && $post['PropJuridicaData'] > 0 && strtotime(PPOEntity::toDateBr($post['DataRecepcao'], "Y-m-d")) > 
			strtotime(PPOEntity::toDateBr($post['PropJuridicaData'], "Y-m-d"))) 
			return json_encode(array("resultado" => false, 
			"mensagem"=>'A data da Recepção não deve ser maior que a data da Análise Jurídica.'));


		if (isset($post['DataConclusaoManifSecuritizadora']) && $post['DataConclusaoManifSecuritizadora'] > 0 && strtotime(PPOEntity::toDateBr($post['DataRecepcao'], "Y-m-d")) > 
			strtotime(PPOEntity::toDateBr($post['DataConclusaoManifSecuritizadora'], "Y-m-d"))) 
			return json_encode(array("resultado" => false, 
			"mensagem"=>'A data da Recepção não deve ser maior que a data da Manifestação da Securitizadora.'));

		if (isset($post['ManifGifugData']) && $post['ManifGifugData'] > 0 && strtotime(PPOEntity::toDateBr($post['DataRecepcao'], "Y-m-d")) > 
			strtotime(PPOEntity::toDateBr($post['ManifGifugData'], "Y-m-d"))) 
			return json_encode(array("resultado" => false, 
			"mensagem"=>'A data da Recepção não deve ser maior que a data da Manifestação da GIFUG.'));

		if (isset($post['ManifGefomData']) && $post['ManifGefomData'] > 0 && strtotime(PPOEntity::toDateBr($post['DataRecepcao'], "Y-m-d")) > 
			strtotime(PPOEntity::toDateBr($post['ManifGefomData'], "Y-m-d"))) 
			return json_encode(array("resultado" => false, 
			"mensagem"=>'A data da Recepção não deve ser maior que a data da Manifestação da VIFUG.'));

		return true;
	}

?>
