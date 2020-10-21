<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/PropostasRequisIntegralizacoes.Class.php';

	class PropostasRequisIntegralizacoesDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "PropostasRequisIntegralizacoes");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblPropostasRequisIntegralizacoes";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>