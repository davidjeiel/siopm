<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/AtivosArquivosTipos.Class.php';

	class AtivosArquivosTiposDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "AtivosArquivosTipos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblAtivosArquivosTipos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>