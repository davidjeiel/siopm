<?php 

	class FuncionalidadesDAO extends GenericDAO {
   
		public function __construct($em){
			parent::__construct($em, "Funcionalidades");
		}

		public function listAll(){

			$sql = "SELECT * FROM tblFuncionalidades ORDER BY FuncionalidadeNome ASC";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;

		}

		public function findByID($id){

			$sql = "SELECT * FROM tblFuncionalidades WHERE FUNCIONALIDADEID = :funcionalidadeid";
	        $arr = parent::getSingleResultArray($sql, array(":funcionalidadeid" => $id));
			if ($arr === null) $arr = array();
			return $arr;

		}

	}

?>