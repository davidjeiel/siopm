<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/PropostasManifSecurGarantias.Class.php';

	class PropostasManifSecurGarantiasDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "PropostasManifSecurGarantias");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblPropostasManifSecurGarantias";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function existeGarantias($id = 0){
			$sql = "SELECT COUNT(GarantiaID) AS TOTGARANTIAS FROM tblPropostasManifSecurGarantias WHERE PropManifSecurID = $id";
			$arr = parent::getSingleResultArray($sql);
			if (isset($arr['TOTGARANTIAS']) && $arr['TOTGARANTIAS'] > 0) return true; else false; 
		}

		public function listByPropManifSecurID($id){
			$sql = "SELECT * FROM tblPropostasManifSecurGarantias WHERE PropManifSecurID = :propmanifsecurid";
			$arr = parent::getListArray($sql, array(":propmanifsecurid" => $id));
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function deleteByPropManifSecurID($id){
			$sql = "DELETE FROM tblPropostasManifSecurGarantias WHERE PropManifSecurID = :propmanifsecurid";
			parent::execute($sql, array(":propmanifsecurid" => $id)); 
		}

	}

?>