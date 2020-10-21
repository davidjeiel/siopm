<?php 
class EntidadesContatos { 

	const TABLE_NAME = "tblEntidadesContatos";
	const COLUMN_KEY = "EntidadeContatoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $EntidadeContatoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $EntidadeID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ContatoID;


	public function setEntidadeContatoID($EntidadeContatoID){
		$this->EntidadeContatoID = $EntidadeContatoID;
	}

	public function getEntidadeContatoID(){
		return $this->EntidadeContatoID;
	}

	public function setEntidadeID($EntidadeID){
		$this->EntidadeID = $EntidadeID;
	}

	public function getEntidadeID(){
		return $this->EntidadeID;
	}

	public function setContatoID($ContatoID){
		$this->ContatoID = $ContatoID;
	}

	public function getContatoID(){
		return $this->ContatoID;
	}

	public function toHash(){
		 return $this->EntidadeContatoID;
	}

	public function toString(){
		return $this->EntidadeContatoID . " - " . $this->EntidadeID . " - " . $this->ContatoID;
	}

}
?>