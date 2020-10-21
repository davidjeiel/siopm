<?php 

	class EntidadesTiposDAO extends GenericDAO {
   
		public function __construct($em){
			parent::__construct($em, "EntidadesTipos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblEntidadesTipos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}


	}

?>