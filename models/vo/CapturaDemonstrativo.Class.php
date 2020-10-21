<?php 
class CapturaDemonstrativo { 

	const TABLE_NAME = "tblCapturaDemonstrativo";
	const COLUMN_KEY = "Id";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $Id;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $CapturaControleID;

	/**
	* @var "TYPE" => "date", "LENGTH" => "3", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Data;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $TitulosPrivados;

	/**
	* @var "TYPE" => "double", "LENGTH" => "9", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ValorContabil;

	/**
	* @var "TYPE" => "double", "LENGTH" => "9", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $TaxaRiscoProvisionada;

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

	public function setTitulosPrivados($TitulosPrivados){
		$this->TitulosPrivados = $TitulosPrivados;
	}

	public function getTitulosPrivados(){
		return $this->TitulosPrivados;
	}

	public function setValorContabil($ValorContabil){
		$this->ValorContabil = $ValorContabil;
	}

	public function getValorContabil(){
		return $this->ValorContabil;
	}

	public function setTaxaRiscoProvisionada($TaxaRiscoProvisionada){
		$this->TaxaRiscoProvisionada = $TaxaRiscoProvisionada;
	}

	public function getTaxaRiscoProvisionada(){
		return $this->TaxaRiscoProvisionada;
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
		return $this->Id . " - " . $this->CapturaControleID . " - " . $this->Data . " - " . $this->TitulosPrivados . " - " . $this->ValorContabil . " - " . $this->TaxaRiscoProvisionada . " - " . $this->DataConciliacao;
	}

}
?>