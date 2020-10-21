<?php 
class EntidadesInstrumentos { 

	const TABLE_NAME = "tblEntidadesInstrumentos";
	const COLUMN_KEY = "EntidadeInstrumentoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $EntidadeInstrumentoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $entidadeID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $intrumentoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $entidadePapelID;


	public function setEntidadeInstrumentoID($EntidadeInstrumentoID){
		$this->EntidadeInstrumentoID = $EntidadeInstrumentoID;
	}

	public function getEntidadeInstrumentoID(){
		return $this->EntidadeInstrumentoID;
	}

	public function setEntidadeID($entidadeID){
		$this->entidadeID = $entidadeID;
	}

	public function getEntidadeID(){
		return $this->entidadeID;
	}

	public function setIntrumentoID($intrumentoID){
		$this->intrumentoID = $intrumentoID;
	}

	public function getIntrumentoID(){
		return $this->intrumentoID;
	}

	public function setEntidadePapelID($entidadePapelID){
		$this->entidadePapelID = $entidadePapelID;
	}

	public function getEntidadePapelID(){
		return $this->entidadePapelID;
	}

	public function toHash(){
		 return $this->EntidadeInstrumentoID;
	}

	public function toString(){
		return $this->EntidadeInstrumentoID . " - " . $this->entidadeID . " - " . $this->intrumentoID . " - " . $this->entidadePapelID;
	}

}
?>