<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/DiasAnos.Class.php';

	class DiasAnosDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "DiasAnos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblDiasAnos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>