<?php 
class CapturaDadosConta { 

	const TABLE_NAME = "tblCapturaDadosConta";
	const COLUMN_KEY = "Id";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $Id;

	/**
	* @var "TYPE" => "date", "LENGTH" => "3", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $DataAprop;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Historico;

	/**
	* @var "TYPE" => "double", "LENGTH" => "9", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Valor;


	public function setId($Id){
		$this->Id = $Id;
	}

	public function getId(){
		return $this->Id;
	}

	public function setDataAprop($DataAprop){
		$this->DataAprop = $DataAprop;
	}

	public function getDataAprop($mascara = 'Y-m-d H:i:s'){
		if ($this->DataAprop != null){
			return date($mascara, strtotime(str_replace('/','-', $this->DataAprop)));
		} else {
			return $this->DataAprop;
		}
	}

	public function setHistorico($Historico){
		$this->Historico = $Historico;
	}

	public function getHistorico(){
		return $this->Historico;
	}

	public function setValor($Valor){
		$this->Valor = $Valor;
	}

	public function getValor(){
		return $this->Valor;
	}

	public function toHash(){
		 return $this->Id;
	}

	public function toString(){
		return $this->Id . " - " . $this->DataAprop . " - " . $this->Historico . " - " . $this->Valor;
	}

}
?>