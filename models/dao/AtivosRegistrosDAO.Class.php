<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/AtivosRegistros.Class.php';

	class AtivosRegistrosDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "AtivosRegistros");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblAtivosRegistros";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findbByAtivoID($ativoID){
			$sql = "SELECT * FROM tblAtivosRegistros 
					WHERE AtivoID = ativoID";
			$arr = parent::getVO($sql);			
			return $arr;
		}
		
	}

?>