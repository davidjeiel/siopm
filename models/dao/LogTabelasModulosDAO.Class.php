<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/LogTabelasModulos.Class.php';

	class LogTabelasModulosDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "LogTabelasModulos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblLogTabelasModulos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>