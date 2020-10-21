<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/InstrumentosLocaisNegociacao.Class.php';

	class InstrumentosLocaisNegociacaoDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "InstrumentosLocaisNegociacao");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblInstrumentosLocaisNegociacao";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>