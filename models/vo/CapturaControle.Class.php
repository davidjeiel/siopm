<?php 
class CapturaControle { 

	const TABLE_NAME = "tblCapturaControle";
	const COLUMN_KEY = "Id";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $Id;

	/**
	* @var "TYPE" => "date", "LENGTH" => "3", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Data;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ArquivoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "7", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Importador;

	/**
	* @var "TYPE" => "date", "LENGTH" => "3", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $DataCaptura;

	/**
	* @var "TYPE" => "date", "LENGTH" => "3", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $DataConciliacao;

	/**
	* @var "TYPE" => "string", "LENGTH" => "7", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $Conciliador;


	public function setId($Id){
		$this->Id = $Id;
	}

	public function getId(){
		return $this->Id;
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

	public function setArquivoID($ArquivoID){
		$this->ArquivoID = $ArquivoID;
	}

	public function getArquivoID(){
		return $this->ArquivoID;
	}

	public function setImportador($Importador){
		$this->Importador = $Importador;
	}

	public function getImportador(){
		return $this->Importador;
	}

	public function setDataCaptura($DataCaptura){
		$this->DataCaptura = $DataCaptura;
	}

	public function getDataCaptura($mascara = 'Y-m-d H:i:s'){
		if ($this->DataCaptura != null){
			return date($mascara, strtotime(str_replace('/','-', $this->DataCaptura)));
		} else {
			return $this->DataCaptura;
		}
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

	public function setConciliador($Conciliador){
		$this->Conciliador = $Conciliador;
	}

	public function getConciliador(){
		return $this->Conciliador;
	}

	public function toHash(){
		 return $this->Id;
	}

	public function toString(){
		return $this->Id . " - " . $this->Data . " - " . $this->ArquivoID . " - " . $this->Importador . " - " . $this->DataCaptura . " - " . $this->DataConciliacao . " - " . $this->Conciliador;
	}

}
?>