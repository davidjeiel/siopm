<?php 
class PropostasConfig { 

	const TABLE_NAME = "tblPropostasConfig";
	const COLUMN_KEY = "PropostaConfigID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PropostaConfigID;

	/**
	* @var "TYPE" => "double", "LENGTH" => "9", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $JurosMaximoPermitido;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PrazoMaximoPermitido;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Ativo;


	public function setPropostaConfigID($PropostaConfigID){
		$this->PropostaConfigID = $PropostaConfigID;
	}

	public function getPropostaConfigID(){
		return $this->PropostaConfigID;
	}

	public function setJurosMaximoPermitido($JurosMaximoPermitido){
		$this->JurosMaximoPermitido = $JurosMaximoPermitido;
	}

	public function getJurosMaximoPermitido(){
		return $this->JurosMaximoPermitido;
	}

	public function setPrazoMaximoPermitido($PrazoMaximoPermitido){
		$this->PrazoMaximoPermitido = $PrazoMaximoPermitido;
	}

	public function getPrazoMaximoPermitido(){
		return $this->PrazoMaximoPermitido;
	}

	public function setAtivo($Ativo){
		$this->Ativo = $Ativo;
	}

	public function getAtivo(){
		return $this->Ativo;
	}

	public function toHash(){
		 return $this->PropostaConfigID;
	}

	public function toString(){
		return $this->PropostaConfigID . " - " . $this->JurosMaximoPermitido . " - " . $this->PrazoMaximoPermitido . " - " . $this->Ativo;
	}

}
?>