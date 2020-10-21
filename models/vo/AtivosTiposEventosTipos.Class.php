<?php 
class AtivosTiposEventosTipos { 

	const TABLE_NAME = "tblAtivosTiposEventosTipos";
	const COLUMN_KEY = "AtivoTipoEventoTipoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $AtivoTipoEventoTipoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $AtivoTipoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $EventoTipoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $EventoTipoOrdem;


	public function setAtivoTipoEventoTipoID($AtivoTipoEventoTipoID){
		$this->AtivoTipoEventoTipoID = $AtivoTipoEventoTipoID;
	}

	public function getAtivoTipoEventoTipoID(){
		return $this->AtivoTipoEventoTipoID;
	}

	public function setAtivoTipoID($AtivoTipoID){
		$this->AtivoTipoID = $AtivoTipoID;
	}

	public function getAtivoTipoID(){
		return $this->AtivoTipoID;
	}

	public function setEventoTipoID($EventoTipoID){
		$this->EventoTipoID = $EventoTipoID;
	}

	public function getEventoTipoID(){
		return $this->EventoTipoID;
	}

	public function setEventoTipoOrdem($EventoTipoOrdem){
		$this->EventoTipoOrdem = $EventoTipoOrdem;
	}

	public function getEventoTipoOrdem(){
		return $this->EventoTipoOrdem;
	}

	public function toHash(){
		 return $this->AtivoTipoEventoTipoID;
	}

	public function toString(){
		return $this->AtivoTipoEventoTipoID . " - " . $this->AtivoTipoID . " - " . $this->EventoTipoID . " - " . $this->EventoTipoOrdem;
	}

}
?>