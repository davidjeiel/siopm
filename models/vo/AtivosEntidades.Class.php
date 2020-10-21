<?php 
class AtivosEntidades { 

	const TABLE_NAME = "tblAtivosEntidades";
	const COLUMN_KEY = "AtivoEntidadeID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $AtivoEntidadeID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $AtivoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $EntidadeID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $EntidadePapelID;


	public function setAtivoEntidadeID($AtivoEntidadeID){
		$this->AtivoEntidadeID = $AtivoEntidadeID;
	}

	public function getAtivoEntidadeID(){
		return $this->AtivoEntidadeID;
	}

	public function setAtivoID($AtivoID){
		$this->AtivoID = $AtivoID;
	}

	public function getAtivoID(){
		return $this->AtivoID;
	}

	public function setEntidadeID($EntidadeID){
		$this->EntidadeID = $EntidadeID;
	}

	public function getEntidadeID(){
		return $this->EntidadeID;
	}

	public function setEntidadePapelID($EntidadePapelID){
		$this->EntidadePapelID = $EntidadePapelID;
	}

	public function getEntidadePapelID(){
		return $this->EntidadePapelID;
	}

	public function toHash(){
		 return $this->AtivoEntidadeID;
	}

	public function toString(){
		return $this->AtivoEntidadeID . " - " . $this->AtivoID . " - " . $this->EntidadeID . " - " . $this->EntidadePapelID;
	}

}
?>