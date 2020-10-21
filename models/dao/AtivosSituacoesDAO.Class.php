<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/AtivosSituacoes.Class.php';

	class AtivosSituacoesDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "AtivosSituacoes");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblAtivosSituacoes";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>