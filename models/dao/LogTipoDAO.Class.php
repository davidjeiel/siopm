<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/LogTipo.Class.php';

	class LogTipoDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "LogTipo");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblLogTipo";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>