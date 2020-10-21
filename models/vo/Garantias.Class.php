<?php 
class Garantias { 

	const TABLE_NAME = "tblGarantias";
	const COLUMN_KEY = "GarantiaID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $GarantiaID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $GarantiaNome;


	public function setGarantiaID($GarantiaID){
		$this->GarantiaID = $GarantiaID;
	}

	public function getGarantiaID(){
		return $this->GarantiaID;
	}

	public function setGarantiaNome($GarantiaNome){
		$this->GarantiaNome = $GarantiaNome;
	}

	public function getGarantiaNome(){
		return $this->GarantiaNome;
	}

	public function toHash(){
		 return $this->GarantiaID;
	}

	public function toString(){
		return $this->GarantiaID . " - " . $this->GarantiaNome;
	}

}
?>