<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/AtivosGarantias.Class.php';

	class AtivosGarantiasDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "AtivosGarantias");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblAtivosGarantias";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listByAtivoID($id){
			$sql = "SELECT * FROM tblAtivosGarantias WHERE AtivoID = $id";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>