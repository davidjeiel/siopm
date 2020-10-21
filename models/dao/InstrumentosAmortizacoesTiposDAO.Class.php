<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/InstrumentosAmortizacoesTipos.Class.php';

	class InstrumentosAmortizacoesTiposDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "InstrumentosAmortizacoesTipos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblInstrumentosAmortizacoesTipos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>