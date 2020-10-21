<?php 
class PropostasContatos { 

	const TABLE_NAME = "tblPropostasContatos";
	const COLUMN_KEY = "PropostaContatoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PropostaContatoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropostaID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ContatoID;


	public function setPropostaContatoID($PropostaContatoID){
		$this->PropostaContatoID = $PropostaContatoID;
	}

	public function getPropostaContatoID(){
		return $this->PropostaContatoID;
	}

	public function setPropostaID($PropostaID){
		$this->PropostaID = $PropostaID;
	}

	public function getPropostaID(){
		return $this->PropostaID;
	}

	public function setContatoID($ContatoID){
		$this->ContatoID = $ContatoID;
	}

	public function getContatoID(){
		return $this->ContatoID;
	}

	public function toHash(){
		 return $this->PropostaContatoID;
	}

	public function toString(){
		return $this->PropostaContatoID . " - " . $this->PropostaID . " - " . $this->ContatoID;
	}

}
?>