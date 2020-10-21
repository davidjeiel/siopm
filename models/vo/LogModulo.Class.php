<?php 
class LogModulo { 

	const TABLE_NAME = "tblLogModulo";
	const COLUMN_KEY = "ID";

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $TabelaPrincipal;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ChavePrimaria;

	/**
	* @var "TYPE" => "string", "LENGTH" => "300", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Descricao;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $Modulo;


	public function setID($ID){
		$this->ID = $ID;
	}

	public function getID(){
		return $this->ID;
	}

	public function setTabelaPrincipal($TabelaPrincipal){
		$this->TabelaPrincipal = $TabelaPrincipal;
	}

	public function getTabelaPrincipal(){
		return $this->TabelaPrincipal;
	}

	public function setChavePrimaria($ChavePrimaria){
		$this->ChavePrimaria = $ChavePrimaria;
	}

	public function getChavePrimaria(){
		return $this->ChavePrimaria;
	}

	public function setDescricao($Descricao){
		$this->Descricao = $Descricao;
	}

	public function getDescricao(){
		return $this->Descricao;
	}

	public function setModulo($Modulo){
		$this->Modulo = $Modulo;
	}

	public function getModulo(){
		return $this->Modulo;
	}

	public function toHash(){
		 return $this->ID;
	}

	public function toString(){
		return $this->ID . " - " . $this->TabelaPrincipal . " - " . $this->ChavePrimaria . " - " . $this->Descricao . " - " . $this->Modulo;
	}

}
?>