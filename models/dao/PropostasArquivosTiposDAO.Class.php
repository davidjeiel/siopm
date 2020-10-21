<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/PropostasArquivosTipos.Class.php';

	class PropostasArquivosTiposDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "PropostasArquivosTipos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblPropostasArquivosTipos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>