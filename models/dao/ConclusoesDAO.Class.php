<?php 

	class ConclusoesDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "Conclusoes");
		}

		public function listAll(){

			$sql = "SELECT * FROM tblConclusoes";

			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
			
		}


		public function listAllConclusoesAnalises(){
			/*
			1	Em Análise
			2	Aprovado
			3	Positivo (Condicional)
			4	Não aprovado
			5	Desistência
			*/
			$sql = "SELECT * FROM tblConclusoes WHERE ConclusaoID IN (2, 3, 4, 5)";

			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
			
		}

		public function getArrayByID($id){

			$sql = "SELECT * FROM tblConclusoes WHERE ConclusaoID = :conclusao";

			$arr = parent::getListArray($sql, array(":conclusao" => $id));
			if ($arr === null) $arr = array();
			return $arr;

		}

	}

?>