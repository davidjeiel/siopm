<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/Juros.Class.php';

	class JurosDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "Juros");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblJuros";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findByID($id){
			$sql = 
				"SELECT * FROM tblJuros j 
			 		WHERE j.JurosID = $id";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listAllJurosByIDAtivo($ativoid){
			$sql = 
				"SELECT * FROM tblJuros j 
			 		WHERE j.AtivoID = $ativoid";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}


	}

?>