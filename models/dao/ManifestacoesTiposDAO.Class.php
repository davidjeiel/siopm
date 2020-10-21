<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/ManifestacoesTipos.Class.php';

	class ManifestacoesTiposDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "ManifestacoesTipos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblManifestacoesTipos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>