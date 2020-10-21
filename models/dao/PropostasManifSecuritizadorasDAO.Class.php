<?php 

	class PropostasManifSecuritizadorasDAO extends GenericDAO {
	
		public function __construct($em){
			parent::__construct($em, "PropostasManifSecuritizadoras");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblPropostasManifSecuritizadoras";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findVOByPropostaDetalheID($detalheID){
			$sql = "SELECT * FROM tblPropostasManifSecuritizadoras WHERE PropostaDetalheID = :propostadetalheid";
			return parent::getVO($sql, array(":propostadetalheid" => $detalheID));
		}

		public function findByPropostaDetalheID($detalheID){
			$sql = "SELECT * FROM tblPropostasManifSecuritizadoras WHERE PropostaDetalheID = :propostadetalheid";
			$arr = parent::getSingleResultArray($sql, array(":propostadetalheid" => $detalheID));
			if ($arr === null) $arr = array();
			return $arr;
		}
		
	}

?>