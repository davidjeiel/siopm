<?php 

	class PropostasDetalhesDAO extends GenericDAO {
   
		public function __construct($em){
			parent::__construct($em, "PropostasDetalhes");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblPropostasDetalhes ";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		
	}

?>