<?php 


	class PropostasPesquisasSecuritizadoraDAO extends GenericDAO {
                
		public function __construct($em){
			parent::__construct($em, "PropostasPesquisasSecuritizadora");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblPropostasPesquisasSecuritizadora";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findVOByPropostaDetalheID($detalheID){
			$sql = "SELECT * FROM tblPropostasPesquisasSecuritizadora WHERE PropostaDetalheID = :propostadetalheid";
			return parent::getVO($sql, array(":propostadetalheid" => $detalheID));
		} 

		public function findByPropostaDetalheID($detalheID){
			$sql = "SELECT * FROM tblPropostasPesquisasSecuritizadora WHERE PropostaDetalheID = :propostadetalheid";
			$arr = parent::getSingleResultArray($sql, array(":propostadetalheid" => $detalheID));
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>