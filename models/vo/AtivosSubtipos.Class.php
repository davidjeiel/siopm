<?php 
class AtivosSubtipos { 

	const TABLE_NAME = "tblAtivosSubtipos";
	const COLUMN_KEY = "AtivoSubtipoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $AtivoSubtipoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoTipoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "50", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoSubtipoNome;


	public function setAtivoSubtipoID($AtivoSubtipoID){
		$this->AtivoSubtipoID = $AtivoSubtipoID;
	}

	public function getAtivoSubtipoID(){
		return $this->AtivoSubtipoID;
	}

	public function setAtivoTipoID($AtivoTipoID){
		$this->AtivoTipoID = $AtivoTipoID;
	}

	public function getAtivoTipoID(){
		return $this->AtivoTipoID;
	}

	public function setAtivoSubtipoNome($AtivoSubtipoNome){
		$this->AtivoSubtipoNome = $AtivoSubtipoNome;
	}

	public function getAtivoSubtipoNome(){
		return $this->AtivoSubtipoNome;
	}

	public function toHash(){
		 return $this->AtivoSubtipoID;
	}

	public function toString(){
		return $this->AtivoSubtipoID . " - " . $this->AtivoTipoID . " - " . $this->AtivoSubtipoNome;
	}

}
?>