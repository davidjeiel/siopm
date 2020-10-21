<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/AtivosJurosTipos.Class.php';

	class AtivosJurosTiposDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "AtivosJurosTipos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblAtivosJurosTipos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>