<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/OrcamentosTipo.Class.php';

	class OrcamentosTipoDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "OrcamentosTipo");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblOrcamentosTipo";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>