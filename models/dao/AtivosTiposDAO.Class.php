<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/AtivosTipos.Class.php';

	class AtivosTiposDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "AtivosTipos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblAtivosTipos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>