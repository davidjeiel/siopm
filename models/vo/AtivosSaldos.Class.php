<?php 
class AtivosSaldos { 
 
	const TABLE_NAME = "tblAtivosSaldos";
	const COLUMN_KEY = "SaldoID";
	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $SaldoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $AtivoID;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $SaldoData;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $SaldoValor;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ProvisaoTaxaRisco;


	public function setSaldoID($SaldoID){
		$this->SaldoID = $SaldoID;
	}

	public function getSaldoID(){
		return $this->SaldoID;
	}

	public function setAtivoID($AtivoID){
		$this->AtivoID = $AtivoID;
	}

	public function getAtivoID(){
		return $this->AtivoID;
	}

	public function setSaldoData($SaldoData){
		$this->SaldoData = $SaldoData;
	}

	public function getSaldoData($mascara = 'Y-m-d H:i:s'){
		if ($this->SaldoData != null){
			return date($mascara, strtotime(str_replace('/','-', $this->SaldoData)));
		} else {
			return $this->SaldoData;
		}
	}

	public function setSaldoValor($SaldoValor){
		$this->SaldoValor = $SaldoValor;
	}

	public function getSaldoValor(){
		return $this->SaldoValor;
	}

	public function setProvisaoTaxaRisco($ProvisaoTaxaRisco){
		$this->ProvisaoTaxaRisco = $ProvisaoTaxaRisco;
	}

	public function getProvisaoTaxaRisco(){
		return $this->ProvisaoTaxaRisco;
	}

	public function toHash(){
		 return $this->SaldoID;
	}

	public function toString(){
		return $this->SaldoID . " - " . $this->AtivoID . " - " . $this->SaldoData . " - " . $this->SaldoValor . " - " . $this->ProvisaoTaxaRisco;
	}

}
?>