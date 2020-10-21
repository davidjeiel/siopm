<?php 
class PropostasStatus { 

	const TABLE_NAME = "tblPropostasStatus";
	const COLUMN_KEY = "PropostaStatusID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "2", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PropostaStatusID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $StatusNome;


	public function setPropostaStatusID($PropostaStatusID){
		$this->PropostaStatusID = $PropostaStatusID;
	}

	public function getPropostaStatusID(){
		return $this->PropostaStatusID;
	}

	public function setStatusNome($StatusNome){
		$this->StatusNome = $StatusNome;
	}

	public function getStatusNome(){
		return $this->StatusNome;
	}

	public function toHash(){
		 return $this->PropostaStatusID;
	}

	public function toString(){
		return $this->PropostaStatusID . " - " . $this->StatusNome;
	}

}
?>