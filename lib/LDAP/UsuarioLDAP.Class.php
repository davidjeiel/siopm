<?php
	
	class UsuarioLDAP {
		
		private $objLDAP = null;
		private $json = null;
		//private $usuario_matricula = null;
		
		public function __construct($matricula = ""){
		
			$vetorUsr = explode("\\",$_SERVER["LOGON_USER"]);
			if ($matricula == '') $matricula = $vetorUsr[1];
			//$this->usuario_matricula = $matricula;
			try {
				// Does file_get_contents() have a timeout setting?
				// http://stackoverflow.com/questions/10236166/does-file-get-contents-have-a-timeout-setting#10236480
				$ctx = stream_context_create(array('http'=>
					array(
						'timeout' => 15, // in seconds
					)
				));

				// ATENÇÃO - DESABILITADO //
				//$this->json = @file_get_contents('http://gifugbu.sp.caixa/api/user.php?matricula=' . $this->usuario_matricula, false, $ctx);

				// A API da GIFUGSP parou de funcionar. (Hugo Alves Richard - 20180622)
				//$this->json = @file_get_contents('http://www.gifugsp.sp.caixa/api/consultaUsuario.php?matricula=' . $matricula, false, $ctx);

				// Como paleativo, retornei a consulta para a API da GIFUGBU. (Hugo Alves Richard - 20180622)
				$this->json = @file_get_contents('http://gifugbu.sp.caixa/api/user.php?matricula=' . $matricula, false, $ctx);

				if( $this->json === false ) return;
				$this->objLDAP = json_decode($this->json);

				return true;

			} catch(Exception $e){
				throw new Exception("ERRO UsuarioLDAP.Class: Não foi possível obter os dados do usuário.");
			}

		}
		
		public function getDominio(){
			if( $this->json === false ) return "";
			return $this->objLDAP->{'dominio'};
		}
		
		public function getMatricula(){
			if( $this->json === false ) return "";
			return $this->objLDAP->{'matricula'}; 
		}
		
		public function getDV(){
			if( $this->json === false ) return "";
			return $this->objLDAP->{'dv'}; 
		}
		
		public function getNome(){
			if( $this->json === false ) return "";
			return $this->objLDAP->{'nome'}; 
		}
		
		public function getSobrenome(){
			if( $this->json === false ) return "";
			return $this->objLDAP->{'sobrenome'}; 
		}
		
		public function getNomeCompleto(){
			if( $this->json === false ) return "";
			return $this->objLDAP->{'nomeCompleto'}; 
		}
		
		public function getApelido(){
			if( $this->json === false ) return "";
			return $this->objLDAP->{'apelido'}; 
		}
		
		public function getEmail(){
			if( $this->json === false ) return "";
			return $this->objLDAP->{'email'}; 
		}
		
		public function contaAtiva(){
			if( $this->json === false ) return "";
			return $this->objLDAP->{'contaAtiva'}; 
		}
		
		public function getCargo(){
			if( $this->json === false ) return "";
			return $this->objLDAP->{'cargo'}; 
		}
		
		public function getIdFuncao(){
			if( $this->json === false ) return "";
			return $this->objLDAP->{'idFuncao'}; 
		}
		
		public function getFuncao(){
			if( $this->json === false ) return "";
			return $this->objLDAP->{'funcao'}; 
		}
		
		public function getPerfilRH(){
			if( $this->json === false ) return "";
			return $this->objLDAP->{'perfilRH'}; 
		}

		public function getUnidade(){
			if( $this->json === false ) return "";
			return $this->objLDAP->{'unidade'}; 

		}
		
		public function getLotacaoFisica(){
			if( $this->json === false ) return "";
			return $this->objLDAP->{'lotacaoFisica'}; 
		}
		
		public function getTelefoneComercial1(){
			if( $this->json === false ) return "";
			return $this->objLDAP->{'numComercial1'}; 
		}
		
		public function getTelefoneComercial2(){
			if( $this->json === false ) return "";
			return $this->objLDAP->{'numComercial2'}; 
		}
		
		public function getFax(){
			if( $this->json === false ) return "";
			return $this->objLDAP->{'numFax'}; 
		}
		
		public function getTelefoneResidencial(){
			if( $this->json === false ) return "";
			return $this->objLDAP->{'numResidencial'};
		}
		
		public function getTelefoneCelular(){
			if( $this->json === false ) return "";
			return $this->objLDAP->{'numCelular'};
		}
		
		public function getJSON(){
			if( $this->json === false ) return "";
			return $this->json;
		}
	
	}
	
?>