<?php 
class EventosTipos { 

	const TABLE_NAME = "tblEventosTipos";
	const COLUMN_KEY = "EventoTipoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $EventoTipoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EventoTipoNome;


	public function setEventoTipoID($EventoTipoID){
		$this->EventoTipoID = $EventoTipoID;
	}

	public function getEventoTipoID(){
		return $this->EventoTipoID;
	}

	public function setEventoTipoNome($EventoTipoNome){
		$this->EventoTipoNome = $EventoTipoNome;
	}

	public function getEventoTipoNome(){
		return $this->EventoTipoNome;
	}

	public function toHash(){
		 return $this->EventoTipoID;
	}

	public function toString(){
		return $this->EventoTipoID . " - " . $this->EventoTipoNome;
	}

}
?>