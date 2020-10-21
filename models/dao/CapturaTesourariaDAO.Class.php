<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/CapturaTesouraria.Class.php';

	class CapturaTesourariaDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "CapturaTesouraria");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblCapturaTesouraria";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findVOByID($ID){
			$sql = "SELECT Id,CapturaControleID,Data,Historico,Valor, DataConciliacao
					 FROM  tblCapturaTesouraria
					WHERE Id = $ID";
			$vo = parent::getVO($sql, array());
			if ($vo === null) return null;
			return $vo;
		}

	}

?>