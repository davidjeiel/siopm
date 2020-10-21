<?php 

	class UnidadesDAO extends GenericDAO {
   
		public function __construct($em){
			parent::__construct($em, "Unidades");
		}

		public function listAll(){

			$sql = "SELECT * FROM tblUnidades";

			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
			
		}

			public function listAllPodeHabilitar(){

			$sql = "SELECT * FROM tblUnidades as u where u.PodeHabilitar = 1";

			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
			
		}

	}

?>