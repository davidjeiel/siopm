<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/ArquivosTipos.Class.php';

	class ArquivosTiposDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "ArquivosTipos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblArquivosTipos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>