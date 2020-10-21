<?php 
class DiasAnos { 

	const TABLE_NAME = "tblDiasAnos";
	const COLUMN_KEY = "DiasAnoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $DiasAnoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $DiasAnoQuantidade;


	public function setDiasAnoID($DiasAnoID){
		$this->DiasAnoID = $DiasAnoID;
	}

	public function getDiasAnoID(){
		return $this->DiasAnoID;
	}

	public function setDiasAnoQuantidade($DiasAnoQuantidade){
		$this->DiasAnoQuantidade = $DiasAnoQuantidade;
	}

	public function getDiasAnoQuantidade(){
		return $this->DiasAnoQuantidade;
	}

	public function toHash(){
		 return $this->DiasAnoID;
	}

	public function toString(){
		return $this->DiasAnoID . " - " . $this->DiasAnoQuantidade;
	}

}
?>