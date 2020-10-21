<?php 
class Transacoes { 

	const TABLE_NAME = "tblTransacoes";
	const COLUMN_KEY = "TransacaoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $TransacaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $AtivoID;

	/**
	* @var "TYPE" => "date", "LENGTH" => "3", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $TransacaoData;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $SaldoDevedor;


	public function setTransacaoID($TransacaoID){
		$this->TransacaoID = $TransacaoID;
	}

	public function getTransacaoID(){
		return $this->TransacaoID;
	}

	public function setAtivoID($AtivoID){
		$this->AtivoID = $AtivoID;
	}

	public function getAtivoID(){
		return $this->AtivoID;
	}

	public function setTransacaoData($TransacaoData){
		$this->TransacaoData = $TransacaoData;
	}

	public function getTransacaoData($mascara = 'Y-m-d H:i:s'){
		if ($this->TransacaoData != null){
			return date($mascara, strtotime(str_replace('/','-', $this->TransacaoData)));
		} else {
			return $this->TransacaoData;
		}
	}

	public function setSaldoDevedor($SaldoDevedor){
		$this->SaldoDevedor = $SaldoDevedor;
	}

	public function getSaldoDevedor(){
		return $this->SaldoDevedor;
	}

	public function toHash(){
		 return $this->TransacaoID;
	}

	public function toString(){
		return $this->TransacaoID . " - " . $this->AtivoID . " - " . $this->TransacaoData . " - " . $this->SaldoDevedor;
	}

}
?>