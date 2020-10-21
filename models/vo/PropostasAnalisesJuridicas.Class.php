<?php 
class PropostasAnalisesJuridicas { 

	const TABLE_NAME = "tblPropostasAnalisesJuridicas";
	const COLUMN_KEY = "PropJuridicaID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PropJuridicaID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropostaDetalheID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropJuridicaConclusaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropJuridicaArquivoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "20", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropJuridicaNumParecer;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropJuridicaData;

	/**
	* @var "TYPE" => "string", "LENGTH" => "2000", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropJuridicaObs;


	public function setPropJuridicaID($PropJuridicaID){
		$this->PropJuridicaID = $PropJuridicaID;
	}

	public function getPropJuridicaID(){
		return $this->PropJuridicaID;
	}

	public function setPropostaDetalheID($PropostaDetalheID){
		$this->PropostaDetalheID = $PropostaDetalheID;
	}

	public function getPropostaDetalheID(){
		return $this->PropostaDetalheID;
	}

	public function setPropJuridicaConclusaoID($PropJuridicaConclusaoID){
		$this->PropJuridicaConclusaoID = $PropJuridicaConclusaoID;
	}

	public function getPropJuridicaConclusaoID(){
		return $this->PropJuridicaConclusaoID;
	}

	public function setPropJuridicaArquivoID($PropJuridicaArquivoID){
		$this->PropJuridicaArquivoID = $PropJuridicaArquivoID;
	}

	public function getPropJuridicaArquivoID(){
		return $this->PropJuridicaArquivoID;
	}

	public function setPropJuridicaNumParecer($PropJuridicaNumParecer){
		$this->PropJuridicaNumParecer = $PropJuridicaNumParecer;
	}

	public function getPropJuridicaNumParecer(){
		return $this->PropJuridicaNumParecer;
	}

	public function setPropJuridicaData($PropJuridicaData){
		$this->PropJuridicaData = $PropJuridicaData;
	}

	public function getPropJuridicaData($mascara = 'Y-m-d H:i:s'){
		if ($this->PropJuridicaData != null){
			return date($mascara, strtotime(str_replace('/','-', $this->PropJuridicaData)));
		} else {
			return $this->PropJuridicaData;
		}
	}

	public function setPropJuridicaObs($PropJuridicaObs){
		$this->PropJuridicaObs = $PropJuridicaObs;
	}

	public function getPropJuridicaObs(){
		return $this->PropJuridicaObs;
	}

	public function toHash(){
		 return $this->PropJuridicaID;
	}

	public function toString(){
		return $this->PropJuridicaID . " - " . $this->PropostaDetalheID . " - " . $this->PropJuridicaConclusaoID . " - " . $this->PropJuridicaArquivoID . " - " . $this->PropJuridicaNumParecer . " - " . $this->PropJuridicaData . " - " . $this->PropJuridicaObs;
	}

}
?>