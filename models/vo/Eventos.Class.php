<?php 
class Eventos { 

	const TABLE_NAME = "tblEventos";
	const COLUMN_KEY = "EventoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $EventoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $EventoTipoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $TransacaoID;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $EventoValor;


	public function setEventoID($EventoID){
		$this->EventoID = $EventoID;
	}

	public function getEventoID(){
		return $this->EventoID;
	}

	public function setEventoTipoID($EventoTipoID){
		$this->EventoTipoID = $EventoTipoID;
	}

	public function getEventoTipoID(){
		return $this->EventoTipoID;
	}

	public function setTransacaoID($TransacaoID){
		$this->TransacaoID = $TransacaoID;
	}

	public function getTransacaoID(){
		return $this->TransacaoID;
	}

	public function setEventoValor($EventoValor){
		$this->EventoValor = $EventoValor;
	}

	public function getEventoValor(){
		return $this->EventoValor;
	}

	public function toHash(){
		 return $this->EventoID;
	}

	public function toString(){
		return $this->EventoID . " - " . $this->EventoTipoID . " - " . $this->TransacaoID . " - " . $this->EventoValor;
	}

}
?>