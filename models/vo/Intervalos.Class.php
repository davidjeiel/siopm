<?php 
class Intervalos { 

	const TABLE_NAME = "tblIntervalos";
	const COLUMN_KEY = "IntervaloID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $IntervaloID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $IntervaloNome;


	public function setIntervaloID($IntervaloID){
		$this->IntervaloID = $IntervaloID;
	}

	public function getIntervaloID(){
		return $this->IntervaloID;
	}

	public function setIntervaloNome($IntervaloNome){
		$this->IntervaloNome = $IntervaloNome;
	}

	public function getIntervaloNome(){
		return $this->IntervaloNome;
	}

	public function toHash(){
		 return $this->IntervaloID;
	}

	public function toString(){
		return $this->IntervaloID . " - " . $this->IntervaloNome;
	}

}
?>