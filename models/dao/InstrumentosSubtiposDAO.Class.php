<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/InstrumentosSubtipos.Class.php';

	class InstrumentosSubtiposDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "InstrumentosSubtipos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblInstrumentosSubtipos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>