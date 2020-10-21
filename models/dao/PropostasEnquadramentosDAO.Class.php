<?php 

	class PropostasEnquadramentosDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "PropostasEnquadramentos");
		}

		public function listAll(){

			$sql = "SELECT * FROM tblPropostasEnquadramentos";

			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
			
		}

		public function findVOByPropostaDetalheID($detalheID){
			$sql = "SELECT * FROM tblPropostasEnquadramentos WHERE PropostaDetalheID = :propostadetalheid";
			return parent::getVO($sql, array(":propostadetalheid" => $detalheID));
		} 

		public function findByPropostaDetalheID($detalheID){

			$sql = "SELECT * FROM tblPropostasEnquadramentos WHERE PropostaDetalheID = :propostadetalheid";
			
			$arr = parent::getSingleResultArray($sql, array(":propostadetalheid" => $detalheID));
			if ($arr === null) $arr = array();
			return $arr;

		}

	}

?>