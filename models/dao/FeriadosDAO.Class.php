<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/Feriados.Class.php';

	class FeriadosDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "Feriados");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblFeriados";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>