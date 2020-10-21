<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/Indexadores.Class.php';

	class IndexadoresDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "Indexadores");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblIndexadores";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>