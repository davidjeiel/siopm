<?php 
class LogTabelasModulos { 

	const TABLE_NAME = "tblLogTabelasModulos";
	const COLUMN_KEY = "ID";

	/**
	* @var "TYPE" => "string", "LENGTH" => "200", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Modulo;


	public function setID($ID){
		$this->ID = $ID;
	}

	public function getID(){
		return $this->ID;
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
		return $this->ID . " - " . $this->Modulo;
	}

}
?>