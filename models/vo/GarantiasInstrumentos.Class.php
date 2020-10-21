<?php 
class GarantiasInstrumentos { 

	const TABLE_NAME = "tblGarantiasInstrumentos";
	const COLUMN_KEY = "GarantiaInstrumentoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $GarantiaInstrumentoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $GarantiaID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $InstrumentoID;


	public function setGarantiaInstrumentoID($GarantiaInstrumentoID){
		$this->GarantiaInstrumentoID = $GarantiaInstrumentoID;
	}

	public function getGarantiaInstrumentoID(){
		return $this->GarantiaInstrumentoID;
	}

	public function setGarantiaID($GarantiaID){
		$this->GarantiaID = $GarantiaID;
	}

	public function getGarantiaID(){
		return $this->GarantiaID;
	}

	public function setInstrumentoID($InstrumentoID){
		$this->InstrumentoID = $InstrumentoID;
	}

	public function getInstrumentoID(){
		return $this->InstrumentoID;
	}

	public function toHash(){
		 return $this->GarantiaInstrumentoID;
	}

	public function toString(){
		return $this->GarantiaInstrumentoID . " - " . $this->GarantiaID . " - " . $this->InstrumentoID;
	}

}
?>