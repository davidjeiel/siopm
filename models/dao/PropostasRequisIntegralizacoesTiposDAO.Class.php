<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/PropostasRequisIntegralizacoesTipos.Class.php';

	class PropostasRequisIntegralizacoesTiposDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "PropostasRequisIntegralizacoesTipos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblPropostasRequisIntegralizacoesTipos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>