<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/Empreendimentos.Class.php';

	class EmpreendimentosDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "Empreendimentos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblEmpreendimentos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>