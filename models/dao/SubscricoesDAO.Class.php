<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/Subscricoes.Class.php';

	class SubscricoesDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "Subscricoes");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblSubscricoes";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listAllByIDAtivo($id){
			$sql = 
				"SELECT * FROM tblSubscricoes s 
			 		WHERE s.AtivoID = $id";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}
		
		public function findByID($id){
			$sql = "SELECT * FROM tblSubscricoes s 
			 		WHERE s.SubscricoesID = $id";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>