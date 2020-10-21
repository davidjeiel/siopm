<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/InstrumentosRegistros.Class.php';

	class InstrumentosRegistrosDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "InstrumentosRegistros");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblInstrumentosRegistros";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>