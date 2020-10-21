<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/AtivosAmortizacoesTipos.Class.php';

	class AtivosAmortizacoesTiposDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "AtivosAmortizacoesTipos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblAtivosAmortizacoesTipos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>