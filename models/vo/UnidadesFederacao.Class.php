<?php 
class UnidadesFederacao { 

	const TABLE_NAME = "tblUnidadesFederacao";
	const COLUMN_KEY = "UnidadeFederacaoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $UnidadeFederacaoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $UnidadeFederacaoSigla;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $UnidadeFederacaoNome;


	public function setUnidadeFederacaoID($UnidadeFederacaoID){
		$this->UnidadeFederacaoID = $UnidadeFederacaoID;
	}

	public function getUnidadeFederacaoID(){
		return $this->UnidadeFederacaoID;
	}

	public function setUnidadeFederacaoSigla($UnidadeFederacaoSigla){
		$this->UnidadeFederacaoSigla = $UnidadeFederacaoSigla;
	}

	public function getUnidadeFederacaoSigla(){
		return $this->UnidadeFederacaoSigla;
	}

	public function setUnidadeFederacaoNome($UnidadeFederacaoNome){
		$this->UnidadeFederacaoNome = $UnidadeFederacaoNome;
	}

	public function getUnidadeFederacaoNome(){
		return $this->UnidadeFederacaoNome;
	}

	public function toHash(){
		 return $this->UnidadeFederacaoID;
	}

	public function toString(){
		return $this->UnidadeFederacaoID . " - " . $this->UnidadeFederacaoSigla . " - " . $this->UnidadeFederacaoNome;
	}

}
?>