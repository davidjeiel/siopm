<?php

	class UsuariosDAO extends GenericDAO{
			
		public function listAllUserAtivos(){

			$sql = "SELECT tblUsuarios.UsuarioMatricula, tblUsuarios.UnidadeID, tblUsuarios.PerfilID, 
				tblUsuarios.UsuarioNome, tblUsuarios.UsuarioMatriculaResponsavel, tblUsuarios.UsuarioAtivo, 
				tblUsuarios.UsuarioDataCadastro, tblPerfis.PerfilNome, tblPerfis.PerfilDescricao, tblUnidades.UnidadeNome
			FROM tblUsuarios INNER JOIN
               tblPerfis ON tblUsuarios.PerfilID = tblPerfis.PerfilID INNER JOIN
               tblUnidades ON tblUsuarios.UnidadeID = tblUnidades.UnidadeID
            WHERE tblUsuarios.UsuarioAtivo = 1
            ORDER BY tblUsuarios.UsuarioNome";

			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;

		}


		public function findByMatricula($matricula){

			$sql = "SELECT     tblUsuarios.UsuarioMatricula, tblUsuarios.UnidadeID, tblUsuarios.PerfilID,
						tblUsuarios.UsuarioNome, tblUsuarios.UsuarioMatriculaResponsavel, tblUsuarios.UsuarioAtivo, 
						tblUsuarios.UsuarioDataCadastro, tblPerfis.PerfilNome, tblPerfis.PerfilDescricao, tblUnidades.UnidadeNome, tblUnidades.UnidadeSigla,
						tblUnidades.UnidadeEmail
					FROM         tblUsuarios INNER JOIN
						tblPerfis ON tblUsuarios.PerfilID = tblPerfis.PerfilID INNER JOIN
						tblUnidades ON tblUsuarios.UnidadeID = tblUnidades.UnidadeID
					WHERE     (tblUsuarios.UsuarioMatricula = ':usuariomatricula') AND tblUsuarios.UsuarioAtivo = 1";

	        $arr = parent::getSingleResultArray($sql, array(":usuariomatricula" => $matricula));
			if ($arr === null) $arr = array();
			return $arr;

		}


		public function __construct($em){
			parent::__construct($em, "Usuarios");
		}

		public function getUnidadeLDAP($unidade){

			try{
				
				$unidadeJson = @file_get_contents("http://gifugbu.sp.caixa/api/unidade.php?codigo=$unidade");

				$oUnidade = json_decode($unidadeJson);
				
				if (isset($oUnidade)) return $oUnidade;else return false;

			} catch(Exception $e){

				return false;

			}

		}

		public function findLDAP($matricula){
		
			$usrLDAP = new UsuarioLDAP($matricula);

			$cons = $this->findByMatricula($matricula);

			if (count($cons) == 0){

				$oUnidade = $this->getUnidadeLDAP($usrLDAP->getUnidade());
				$cons["UsuarioMatricula"] = $usrLDAP->getMatricula();
				$cons["UnidadeID"] = $usrLDAP->getUnidade();
				$cons["UsuarioNome"] = $usrLDAP->getNomeCompleto();

				if ($oUnidade !== false) {
					$cons["UnidadeNome"] = $oUnidade->{'nome'};
					$cons["UnidadeSigla"] = $oUnidade->{'sigla'};
					$cons["UnidadeEmail"] = $oUnidade->{'email'};
				}			

				$cons["PerfilID"] = 0;

			}

			$cons["UsuarioDataCadastro"] = date("Y-m-d H:i:s", time());
			$cons["UsuarioAtivo"] = 1;


			return $cons;

		}

	}

?>