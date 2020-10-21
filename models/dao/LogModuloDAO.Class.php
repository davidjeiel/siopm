<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/LogModulo.Class.php';

	class LogModuloDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "LogModulo");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblLogModulo";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>