<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/Contas.Class.php';

	class ContasDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "Contas");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblContas";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>