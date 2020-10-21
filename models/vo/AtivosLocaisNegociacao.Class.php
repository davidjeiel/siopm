<?php 
class AtivosLocaisNegociacao { 

	const TABLE_NAME = "tblAtivosLocaisNegociacao";
	const COLUMN_KEY = "AtivoLocalNegociacaoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $AtivoLocalNegociacaoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoLocalNegociacaoEmpresa;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoLocalNegociacaoSegmento;


	public function setAtivoLocalNegociacaoID($AtivoLocalNegociacaoID){
		$this->AtivoLocalNegociacaoID = $AtivoLocalNegociacaoID;
	}

	public function getAtivoLocalNegociacaoID(){
		return $this->AtivoLocalNegociacaoID;
	}

	public function setAtivoLocalNegociacaoEmpresa($AtivoLocalNegociacaoEmpresa){
		$this->AtivoLocalNegociacaoEmpresa = $AtivoLocalNegociacaoEmpresa;
	}

	public function getAtivoLocalNegociacaoEmpresa(){
		return $this->AtivoLocalNegociacaoEmpresa;
	}

	public function setAtivoLocalNegociacaoSegmento($AtivoLocalNegociacaoSegmento){
		$this->AtivoLocalNegociacaoSegmento = $AtivoLocalNegociacaoSegmento;
	}

	public function getAtivoLocalNegociacaoSegmento(){
		return $this->AtivoLocalNegociacaoSegmento;
	}

	public function toHash(){
		 return $this->AtivoLocalNegociacaoID;
	}

	public function toString(){
		return $this->AtivoLocalNegociacaoID . " - " . $this->AtivoLocalNegociacaoEmpresa . " - " . $this->AtivoLocalNegociacaoSegmento;
	}

}
?>