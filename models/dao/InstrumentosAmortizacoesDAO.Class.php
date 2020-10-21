<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/InstrumentosAmortizacoes.Class.php';

	class InstrumentosAmortizacoesDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "InstrumentosAmortizacoes");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblInstrumentosAmortizacoes";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>