<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/Log.Class.php';

	class LogDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "Log");
		}

		public function listarModulos(){
			$sql = "SELECT DISTINCT L.Modulo, M.Descricao FROM tblLog AS L INNER JOIN tblLogModulo AS M ON L.Modulo = M.ID ORDER BY Modulo";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listarUsuarios(){
			$sql = "SELECT DISTINCT L.Matricula, U.UsuarioNome AS Nome FROM tblLog AS L 
					INNER JOIN tblusuarios AS U ON L.Matricula = U.UsuarioMatricula ORDER BY Matricula";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listarTipos(){
			$sql = "SELECT DISTINCT L.Tipo, T.Descricao FROM tblLog AS L 
					INNER JOIN tblLogTipo AS T ON L.Tipo = T.ID ORDER BY L.Tipo";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listar($matricula, $modulo, $tipo, $dataInicial, $dataFinal){
			$sql = "SELECT L.ID, L.Grupo, L.Tipo, T.Descricao as TDescricao, 
					L.Modulo, M.Descricao as MDescricao, L.Matricula, U.UsuarioMatricula as Nome, U.UsuarioNome as NomeUsuario ,L.DataHora, L.FKValue, L.Conteudo 
					FROM tblLog AS L
					INNER JOIN tblusuarios AS U ON L.Matricula = U.UsuarioMatricula
					INNER JOIN tblLogModulo AS M ON L.Modulo = M.ID
					INNER JOIN tblLogTipo AS T ON L.Tipo = T.ID
					WHERE DataHora BETWEEN '" . 
					PPOEntity::toDateUnicode($dataInicial, "Y-m-d") . " 00:00:00' AND '" . 
					PPOEntity::toDateUnicode($dataFinal, "Y-m-d") . " 23:59:59'";
			$sql .= ($tipo != '0') ? " AND  L.Tipo = $tipo " : "";
			$sql .= ($modulo != '0') ? " AND  L.Modulo = '$modulo' " : "";		
			$sql .= ($matricula != '0') ? " AND  L.Matricula = '$matricula' " : "";
			$sql .=	" ORDER BY Matricula ASC, DataHora DESC ";
			
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>