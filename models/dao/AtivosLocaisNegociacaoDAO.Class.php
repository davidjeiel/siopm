<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/AtivosLocaisNegociacao.Class.php';

	class AtivosLocaisNegociacaoDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "AtivosLocaisNegociacao");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblAtivosLocaisNegociacao";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>