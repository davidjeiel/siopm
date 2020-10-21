<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/Modalidades.Class.php';

	class ModalidadesDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "Modalidades");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblModalidades";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>