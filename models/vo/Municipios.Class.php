<?php 
class Municipios { 

	const TABLE_NAME = "tblMunicipios";
	const COLUMN_KEY = "MunicipioID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $MunicipioID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "200", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $MunicipioNome;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $UnidadeFederacaoID;


	public function setMunicipioID($MunicipioID){
		$this->MunicipioID = $MunicipioID;
	}

	public function getMunicipioID(){
		return $this->MunicipioID;
	}

	public function setMunicipioNome($MunicipioNome){
		$this->MunicipioNome = $MunicipioNome;
	}

	public function getMunicipioNome(){
		return $this->MunicipioNome;
	}

	public function setUnidadeFederacaoID($UnidadeFederacaoID){
		$this->UnidadeFederacaoID = $UnidadeFederacaoID;
	}

	public function getUnidadeFederacaoID(){
		return $this->UnidadeFederacaoID;
	}

	public function toHash(){
		 return $this->MunicipioID;
	}

	public function toString(){
		return $this->MunicipioID . " - " . $this->MunicipioNome . " - " . $this->UnidadeFederacaoID;
	}

}
?>