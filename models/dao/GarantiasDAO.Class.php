<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/Garantias.Class.php';

	class GarantiasDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "Garantias");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblGarantias
					ORDER BY GarantiaNome";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>