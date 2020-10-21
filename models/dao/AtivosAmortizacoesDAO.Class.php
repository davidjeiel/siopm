<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/AtivosAmortizacoes.Class.php';

	class AtivosAmortizacoesDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "AtivosAmortizacoes");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblAtivosAmortizacoes";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>