<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/Intervalos.Class.php';

	class IntervalosDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "Intervalos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblIntervalos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>