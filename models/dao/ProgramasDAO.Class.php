<?php 

	class ProgramasDAO extends GenericDAO {
   
		public function __construct($em){
			parent::__construct($em, "Programas");
		}

		public function listAll(){

			$sql = "SELECT * FROM tblProgramas";

			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
			
		}

	}

?>