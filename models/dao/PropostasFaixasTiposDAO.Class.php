<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/PropostasFaixasTipos.Class.php';

	class PropostasFaixasTiposDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "PropostasFaixasTipos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblPropostasFaixasTipos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>