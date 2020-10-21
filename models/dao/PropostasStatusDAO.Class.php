<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/PropostasStatus.Class.php';

	class PropostasStatusDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "PropostasStatus");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblPropostasStatus";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listFinalizacoes(){
			$sql = "SELECT * FROM tblPropostasStatus WHERE PropostaStatusID > 1 -- Não traz o Em Andamento ";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>