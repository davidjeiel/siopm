<?php 
class DiasBases { 

	const TABLE_NAME = "tblDiasBases";
	const COLUMN_KEY = "DiasBaseID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $DiasBaseID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $DiasBaseQuantidade;


	public function setDiasBaseID($DiasBaseID){
		$this->DiasBaseID = $DiasBaseID;
	}

	public function getDiasBaseID(){
		return $this->DiasBaseID;
	}

	public function setDiasBaseQuantidade($DiasBaseQuantidade){
		$this->DiasBaseQuantidade = $DiasBaseQuantidade;
	}

	public function getDiasBaseQuantidade(){
		return $this->DiasBaseQuantidade;
	}

	public function toHash(){
		 return $this->DiasBaseID;
	}

	public function toString(){
		return $this->DiasBaseID . " - " . $this->DiasBaseQuantidade;
	}

}
?>