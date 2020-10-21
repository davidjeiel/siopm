<?php 

	class AcessosDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "Acessos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblAcessos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listarControllers(){
			$sql = "SELECT DISTINCT Controller FROM tblAcessos ORDER BY Controller";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listarUsuarios(){
			$sql = "SELECT DISTINCT A.Matricula, U.UsuarioNome AS Nome FROM tblAcessos AS A 
					INNER JOIN tblusuarios AS U ON A.Matricula = U.UsuarioMatricula ORDER BY Matricula";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listar($matricula, $controller, $dataini, $datafim){
			$sql = "SELECT ID, DataHora, Matricula, Controller, Endereco, Unidade, Acao FROM tblAcessos 
					WHERE DataHora BETWEEN '" . 
					PPOEntity::toDateUnicode($dataini, "Y-m-d") . " 00:00:00' AND '" . 
					PPOEntity::toDateUnicode($datafim, "Y-m-d") . " 23:59:59'";
			$sql .= ($matricula != '0') ? " AND  Matricula = '$matricula' " : "";
			$sql .= ($controller != '0') ? " AND  Controller = '$controller' " : "";		
			$sql .=	" ORDER BY Matricula ASC, DataHora DESC ";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>