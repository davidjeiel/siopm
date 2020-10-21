<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/PropostasMensagensErrosFinalizacoes.Class.php';

	class PropostasMensagensErrosFinalizacoesDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "PropostasMensagensErrosFinalizacoes");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblPropostasMensagensErrosFinalizacoes";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listAllAtivos(){
			$sql = "SELECT * FROM tblPropostasMensagensErrosFinalizacoes WHERE TesteCampoAtivo = 1 ORDER BY NomeJanelaLocal, Aba";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		private function isEmptyVal($val){
			if ((!isset($val) || $val == "" || $val == null) ) return true; else return false;  
		}

		private function geraErroArray($propostaID, $propostaDetalheID, $campoID, $campoNome, $acao, $local, $aba, $abaID, $msgErro = ""){ 
			return array("PropostaID" => $propostaID, "PropostaDetalheID" => $propostaDetalheID, "CampoID" => $campoID,	"Acao" => $acao, "Local" => $local, "Aba" => $aba, "AbaID" => $abaID, "Campo" => $campoNome, "MsgErro" => $msgErro);		
		}

		public function listInconsistenciasProposta($propostaDetalheID){

			/* Declaraçãod e variáveis */
			$erros 						= array();
			$objetos	 				= array();
			$entidadesDAO 				= new EntidadesDAO(parent::getEm());
			$propostasDAO 				= new PropostasDAO(parent::getEm());
			$propostasDetalhesDAO 		= new PropostasDetalhesDAO(parent::getEm());
			$propEnquadramentoDAO		= new PropostasEnquadramentosDAO(parent::getEm());
			$pesquisaSecurDAO			= new PropostasPesquisasSecuritizadoraDAO(parent::getEm());
			$analisesJuridicasDAO		= new PropostasAnalisesJuridicasDAO(parent::getEm());
			$propManifSecuritizadoraDAO	= new PropostasManifSecuritizadorasDAO(parent::getEm());
			$propManifSecurGarantiasDAO	= new PropostasManifSecurGarantiasDAO(parent::getEm());
			$propAnaliseRiscoDAO 		= new PropostasAnalisesRiscosDAO(parent::getEm());
			$propConfigDAO				= new PropostasConfigDAO(parent::getEm());
			$propostasFaixasDAO 		= new PropostasFaixasDAO(parent::getEm());

			$propManifGifugDAO			= new PropostasManifGifugDAO(parent::getEm());
			$propManifGefomDAO			= new PropostasManifGefomDAO(parent::getEm());
			$propResolucaoDAO			= new PropostasResolucoesDAO(parent::getEm());

			/* Inicialização DAO'S*/
			$propostaDetalhe		= $propostasDetalhesDAO->find($propostaDetalheID);
			$proposta 				= $propostasDAO->find($propostaDetalhe->getPropostaID());

			$propConfig 			= $propConfigDAO->getAtivo();
			$propFaixa 				= $propostasFaixasDAO->find($proposta->getPropostaFaixaID());	
			$pesquisaSecuritizadora	= $pesquisaSecurDAO->findVOByPropostaDetalheID($propostaDetalhe->getPropostaDetalheID());
			$propEnquadramento 		= $propEnquadramentoDAO->findVOByPropostaDetalheID($propostaDetalhe->getPropostaDetalheID());
			$analisesJuridicas 		= $analisesJuridicasDAO->findVOByPropostaDetalheID($propostaDetalhe->getPropostaDetalheID());
			$analisesRiscos 		= $propAnaliseRiscoDAO->findVOByPropostaDetalheID($propostaDetalhe->getPropostaDetalheID());

			$propManifSecuritizadora = $propManifSecuritizadoraDAO->findVOByPropostaDetalheID($propostaDetalhe->getPropostaDetalheID());

			$propManifGifug 		= $propManifGifugDAO->findVOByPropostaDetalheID($propostaDetalhe->getPropostaDetalheID());
			$propManifGefom 		= $propManifGefomDAO->findVOByPropostaDetalheID($propostaDetalhe->getPropostaDetalheID());
			$propResolucao 			= $propResolucaoDAO->findVOByPropostaDetalheID($propostaDetalhe->getPropostaDetalheID());

			/* Preencher vetor de objetos */
			$objetos['tblPropostas'] = $proposta;
			$objetos['tblPropostasDetalhes'] = $propostaDetalhe;
			$objetos['tblPropostasPesquisasSecuritizadora'] = $pesquisaSecuritizadora;
			$objetos['tblPropostasAnalisesJuridicas'] = $analisesJuridicas;
			$objetos['tblPropostasEnquadramentos'] = $propEnquadramento;
			$objetos['tblPropostasManifSecuritizadoras'] = $propManifSecuritizadora;
			$objetos['tblPropostasManifGifug'] = $propManifGifug;
			$objetos['tblPropostasManifGefom'] = $propManifGefom;
			$objetos['tblPropostasResolucoes'] = $propResolucao;
			$objetos['tblPropostasAnalisesRiscos'] = $analisesRiscos;

			/* ###### Temporáriamente zerar objetos para provocar errors ##### */
			// $objetos['tblPropostas'] = new Propostas();
			// $objetos['tblPropostasDetalhes'] = new PropostasDetalhes();
			// $objetos['tblPropostasPesquisasSecuritizadora'] = new PropostasPesquisasSecuritizadora();
			// $objetos['tblPropostasAnalisesJuridicas'] = new PropostasAnalisesJuridicas();
			// $objetos['tblPropostasEnquadramentos'] = new PropostasEnquadramentos();
			// $objetos['tblPropostasManifSecuritizadoras'] = new PropostasManifSecuritizadoras();
			// $objetos['tblPropostasManifGifug'] = new PropostasManifGifug();
			// $objetos['tblPropostasManifGefom'] = new PropostasManifGefom();
			// $objetos['tblPropostasResolucoes'] = new PropostasResolucoes();
			// $objetos['tblPropostasAnalisesRiscos'] = new PropostasAnalisesRiscos();
		


			/* Consulta e atualiza os STATUS da Securitizadora */
			if ($proposta->getSecuritizadoraID() > 0 ){
				$securitizadora = $entidadesDAO->getEntidadeArrayByEntidadeID($proposta->getSecuritizadoraID());
				$proposta->setSecuritizadoraStatus($securitizadora['StatusHabilitacao']);
				$proposta->setSecuritizadoraRating($securitizadora['HabilitacaoRating']);
				$proposta->setSecuritizadoraValidade($securitizadora['HabilitacaoValidade']);
				$propostasDAO->update($proposta, null, true );
			}

			/* Consulta e atualiza os STATUS do Agente fiduciário */
			if ($propostaDetalhe->getAgenteFiduciarioID() > 0 ){
				$agente = $entidadesDAO->getEntidadeArrayByEntidadeID($propostaDetalhe->getAgenteFiduciarioID());
				$propostaDetalhe->setAgenteFiduciarioStatus($agente['StatusHabilitacao']);
				$propostaDetalhe->setAgenteFiduciarioRating($agente['HabilitacaoRating']);
				$propostaDetalhe->setAgenteFiduciarioValidade($agente['HabilitacaoValidade']);
				$propostasDetalhesDAO->update($propostaDetalhe, null, true );
			}


			$msgErroCampos = $this->listAllAtivos(); 

			if (isset($msgErroCampos)) foreach($msgErroCampos as $e){

				//if ($e["ControllerAcao"] == "editfz")
				if ($e["PropostaFaseID"] == 0 || $e["PropostaFaseID"] == $propostaDetalhe->getPropostaFaseID()){

					if($e['CampoTipoTeste'] == "PERSONALIZADO"){

						/* Teste do campo STATUS SECURITIZADORA */
						if ($e["CampoID"] == "SecuritizadoraStatus"){
							if (!isset($securitizadora["StatusHabilitacao"]) || $securitizadora['StatusHabilitacao'] == "Não Habilitado"  || $securitizadora['StatusHabilitacao'] == "Vencida" ) {
								$erros[] = $this->geraErroArray($proposta->getPropostaID(), $propostaDetalheID, $e["CampoID"], $e["CampoNome"], $e["ControllerAcao"], $e["NomeJanelaLocal"], $e["Aba"], $e["AbaID"], $e["MensagemErroPadrao"]);
							}
						}

						/* Teste do campo STATUS AGENTE FIDUCIARIO */
						if ($e["CampoID"] == "AgenteFiduciarioStatus"){							
							if (!isset($agente["StatusHabilitacao"]) || $agente['StatusHabilitacao'] == "Não Habilitado" || $agente['StatusHabilitacao'] == "Vencida"  ) {
								$erros[] = 
									$this->geraErroArray($proposta->getPropostaID(), 
									$propostaDetalheID, 
									$e["CampoID"], 
									$e["CampoNome"], 
									$e["ControllerAcao"], 
									$e["NomeJanelaLocal"], 
									$e["Aba"], 
									$e["AbaID"], 
									$e["MensagemErroPadrao"]);
							}
						}

						/* Teste do campo Garantia */
						if ($e["CampoID"] == "GarantiaID"){
							if (!$propManifSecurGarantiasDAO->existeGarantias($propManifSecuritizadora->getPropManifSecurID())) {
								$erros[] = $this->geraErroArray($proposta->getPropostaID(), $propostaDetalheID, $e["CampoID"], $e["CampoNome"], $e["ControllerAcao"], $e["NomeJanelaLocal"], $e["Aba"], $e["AbaID"], $e["MensagemErroPadrao"]);
							}
						}

						if ($e["CampoID"] == "ValorMaximo"){
							eval("\$value = \$objetos[\"" . $e["TabelaID"] . "\"]->get" . $e["CampoID"] . "();");
							if ($value > $propFaixa->getValorMaximo()) { 
								$erros[] = $this->geraErroArray($proposta->getPropostaID(), 
									$propostaDetalheID, $e["CampoID"], $e["CampoNome"], 
									$e["ControllerAcao"], $e["NomeJanelaLocal"], 
									$e["Aba"], $e["AbaID"], 
									"O Valor máximo digitado de <strong> R$ " . PPOEntity::toMoneyBr($value) . 
									" </strong>excedeu o valor máximo permitido para a faixa que é de <strong>" 
										. PPOEntity::toMoneyBr($propFaixa->getValorMaximo()) . "</strong>") ;
							}
						}

						if ($e["CampoID"] == "ValorMinimo"){
							eval("\$value = \$objetos[\"" . $e["TabelaID"] . "\"]->get" . $e["CampoID"] . "();");
							if ($value < $propFaixa->getValorMinimo()) { 
								$erros[] = $this->geraErroArray($proposta->getPropostaID(), 
									$propostaDetalheID, $e["CampoID"], $e["CampoNome"], 
									$e["ControllerAcao"], $e["NomeJanelaLocal"], 
									$e["Aba"], $e["AbaID"], 
									"O Valor mínimo de <strong> R$ " . PPOEntity::toMoneyBr($value) . 
									"</strong> é inferior ao valor mínimo permitido para a faixa de <strong>" 
										. PPOEntity::toMoneyBr($propFaixa->getValorMinimo()) . "</strong>");
							}
						}

						if ($e["CampoID"] == "PrazoMaximo"){
							eval("\$value = \$objetos[\"" . $e["TabelaID"] . "\"]->get" . $e["CampoID"] . "();");
							if ($value > $propConfig->getPrazoMaximoPermitido()) { 
								$erros[] = $this->geraErroArray($proposta->getPropostaID(), 
									$propostaDetalheID, $e["CampoID"], $e["CampoNome"], 
									$e["ControllerAcao"], $e["NomeJanelaLocal"], 
									$e["Aba"], $e["AbaID"], 
									"O prazo máximo de <strong>" . $value . 
									"</strong> excedeu o valor máximo permitido para a proposta de <strong>" 
										. $propConfig->getPrazoMaximoPermitido() . "</strong>");
							}
						}

					}

					if($e['CampoTipoTeste'] == "SE_VAZIO"){
						eval("\$value = \$objetos[\"" . $e["TabelaID"] . "\"]->get" . $e["CampoID"] . "();");
						if ($this->isEmptyVal($value)){ 
							$erros[] = $this->geraErroArray($proposta->getPropostaID(), $propostaDetalheID, $e["CampoID"], $e["CampoNome"], $e["ControllerAcao"], $e["NomeJanelaLocal"], $e["Aba"], $e["AbaID"], $e["MensagemErroPadrao"]);
						}
					}

					if($e['CampoTipoTeste'] == "MAIOR_ZERO"){
						eval("\$value = \$objetos[\"" . $e["TabelaID"] . "\"]->get" . $e["CampoID"] . "();");
						if (!($value>0)){ 
							$erros[] = $this->geraErroArray($proposta->getPropostaID(), $propostaDetalheID, $e["CampoID"], $e["CampoNome"], $e["ControllerAcao"], $e["NomeJanelaLocal"], $e["Aba"], $e["AbaID"], $e["MensagemErroPadrao"]);
						}
					}

					if($e['CampoTipoTeste'] == "MAIOR_IGUAL_ZERO"){
						eval("\$value = \$objetos[\"" . $e["TabelaID"] . "\"]->get" . $e["CampoID"] . "();");
						if (!($value>=0)){ 
							$erros[] = $this->geraErroArray($proposta->getPropostaID(), $propostaDetalheID, $e["CampoID"], $e["CampoNome"], $e["ControllerAcao"], $e["NomeJanelaLocal"], $e["Aba"], $e["AbaID"], $e["MensagemErroPadrao"]);
						}
					}

					if($e['CampoTipoTeste'] == "VERDADEIRO"){
						eval("\$value = \$objetos[\"" . $e["TabelaID"] . "\"]->get" . $e["CampoID"] . "();");
						if ($value != 1 ){ 
							$erros[] = $this->geraErroArray($proposta->getPropostaID(), $propostaDetalheID, $e["CampoID"], $e["CampoNome"], $e["ControllerAcao"], $e["NomeJanelaLocal"], $e["Aba"], $e["AbaID"], $e["MensagemErroPadrao"]);
						}
					}

				}

			}

			return $erros;

		}

	}

?>