<?php 
class Feriados { 

	const TABLE_NAME = "tblFeriados";
	const COLUMN_KEY = "FeriadoData";

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $FeriadoData;

	/**
	* @var "TYPE" => "string", "LENGTH" => "510", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $FeriadoDiaSemana;

	/**
	* @var "TYPE" => "string", "LENGTH" => "510", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $FeriadoNome;


	public function setFeriadoData($FeriadoData){
		$this->FeriadoData = $FeriadoData;
	}

	public function getFeriadoData($mascara = 'Y-m-d H:i:s'){
		if ($this->FeriadoData != null){
			return date($mascara, strtotime(str_replace('/','-', $this->FeriadoData)));
		} else {
			return $this->FeriadoData;
		}
	}

	public function setFeriadoDiaSemana($FeriadoDiaSemana){
		$this->FeriadoDiaSemana = $FeriadoDiaSemana;
	}

	public function getFeriadoDiaSemana(){
		return $this->FeriadoDiaSemana;
	}

	public function setFeriadoNome($FeriadoNome){
		$this->FeriadoNome = $FeriadoNome;
	}

	public function getFeriadoNome(){
		return $this->FeriadoNome;
	}

	public function toHash(){
		 return $this->FeriadoData;
	}

	public function toString(){
		return $this->FeriadoData . " - " . $this->FeriadoDiaSemana . " - " . $this->FeriadoNome;
	}

}
?>