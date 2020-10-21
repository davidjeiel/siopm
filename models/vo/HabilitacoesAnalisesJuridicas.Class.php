<?php 
class HabilitacoesAnalisesJuridicas { 

	const TABLE_NAME = "tblHabilitacoesAnalisesJuridicas";
	const COLUMN_KEY = "HabJuridicaID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $HabJuridicaID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $HabilitacaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabJuridicaConclusaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabJuridicaArquivoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabJuridicaNumero;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabJuridicaData;

	/**
	* @var "TYPE" => "string", "LENGTH" => "2000", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabJuridicaConsideracaoes;


	public function setHabJuridicaID($HabJuridicaID){
		$this->HabJuridicaID = $HabJuridicaID;
	}

	public function getHabJuridicaID(){
		return $this->HabJuridicaID;
	}

	public function setHabilitacaoID($HabilitacaoID){
		$this->HabilitacaoID = $HabilitacaoID;
	}

	public function getHabilitacaoID(){
		return $this->HabilitacaoID;
	}

	public function setHabJuridicaConclusaoID($HabJuridicaConclusaoID){
		$this->HabJuridicaConclusaoID = $HabJuridicaConclusaoID;
	}

	public function getHabJuridicaConclusaoID(){
		return $this->HabJuridicaConclusaoID;
	}

	public function setHabJuridicaArquivoID($HabJuridicaArquivoID){
		$this->HabJuridicaArquivoID = $HabJuridicaArquivoID;
	}

	public function getHabJuridicaArquivoID(){
		return $this->HabJuridicaArquivoID;
	}

	public function setHabJuridicaNumero($HabJuridicaNumero){
		$this->HabJuridicaNumero = $HabJuridicaNumero;
	}

	public function getHabJuridicaNumero(){
		return $this->HabJuridicaNumero;
	}

	public function setHabJuridicaData($HabJuridicaData){
		$this->HabJuridicaData = $HabJuridicaData;
	}

	public function getHabJuridicaData($mascara = 'Y-m-d H:i:s'){
		if ($this->HabJuridicaData != null){
			return date($mascara, strtotime(str_replace('/','-', $this->HabJuridicaData)));
		} else {
			return $this->HabJuridicaData;
		}
	}

	public function setHabJuridicaConsideracaoes($HabJuridicaConsideracaoes){
		$this->HabJuridicaConsideracaoes = $HabJuridicaConsideracaoes;
	}

	public function getHabJuridicaConsideracaoes(){
		return $this->HabJuridicaConsideracaoes;
	}

	public function toHash(){
		 return $this->HabJuridicaID;
	}

	public function toString(){
		return $this->HabJuridicaID . " - " . $this->HabilitacaoID . " - " . $this->HabJuridicaConclusaoID . " - " . $this->HabJuridicaArquivoID . " - " . $this->HabJuridicaNumero . " - " . $this->HabJuridicaData . " - " . $this->HabJuridicaConsideracaoes;
	}

}
?>