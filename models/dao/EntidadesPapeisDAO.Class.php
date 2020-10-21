<?php 

	class EntidadesPapeisDAO extends GenericDAO {
   
		public function __construct($em){
			parent::__construct($em, "EntidadesPapeis");
		}

		public function listAll(){

			$sql = "SELECT * FROM tblEntidadesPapeis ORDER BY EntidadePapelNome";

			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
			
		}

	}

?>