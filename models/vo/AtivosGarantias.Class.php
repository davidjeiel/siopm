<?php 
class AtivosGarantias { 

	const TABLE_NAME = "tblAtivosGarantias";
	const COLUMN_KEY = "AtivoGarantiaID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $AtivoGarantiaID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $GarantiaID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $AtivoID;


	public function setAtivoGarantiaID($AtivoGarantiaID){
		$this->AtivoGarantiaID = $AtivoGarantiaID;
	}

	public function getAtivoGarantiaID(){
		return $this->AtivoGarantiaID;
	}

	public function setGarantiaID($GarantiaID){
		$this->GarantiaID = $GarantiaID;
	}

	public function getGarantiaID(){
		return $this->GarantiaID;
	}

	public function setAtivoID($AtivoID){
		$this->AtivoID = $AtivoID;
	}

	public function getAtivoID(){
		return $this->AtivoID;
	}

	public function toHash(){
		 return $this->AtivoGarantiaID;
	}

	public function toString(){
		return $this->AtivoGarantiaID . " - " . $this->GarantiaID . " - " . $this->AtivoID;
	}

}
?>