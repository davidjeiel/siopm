<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/DiasBases.Class.php';

	class DiasBasesDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "DiasBases");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblDiasBases";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>