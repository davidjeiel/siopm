<?php 
class PropostasFaixasTipos { 

	const TABLE_NAME = "tblPropostasFaixasTipos";
	const COLUMN_KEY = "PropostaFaixaTipoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PropostaFaixaTipoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropostaFaixaTipoNome;


	public function setPropostaFaixaTipoID($PropostaFaixaTipoID){
		$this->PropostaFaixaTipoID = $PropostaFaixaTipoID;
	}

	public function getPropostaFaixaTipoID(){
		return $this->PropostaFaixaTipoID;
	}

	public function setPropostaFaixaTipoNome($PropostaFaixaTipoNome){
		$this->PropostaFaixaTipoNome = $PropostaFaixaTipoNome;
	}

	public function getPropostaFaixaTipoNome(){
		return $this->PropostaFaixaTipoNome;
	}

	public function toHash(){
		 return $this->PropostaFaixaTipoID;
	}

	public function toString(){
		return $this->PropostaFaixaTipoID . " - " . $this->PropostaFaixaTipoNome;
	}

}
?>