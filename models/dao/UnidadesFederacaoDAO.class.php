<?php 

	class UnidadesFederacaoDAO extends GenericDAO {
   
		public function __construct($em){
			parent::__construct($em, "UnidadesFederacao");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblUnidadesFederacao";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>