<?php 
class HabilitacoesCertificacoes { 

	const TABLE_NAME = "tblHabilitacoesCertificacoes";
	const COLUMN_KEY = "HabCertID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $HabCertID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $HabilitacaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabCertConclusaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabCertArquivoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabCertNumero;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabCertData;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabCertValidade;

	/**
	* @var "TYPE" => "string", "LENGTH" => "10", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabCertRating;

	/**
	* @var "TYPE" => "string", "LENGTH" => "2000", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabCertConsideracoes;


	public function setHabCertID($HabCertID){
		$this->HabCertID = $HabCertID;
	}

	public function getHabCertID(){
		return $this->HabCertID;
	}

	public function setHabilitacaoID($HabilitacaoID){
		$this->HabilitacaoID = $HabilitacaoID;
	}

	public function getHabilitacaoID(){
		return $this->HabilitacaoID;
	}

	public function setHabCertConclusaoID($HabCertConclusaoID){
		$this->HabCertConclusaoID = $HabCertConclusaoID;
	}

	public function getHabCertConclusaoID(){
		return $this->HabCertConclusaoID;
	}

	public function setHabCertArquivoID($HabCertArquivoID){
		$this->HabCertArquivoID = $HabCertArquivoID;
	}

	public function getHabCertArquivoID(){
		return $this->HabCertArquivoID;
	}

	public function setHabCertNumero($HabCertNumero){
		$this->HabCertNumero = $HabCertNumero;
	}

	public function getHabCertNumero(){
		return $this->HabCertNumero;
	}

	public function setHabCertData($HabCertData){
		$this->HabCertData = $HabCertData;
	}

	public function getHabCertData($mascara = 'Y-m-d H:i:s'){
		if ($this->HabCertData != null){
			return date($mascara, strtotime(str_replace('/','-', $this->HabCertData)));
		} else {
			return $this->HabCertData;
		}
	}

	public function setHabCertValidade($HabCertValidade){
		$this->HabCertValidade = $HabCertValidade;
	}

	public function getHabCertValidade($mascara = 'Y-m-d H:i:s'){
		if ($this->HabCertValidade != null){
			return date($mascara, strtotime(str_replace('/','-', $this->HabCertValidade)));
		} else {
			return $this->HabCertValidade;
		}
	}

	public function setHabCertRating($HabCertRating){
		$this->HabCertRating = $HabCertRating;
	}

	public function getHabCertRating(){
		return $this->HabCertRating;
	}

	public function setHabCertConsideracoes($HabCertConsideracoes){
		$this->HabCertConsideracoes = $HabCertConsideracoes;
	}

	public function getHabCertConsideracoes(){
		return $this->HabCertConsideracoes;
	}

	public function toHash(){
		 return $this->HabCertID;
	}

	public function toString(){
		return $this->HabCertID . " - " . $this->HabilitacaoID . " - " . $this->HabCertConclusaoID . " - " . $this->HabCertArquivoID . " - " . $this->HabCertNumero . " - " . $this->HabCertData . " - " . $this->HabCertValidade . " - " . $this->HabCertRating . " - " . $this->HabCertConsideracoes;
	}

}
?>