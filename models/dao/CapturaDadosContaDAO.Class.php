<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/CapturaDadosConta.Class.php';

	class CapturaDadosContaDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "CapturaDadosConta");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblCapturaDadosConta";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>