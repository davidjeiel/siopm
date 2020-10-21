<?php 
class PerfisFuncionalidades { 

	const TABLE_NAME = "tblPerfisFuncionalidades";
	const COLUMN_KEY = "PerfilFuncionalidadeID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PerfilFuncionalidadeID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PerfilID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $FuncionalidadeID;


	public function setPerfilFuncionalidadeID($PerfilFuncionalidadeID){
		$this->PerfilFuncionalidadeID = $PerfilFuncionalidadeID;
	}

	public function getPerfilFuncionalidadeID(){
		return $this->PerfilFuncionalidadeID;
	}

	public function setPerfilID($PerfilID){
		$this->PerfilID = $PerfilID;
	}

	public function getPerfilID(){
		return $this->PerfilID;
	}

	public function setFuncionalidadeID($FuncionalidadeID){
		$this->FuncionalidadeID = $FuncionalidadeID;
	}

	public function getFuncionalidadeID(){
		return $this->FuncionalidadeID;
	}

	public function toHash(){
		 return $this->PerfilFuncionalidadeID;
	}

	public function toString(){
		return $this->PerfilFuncionalidadeID . " - " . $this->PerfilID . " - " . $this->FuncionalidadeID;
	}

}
?>