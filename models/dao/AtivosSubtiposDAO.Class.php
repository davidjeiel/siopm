<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/AtivosSubtipos.Class.php';

	class AtivosSubtiposDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "AtivosSubtipos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblAtivosSubtipos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listSubtiposCRI(){
			$sql = "SELECT * FROM tblAtivosSubtipos
				WHERE AtivoTipoID = 1";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>