<?php 
class HabilitacoesAnalisesRiscos { 

	const TABLE_NAME = "tblHabilitacoesAnalisesRiscos";
	const COLUMN_KEY = "HabRiscoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $HabRiscoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $HabilitacaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabRiscoConclusaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabRiscoArquivoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "20", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabRiscoNumero;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabRiscoData;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabRiscoValidade;

	/**
	* @var "TYPE" => "string", "LENGTH" => "10", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabRiscoRating;

	/**
	* @var "TYPE" => "string", "LENGTH" => "2000", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabRiscoConsideracaoes;


	public function setHabRiscoID($HabRiscoID){
		$this->HabRiscoID = $HabRiscoID;
	}

	public function getHabRiscoID(){
		return $this->HabRiscoID;
	}

	public function setHabilitacaoID($HabilitacaoID){
		$this->HabilitacaoID = $HabilitacaoID;
	}

	public function getHabilitacaoID(){
		return $this->HabilitacaoID;
	}

	public function setHabRiscoConclusaoID($HabRiscoConclusaoID){
		$this->HabRiscoConclusaoID = $HabRiscoConclusaoID;
	}

	public function getHabRiscoConclusaoID(){
		return $this->HabRiscoConclusaoID;
	}

	public function setHabRiscoArquivoID($HabRiscoArquivoID){
		$this->HabRiscoArquivoID = $HabRiscoArquivoID;
	}

	public function getHabRiscoArquivoID(){
		return $this->HabRiscoArquivoID;
	}

	public function setHabRiscoNumero($HabRiscoNumero){
		$this->HabRiscoNumero = $HabRiscoNumero;
	}

	public function getHabRiscoNumero(){
		return $this->HabRiscoNumero;
	}

	public function setHabRiscoData($HabRiscoData){
		$this->HabRiscoData = $HabRiscoData;
	}

	public function getHabRiscoData($mascara = 'Y-m-d H:i:s'){
		if ($this->HabRiscoData != null){
			return date($mascara, strtotime(str_replace('/','-', $this->HabRiscoData)));
		} else {
			return $this->HabRiscoData;
		}
	}

	public function setHabRiscoValidade($HabRiscoValidade){
		$this->HabRiscoValidade = $HabRiscoValidade;
	}

	public function getHabRiscoValidade($mascara = 'Y-m-d H:i:s'){
		if ($this->HabRiscoValidade != null){
			return date($mascara, strtotime(str_replace('/','-', $this->HabRiscoValidade)));
		} else {
			return $this->HabRiscoValidade;
		}
	}

	public function setHabRiscoRating($HabRiscoRating){
		$this->HabRiscoRating = $HabRiscoRating;
	}

	public function getHabRiscoRating(){
		return $this->HabRiscoRating;
	}

	public function setHabRiscoConsideracaoes($HabRiscoConsideracaoes){
		$this->HabRiscoConsideracaoes = $HabRiscoConsideracaoes;
	}

	public function getHabRiscoConsideracaoes(){
		return $this->HabRiscoConsideracaoes;
	}

	public function toHash(){
		 return $this->HabRiscoID;
	}

	public function toString(){
		return $this->HabRiscoID . " - " . $this->HabilitacaoID . " - " . $this->HabRiscoConclusaoID . " - " . $this->HabRiscoArquivoID . " - " . $this->HabRiscoNumero . " - " . $this->HabRiscoData . " - " . $this->HabRiscoValidade . " - " . $this->HabRiscoRating . " - " . $this->HabRiscoConsideracaoes;
	}

}
?>