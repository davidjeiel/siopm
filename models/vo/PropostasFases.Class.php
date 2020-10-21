<?php 
class PropostasFases { 

	const TABLE_NAME = "tblPropostasFases";
	const COLUMN_KEY = "PropostaFaseID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PropostaFaseID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropostaFaseNome;


	public function setPropostaFaseID($PropostaFaseID){
		$this->PropostaFaseID = $PropostaFaseID;
	}

	public function getPropostaFaseID(){
		return $this->PropostaFaseID;
	}

	public function setPropostaFaseNome($PropostaFaseNome){
		$this->PropostaFaseNome = $PropostaFaseNome;
	}

	public function getPropostaFaseNome(){
		return $this->PropostaFaseNome;
	}

	public function toHash(){
		 return $this->PropostaFaseID;
	}

	public function toString(){
		return $this->PropostaFaseID . " - " . $this->PropostaFaseNome;
	}

}
?>