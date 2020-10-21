<?php 
class Unidades { 

	const TABLE_NAME = "tblUnidades";
	const COLUMN_KEY = "UnidadeID";

	/**
	* @var "TYPE" => "string", "LENGTH" => "8", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $UnidadeID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "20", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $UnidadeSigla;

	/**
	* @var "TYPE" => "string", "LENGTH" => "200", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $UnidadeNome;

	/**
	* @var "TYPE" => "string", "LENGTH" => "200", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $UnidadeEmail;

	/**
	* @var "TYPE" => "string", "LENGTH" => "510", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $UnidadeDescricao;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PodeHabilitar;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $UnidadeAtiva;


	public function setUnidadeID($UnidadeID){
		$this->UnidadeID = $UnidadeID;
	}

	public function getUnidadeID(){
		return $this->UnidadeID;
	}

	public function setUnidadeSigla($UnidadeSigla){
		$this->UnidadeSigla = $UnidadeSigla;
	}

	public function getUnidadeSigla(){
		return $this->UnidadeSigla;
	}

	public function setUnidadeNome($UnidadeNome){
		$this->UnidadeNome = $UnidadeNome;
	}

	public function getUnidadeNome(){
		return $this->UnidadeNome;
	}

	public function setUnidadeEmail($UnidadeEmail){
		$this->UnidadeEmail = $UnidadeEmail;
	}

	public function getUnidadeEmail(){
		return $this->UnidadeEmail;
	}

	public function setUnidadeDescricao($UnidadeDescricao){
		$this->UnidadeDescricao = $UnidadeDescricao;
	}

	public function getUnidadeDescricao(){
		return $this->UnidadeDescricao;
	}

	public function setPodeHabilitar($PodeHabilitar){
		$this->PodeHabilitar = $PodeHabilitar;
	}

	public function getPodeHabilitar(){
		return $this->PodeHabilitar;
	}
	
	public function setUnidadeAtiva($UnidadeAtiva){
		$this->UnidadeAtiva = $UnidadeAtiva;
	}

	public function getUnidadeAtiva(){
		return $this->UnidadeAtiva;
	}

	public function toHash(){
		 return $this->UnidadeID;
	}

	public function toString(){
		return $this->UnidadeID . " - " . $this->UnidadeSigla . " - " . $this->UnidadeNome . " - " . $this->UnidadeEmail . " - " . $this->UnidadeDescricao . " - " . $this->PodeHabilitar. " - " . $this->UnidadeAtiva;
	}

}
?>