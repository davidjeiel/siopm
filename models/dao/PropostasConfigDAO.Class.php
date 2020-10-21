<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/PropostasConfig.Class.php';

	class PropostasConfigDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "PropostasConfig");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblPropostasConfig";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}
		
		public function findAtivo(){
			$sql = "SELECT * FROM tblPropostasConfig WHERE Ativo = 1";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function getAtivo(){
			$sql = "SELECT * FROM tblPropostasConfig WHERE Ativo = 1";
			return parent::getVO($sql, array());
		}

	}

?>