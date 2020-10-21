<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/InstrumentosSituacoes.Class.php';

	class InstrumentosSituacoesDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "InstrumentosSituacoes");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblInstrumentosSituacoes";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>