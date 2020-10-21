<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/EntidadesContatos.Class.php';

	class EntidadesContatosDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "EntidadesContatos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblEntidadesContatos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}
		
		public function listAllContatosByEntidadeID($id){
			$sql = "SELECT EC.EntidadeContatoID, EC.EntidadeID, C.* FROM tblEntidadesContatos As EC
			INNER JOIN tblContatos As C ON EC.ContatoID = C.ContatoID
			WHERE EC.EntidadeID = $id";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}
		
	}

?>