<?php 
class AtivosJurosTipos { 

	const TABLE_NAME = "tblAtivosJurosTipos";
	const COLUMN_KEY = "AtivoJurosTipoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $AtivoJurosTipoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoJurosTipoNome;


	public function setAtivoJurosTipoID($AtivoJurosTipoID){
		$this->AtivoJurosTipoID = $AtivoJurosTipoID;
	}

	public function getAtivoJurosTipoID(){
		return $this->AtivoJurosTipoID;
	}

	public function setAtivoJurosTipoNome($AtivoJurosTipoNome){
		$this->AtivoJurosTipoNome = $AtivoJurosTipoNome;
	}

	public function getAtivoJurosTipoNome(){
		return $this->AtivoJurosTipoNome;
	}

	public function toHash(){
		 return $this->AtivoJurosTipoID;
	}

	public function toString(){
		return $this->AtivoJurosTipoID . " - " . $this->AtivoJurosTipoNome;
	}

}
?>