<?php 
class Juros { 

	const TABLE_NAME = "tblJuros";
	const COLUMN_KEY = "JurosID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $JurosID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $AtivoID;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $JurosDataInicialVigencia;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $JurosDataFinalVigencia;

	/**
	* @var "TYPE" => "double", "LENGTH" => "5", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $JurosTaxaNominal;

	/**
	* @var "TYPE" => "double", "LENGTH" => "5", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $JurosTaxaEfetiva;


	public function setJurosID($JurosID){
		$this->JurosID = $JurosID;
	}

	public function getJurosID(){
		return $this->JurosID;
	}

	public function setAtivoID($AtivoID){
		$this->AtivoID = $AtivoID;
	}

	public function getAtivoID(){
		return $this->AtivoID;
	}

	public function setJurosDataInicialVigencia($JurosDataInicialVigencia){
		$this->JurosDataInicialVigencia = $JurosDataInicialVigencia;
	}

	public function getJurosDataInicialVigencia($mascara = 'Y-m-d H:i:s'){
		if ($this->JurosDataInicialVigencia != null){
			return date($mascara, strtotime(str_replace('/','-', $this->JurosDataInicialVigencia)));
		} else {
			return $this->JurosDataInicialVigencia;
		}
	}

	public function setJurosDataFinalVigencia($JurosDataFinalVigencia){
		$this->JurosDataFinalVigencia = $JurosDataFinalVigencia;
	}

	public function getJurosDataFinalVigencia($mascara = 'Y-m-d H:i:s'){
		if ($this->JurosDataFinalVigencia != null){
			return date($mascara, strtotime(str_replace('/','-', $this->JurosDataFinalVigencia)));
		} else {
			return $this->JurosDataFinalVigencia;
		}
	}

	public function setJurosTaxaNominal($JurosTaxaNominal){
		$this->JurosTaxaNominal = $JurosTaxaNominal;
	}

	public function getJurosTaxaNominal(){
		return $this->JurosTaxaNominal;
	}

	public function setJurosTaxaEfetiva($JurosTaxaEfetiva){
		$this->JurosTaxaEfetiva = $JurosTaxaEfetiva;
	}

	public function getJurosTaxaEfetiva(){
		return $this->JurosTaxaEfetiva;
	}

	public function toHash(){
		 return $this->JurosID;
	}

	public function toString(){
		return $this->JurosID . " - " . $this->AtivoID . " - " . $this->JurosDataInicialVigencia . " - " . $this->JurosDataFinalVigencia . " - " . $this->JurosTaxaNominal . " - " . $this->JurosTaxaEfetiva;
	}

}
?>