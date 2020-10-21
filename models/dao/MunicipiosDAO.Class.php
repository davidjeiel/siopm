<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/Municipios.Class.php';

	class MunicipiosDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "Municipios");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblMunicipios";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>