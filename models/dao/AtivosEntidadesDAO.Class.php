<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/AtivosEntidades.Class.php';

	class AtivosEntidadesDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "AtivosEntidades");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblAtivosEntidades";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}
		
		public function findByID($id){
			$sql = "SELECT * FROM tblAtivosEntidades ae 
			 		WHERE ae.AtivoEntidadeID = $id";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findDadosEmpresaByID($id){
			$sql = "SELECT ae.*, e.*, ep.*
					FROM tblAtivosEntidades ae INNER JOIN			
						    tblEntidades e ON ae.EntidadeID = e.EntidadeID INNER JOIN			
						    tblEntidadesPapeis ep ON ae.EntidadePapelID = ep.EntidadePapelID
			 		WHERE ae.AtivoEntidadeID = $id";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listAllByIDAtivo($ativoid){
			$sql = "SELECT ae.*, e.*, ep.*
					FROM tblAtivosEntidades ae INNER JOIN			
						    tblEntidades e ON ae.EntidadeID = e.EntidadeID INNER JOIN			
						    tblEntidadesPapeis ep ON ae.EntidadePapelID = ep.EntidadePapelID
					WHERE ae.AtivoID = $ativoid";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function hasTwoEmissor($ativoid){
			$sql = "SELECT ae.EntidadeID
					FROM tblAtivosEntidades ae INNER JOIN 
					tblAtivos a  ON ae.AtivoID = a.AtivoID 
					WHERE (a.AtivoAtivo = 1) and (ae.EntidadePapelID = 1) and (a.AtivoID = $ativoid)";
			$arr = parent::getListArray($sql, array());
			if (count($arr) > 1 ){				
			 	//echo"Tem mais de 1 emissor";
			 	return true;
			}else{				
				return false;
			}
		}

		public function hasEmissor($ativoid){
			$sql = "SELECT ae.EntidadeID
					FROM tblAtivosEntidades ae INNER JOIN 
					tblAtivos a  ON ae.AtivoID = a.AtivoID 
					WHERE (a.AtivoAtivo = 1) and (ae.EntidadePapelID = 1) and (a.AtivoID = $ativoid)";
			$arr = parent::getListArray($sql, array());
			if (count($arr) > 0 ){				
			 	//echo"Tem mais de 1 emissor";
			 	return true;
			}else{				
				return false;
			}
		}

		public function checkCedente($ativoid){
			$sql = "SELECT a.AtivoID, ae.*
					FROM tblAtivos a INNER JOIN			
					tblAtivosEntidades ae ON ae.AtivoID = a.AtivoID 
					WHERE (a.AtivoAtivo = 1) and (ae.EntidadePapelID = 3) and (a.AtivoID = $ativoid)";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) return false;
			if (isset($arr['EntidadePapelID']) && $arr['EntidadePapelID'] == 3) return true;
		}			

	}

?>