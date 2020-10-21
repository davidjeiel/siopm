<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/PropostasEmpreendimentosTipos.Class.php';

	class PropostasEmpreendimentosTiposDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "PropostasEmpreendimentosTipos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblPropostasEmpreendimentosTipos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>