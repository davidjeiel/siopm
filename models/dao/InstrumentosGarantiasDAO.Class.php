<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/InstrumentosGarantias.Class.php';

	class InstrumentosGarantiasDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "InstrumentosGarantias");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblInstrumentosGarantias";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listByInstrumentoID($id){
			$sql = "SELECT * FROM tblInstrumentosGarantias WHERE InstrumentoID = $id";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>