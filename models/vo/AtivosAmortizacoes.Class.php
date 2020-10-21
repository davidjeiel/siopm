<?php 
class AtivosAmortizacoes { 

	const TABLE_NAME = "tblAtivosAmortizacoes";
	const COLUMN_KEY = "AtivoAmortizacaoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $AtivoAmortizacaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoID;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoAmortizacaoData;

	/**
	* @var "TYPE" => "double", "LENGTH" => "5", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoAmortizacaoPercentual;


	public function setAtivoAmortizacaoID($AtivoAmortizacaoID){
		$this->AtivoAmortizacaoID = $AtivoAmortizacaoID;
	}

	public function getAtivoAmortizacaoID(){
		return $this->AtivoAmortizacaoID;
	}

	public function setAtivoID($AtivoID){
		$this->AtivoID = $AtivoID;
	}

	public function getAtivoID(){
		return $this->AtivoID;
	}

	public function setAtivoAmortizacaoData($AtivoAmortizacaoData){
		$this->AtivoAmortizacaoData = $AtivoAmortizacaoData;
	}

	public function getAtivoAmortizacaoData($mascara = 'Y-m-d H:i:s'){
		if ($this->AtivoAmortizacaoData != null){
			return date($mascara, strtotime(str_replace('/','-', $this->AtivoAmortizacaoData)));
		} else {
			return $this->AtivoAmortizacaoData;
		}
	}

	public function setAtivoAmortizacaoPercentual($AtivoAmortizacaoPercentual){
		$this->AtivoAmortizacaoPercentual = $AtivoAmortizacaoPercentual;
	}

	public function getAtivoAmortizacaoPercentual(){
		return $this->AtivoAmortizacaoPercentual;
	}

	public function toHash(){
		 return $this->AtivoAmortizacaoID;
	}

	public function toString(){
		return $this->AtivoAmortizacaoID . " - " . $this->AtivoID . " - " . $this->AtivoAmortizacaoData . " - " . $this->AtivoAmortizacaoPercentual;
	}

}
?>