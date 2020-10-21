<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/Datas.Class.php';

	class DatasDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "Datas");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblDatas";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>