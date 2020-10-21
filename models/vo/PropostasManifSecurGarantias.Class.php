<?php 
class PropostasManifSecurGarantias { 

	const TABLE_NAME = "tblPropostasManifSecurGarantias";
	const COLUMN_KEY = "PropManifSecurGarantiaID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PropManifSecurGarantiaID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropManifSecurID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $GarantiaID;


	public function setPropManifSecurGarantiaID($PropManifSecurGarantiaID){
		$this->PropManifSecurGarantiaID = $PropManifSecurGarantiaID;
	}

	public function getPropManifSecurGarantiaID(){
		return $this->PropManifSecurGarantiaID;
	}

	public function setPropManifSecurID($PropManifSecurID){
		$this->PropManifSecurID = $PropManifSecurID;
	}

	public function getPropManifSecurID(){
		return $this->PropManifSecurID;
	}

	public function setGarantiaID($GarantiaID){
		$this->GarantiaID = $GarantiaID;
	}

	public function getGarantiaID(){
		return $this->GarantiaID;
	}

	public function toHash(){
		 return $this->PropManifSecurGarantiaID;
	}

	public function toString(){
		return $this->PropManifSecurGarantiaID . " - " . $this->PropManifSecurID . " - " . $this->GarantiaID;
	}

}
?>