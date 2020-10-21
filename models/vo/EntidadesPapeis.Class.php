<?php 
class EntidadesPapeis { 

	const TABLE_NAME = "tblEntidadesPapeis";
	const COLUMN_KEY = "EntidadePapelID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $EntidadePapelID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EntidadePapelNome;


	public function setEntidadePapelID($EntidadePapelID){
		$this->EntidadePapelID = $EntidadePapelID;
	}

	public function getEntidadePapelID(){
		return $this->EntidadePapelID;
	}

	public function setEntidadePapelNome($EntidadePapelNome){
		$this->EntidadePapelNome = $EntidadePapelNome;
	}

	public function getEntidadePapelNome(){
		return $this->EntidadePapelNome;
	}

	public function toHash(){
		 return $this->EntidadePapelID;
	}

	public function toString(){
		return $this->EntidadePapelID . " - " . $this->EntidadePapelNome;
	}

}
?>