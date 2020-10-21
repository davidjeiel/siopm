<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/InstrumentosJurosTipos.Class.php';

	class InstrumentosJurosTiposDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "InstrumentosJurosTipos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblInstrumentosJurosTipos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>