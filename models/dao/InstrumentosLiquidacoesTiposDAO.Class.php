<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/InstrumentosLiquidacoesTipos.Class.php';

	class InstrumentosLiquidacoesTiposDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "InstrumentosLiquidacoesTipos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblInstrumentosLiquidacoesTipos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>