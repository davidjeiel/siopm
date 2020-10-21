<?php 

	class PerfisFuncionalidadesDAO extends GenericDAO {
   
		public function __construct($em){
			parent::__construct($em, "PerfisFuncionalidades");
		}

		public function listAll(){

			$sql = "SELECT * FROM tblPerfisFuncionalidades";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;

		}

		public function findByID($id){

			$sql = "SELECT * FROM tblPerfisFuncionalidades WHERE PERFILFUNCIONALIDADEID = :perfilfuncionalidadeid";

	        $arr = parent::getSingleResultArray($sql, array(":perfilfuncionalidadeid" => $id));
			if ($arr === null) $arr = array();
			return $arr;

		}

		public function listByPerfilID($id){
			$sql = "SELECT  F.FuncionalidadeNome 
								  FROM tblPerfis AS P INNER JOIN tblPerfisFuncionalidades AS PF ON P.PerfilID = PF.PerfilID INNER JOIN
                         		  tblFuncionalidades AS F ON PF.FuncionalidadeID = F.FuncionalidadeID WHERE  P.PerfilID =:perfilid
							ORDER BY F.FuncionalidadeNome ASC";
	        $arr = parent::getListArray($sql, array(":perfilid" => $id));
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findByFuncionalidadeID($id){

			$sql = "SELECT * FROM tblPerfisFuncionalidades WHERE FUNCIONALIDADEID = :funcionalidadeid";
	        $arr = parent::getSingleResultArray($sql, array(":funcionalidadeid" => $id));
			if ($arr === null) $arr = array();
			return $arr;

		}

		public function findByFullPerfilID($id){

			$sql = "SELECT  F.FuncionalidadeNome --, P.PerfilID, PF.FuncionalidadeID,
					FROM tblPerfis AS P INNER JOIN tblPerfisFuncionalidades AS PF ON P.PerfilID = PF.PerfilID INNER JOIN
                    tblFuncionalidades AS F ON PF.FuncionalidadeID = F.FuncionalidadeID WHERE  P.PerfilID =:perfilid
					ORDER BY F.FuncionalidadeNome";
	        $arr = parent::getSingleResultArray($sql, array(":perfilid" => $id));
			if ($arr === null) $arr = array();
			return $arr;

		}	

	}

?>