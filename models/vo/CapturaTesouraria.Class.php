<?php 
class CapturaTesouraria { 

	const TABLE_NAME = "tblCapturaTesouraria";
	const COLUMN_KEY = "Id";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $Id;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $CapturaControleID;

	/**
	* @var "TYPE" => "date", "LENGTH" => "3", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Data;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Historico;

	/**
	* @var "TYPE" => "double", "LENGTH" => "9", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Valor;

	/**
	* @var "TYPE" => "date", "LENGTH" => "3", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $DataConciliacao;


	public function setId($Id){
		$this->Id = $Id;
	}

	public function getId(){
		return $this->Id;
	}

	public function setCapturaControleID($CapturaControleID){
		$this->CapturaControleID = $CapturaControleID;
	}

	public function getCapturaControleID(){
		return $this->CapturaControleID;
	}

	public function setData($Data){
		$this->Data = $Data;
	}

	public function getData($mascara = 'Y-m-d H:i:s'){
		if ($this->Data != null){
			return date($mascara, strtotime(str_replace('/','-', $this->Data)));
		} else {
			return $this->Data;
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

	public function setDataConciliacao($DataConciliacao){
		$this->DataConciliacao = $DataConciliacao;
	}

	public function getDataConciliacao($mascara = 'Y-m-d H:i:s'){
		if ($this->DataConciliacao != null){
			return date($mascara, strtotime(str_replace('/','-', $this->DataConciliacao)));
		} else {
			return $this->DataConciliacao;
		}
	}

	public function toHash(){
		 return $this->Id;
	}

	public function toString(){
		return $this->Id . " - " . $this->CapturaControleID . " - " . $this->Data . " - " . $this->Historico . " - " . $this->Valor . " - " . $this->DataConciliacao;
	}

}
?>