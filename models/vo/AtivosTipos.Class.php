<?php 
class AtivosTipos { 

	const TABLE_NAME = "tblAtivosTipos";
	const COLUMN_KEY = "AtivoTipoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $AtivoTipoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "120", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $AtivoTipoNome;

	/**
	* @var "TYPE" => "string", "LENGTH" => "30", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoTipoAbreviatura;


	public function setAtivoTipoID($AtivoTipoID){
		$this->AtivoTipoID = $AtivoTipoID;
	}

	public function getAtivoTipoID(){
		return $this->AtivoTipoID;
	}

	public function setAtivoTipoNome($AtivoTipoNome){
		$this->AtivoTipoNome = $AtivoTipoNome;
	}

	public function getAtivoTipoNome(){
		return $this->AtivoTipoNome;
	}

	public function setAtivoTipoAbreviatura($AtivoTipoAbreviatura){
		$this->AtivoTipoAbreviatura = $AtivoTipoAbreviatura;
	}

	public function getAtivoTipoAbreviatura(){
		return $this->AtivoTipoAbreviatura;
	}

	public function toHash(){
		 return $this->AtivoTipoID;
	}

	public function toString(){
		return $this->AtivoTipoID . " - " . $this->AtivoTipoNome . " - " . $this->AtivoTipoAbreviatura;
	}

}
?>