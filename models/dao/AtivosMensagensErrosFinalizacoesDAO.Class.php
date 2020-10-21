<?php 
	
	class AtivosMensagensErrosFinalizacoesDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "AtivosMensagensErrosFinalizacoes");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblAtivosMensagensErrosFinalizacoes";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listAllAtivos(){
			$sql = "SELECT * FROM tblAtivosMensagensErrosFinalizacoes WHERE TesteCampoAtivo = 1 ORDER BY  NomeJanelaLocal, Aba";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		private function isEmptyVal($val){
			if ((!isset($val) || $val == "" || $val == null) ) return true; else return false;  
		}

		private function geraErroArray($ativoID, $campoID, $campoNome, $acao, $local, $aba, $abaID, $msgErro = ""){ 
			return array("AtivoID" => $ativoID, "CampoID" => $campoID,	"Acao" => $acao, "Local" => $local, "Aba" => $aba, "AbaID" => $abaID, "Campo" => $campoNome, "MsgErro" => $msgErro);		
		}

		public function listInconsistenciasAtivo($ativoID){

			/* Declaraçãod e variáveis */
			$erros 						= array();
			$objetos	 				= array();
			$ativosDAO					= new AtivosDAO(parent::getEm());
			$ativosRegistrosDAO			= new AtivosRegistrosDAO(parent::getEm());
			$ativosEntidadesDAO			= new AtivosEntidadesDAO(parent::getEm());
			$ativosArquivosDAO			= new AtivosArquivosDAO(parent::getEm());

			$ativo 						= $ativosDAO->find($ativoID);
			$ativosRegistros 			= $ativosRegistrosDAO->findbByAtivoID($ativoID);

			/* Preencher vetor de objetos */
			$objetos['tblAtivos'] = $ativo;
			$objetos['tblAtivosRegistros'] = $ativosRegistros;
			$msgErroCampos = $this->listAllAtivos(); 

			if (isset($msgErroCampos)) foreach($msgErroCampos as $e){

								
				if($e['CampoTipoTeste'] == "PERSONALIZADO"){

					
					if ($e["CampoID"] == "AtivoCodigoCetip"){

						if ($ativo->getAtivoCodigoCetip() == "" && $ativo->getAtivoCodigoBmfBovespa () == ""){
							$erros[] = $this->geraErroArray($ativoID, $e["CampoID"], $e["CampoNome"], $e["ControllerAcao"], $e["NomeJanelaLocal"], $e["Aba"], $e["AbaID"], $e["MensagemErroPadrao"]);
						}
						
					}

					if ($e["CampoID"] == "AtivoEntidadeID"){

						if (!$ativosEntidadesDAO->hasEmissor($ativoID)){
								$erros[] = $this->geraErroArray($ativoID, $e["CampoID"], $e["CampoNome"], $e["ControllerAcao"], $e["NomeJanelaLocal"], $e["Aba"], $e["AbaID"], $e["MensagemErroPadrao"]);
						}
					}

					if ($e["CampoID"] == "AtivoArquivoID2"){

						if (!$ativosArquivosDAO->hasBoletim($ativoID)){
								$erros[] = $this->geraErroArray($ativoID, $e["CampoID"], $e["CampoNome"], $e["ControllerAcao"], $e["NomeJanelaLocal"], $e["Aba"], $e["AbaID"], $e["MensagemErroPadrao"]);
						}

					}

				}
				
				if($e['CampoTipoTeste'] == "SE_VAZIO"){
					eval("\$value = \$objetos[\"" . $e["TabelaID"] . "\"]->get" . $e["CampoID"] . "();");
					if ($this->isEmptyVal($value)){ 
						$erros[] = $this->geraErroArray($ativoID, $e["CampoID"], $e["CampoNome"], $e["ControllerAcao"], $e["NomeJanelaLocal"], $e["Aba"], $e["AbaID"], $e["MensagemErroPadrao"]);
					}
				}

				if($e['CampoTipoTeste'] == "MAIOR_ZERO"){
					eval("\$value = \$objetos[\"" . $e["TabelaID"] . "\"]->get" . $e["CampoID"] . "();");
					if (!($value>0)){ 
						$erros[] = $this->geraErroArray($ativoID, $e["CampoID"], $e["CampoNome"], $e["ControllerAcao"], $e["NomeJanelaLocal"], $e["Aba"], $e["AbaID"], $e["MensagemErroPadrao"]);
					}
				}

				if($e['CampoTipoTeste'] == "MAIOR_IGUAL_ZERO"){
					eval("\$value = \$objetos[\"" . $e["TabelaID"] . "\"]->get" . $e["CampoID"] . "();");
					if (!($value>=0)){ 
						$erros[] = $this->geraErroArray($ativoID, $e["CampoID"], $e["CampoNome"], $e["ControllerAcao"], $e["NomeJanelaLocal"], $e["Aba"], $e["AbaID"], $e["MensagemErroPadrao"]);
					}
				}

				if($e['CampoTipoTeste'] == "VERDADEIRO"){
					eval("\$value = \$objetos[\"" . $e["TabelaID"] . "\"]->get" . $e["CampoID"] . "();");
					if ($value != 1 ){ 
						$erros[] = $this->geraErroArray($ativoID, $e["CampoID"], $e["CampoNome"], $e["ControllerAcao"], $e["NomeJanelaLocal"], $e["Aba"], $e["AbaID"], $e["MensagemErroPadrao"]);
					}
				}			

			}

			return $erros;

		}

	}

?>