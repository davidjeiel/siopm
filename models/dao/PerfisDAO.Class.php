<?php 

	class PerfisDAO extends GenericDAO {
   
		public function __construct($em){
			parent::__construct($em, "Perfis");
		}

		public function listAll(){

			$sql = "SELECT * FROM tblPerfis";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;

		}

		public function listAllAtivas(){

			$sql = "SELECT * FROM tblPerfis WHERE PERFILATIVO = 1";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;

		}

		public function findByID($id){

			$sql = "SELECT * FROM tblPerfis WHERE PERFILID = :perfilid";
	        $arr = parent::getSingleResultArray($sql, array(":perfilid" => $id));
			if ($arr === null) $arr = array();
			return $arr;

		}

	}

?>