<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/PropostasFases.Class.php';

	class PropostasFasesDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "PropostasFases");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblPropostasFases";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>