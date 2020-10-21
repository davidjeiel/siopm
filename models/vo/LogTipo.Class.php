<?php 
class LogTipo { 

	const TABLE_NAME = "tblLogTipo";
	const COLUMN_KEY = "ID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $ID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Descricao;


	public function setID($ID){
		$this->ID = $ID;
	}

	public function getID(){
		return $this->ID;
	}

	public function setDescricao($Descricao){
		$this->Descricao = $Descricao;
	}

	public function getDescricao(){
		return $this->Descricao;
	}

	public function toHash(){
		 return $this->ID;
	}

	public function toString(){
		return $this->ID . " - " . $this->Descricao;
	}

}
?>