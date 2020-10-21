<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/AtivosLiquidacoesTipos.Class.php';

	class AtivosLiquidacoesTiposDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "AtivosLiquidacoesTipos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblAtivosLiquidacoesTipos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>