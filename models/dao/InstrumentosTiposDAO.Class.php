<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/InstrumentosTipos.Class.php';

	class InstrumentosTiposDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "InstrumentosTipos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblInstrumentosTipos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>