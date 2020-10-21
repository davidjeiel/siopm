<?php 
class Funcionalidades { 

	const TABLE_NAME = "tblFuncionalidades";
	const COLUMN_KEY = "FuncionalidadeID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $FuncionalidadeID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "200", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $FuncionalidadeNome;

	/**
	* @var "TYPE" => "string", "LENGTH" => "510", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $FuncionalidadeDescricao;


	public function setFuncionalidadeID($FuncionalidadeID){
		$this->FuncionalidadeID = $FuncionalidadeID;
	}

	public function getFuncionalidadeID(){
		return $this->FuncionalidadeID;
	}

	public function setFuncionalidadeNome($FuncionalidadeNome){
		$this->FuncionalidadeNome = $FuncionalidadeNome;
	}

	public function getFuncionalidadeNome(){
		return $this->FuncionalidadeNome;
	}

	public function setFuncionalidadeDescricao($FuncionalidadeDescricao){
		$this->FuncionalidadeDescricao = $FuncionalidadeDescricao;
	}

	public function getFuncionalidadeDescricao(){
		return $this->FuncionalidadeDescricao;
	}

	public function toHash(){
		 return $this->FuncionalidadeID;
	}

	public function toString(){
		return $this->FuncionalidadeID . " - " . $this->FuncionalidadeNome . " - " . $this->FuncionalidadeDescricao;
	}

}
?>