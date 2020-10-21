<?php 
class PropostasAnalisesRiscos { 

	const TABLE_NAME = "tblPropostasAnalisesRiscos";
	const COLUMN_KEY = "PropRiscoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PropRiscoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropostaDetalheID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropRiscoConclusaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropRiscoArquivoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "20", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropRiscoNumParecer;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropRiscoData;

	/**
	* @var "TYPE" => "string", "LENGTH" => "10", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropRiscoRating;

	/**
	* @var "TYPE" => "double", "LENGTH" => "9", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropTaxaNominal;

	/**
	* @var "TYPE" => "string", "LENGTH" => "2000", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropRiscoObs;


	public function setPropRiscoID($PropRiscoID){
		$this->PropRiscoID = $PropRiscoID;
	}

	public function getPropRiscoID(){
		return $this->PropRiscoID;
	}

	public function setPropostaDetalheID($PropostaDetalheID){
		$this->PropostaDetalheID = $PropostaDetalheID;
	}

	public function getPropostaDetalheID(){
		return $this->PropostaDetalheID;
	}

	public function setPropRiscoConclusaoID($PropRiscoConclusaoID){
		$this->PropRiscoConclusaoID = $PropRiscoConclusaoID;
	}

	public function getPropRiscoConclusaoID(){
		return $this->PropRiscoConclusaoID;
	}

	public function setPropRiscoArquivoID($PropRiscoArquivoID){
		$this->PropRiscoArquivoID = $PropRiscoArquivoID;
	}

	public function getPropRiscoArquivoID(){
		return $this->PropRiscoArquivoID;
	}

	public function setPropRiscoNumParecer($PropRiscoNumParecer){
		$this->PropRiscoNumParecer = $PropRiscoNumParecer;
	}

	public function getPropRiscoNumParecer(){
		return $this->PropRiscoNumParecer;
	}

	public function setPropRiscoData($PropRiscoData){
		$this->PropRiscoData = $PropRiscoData;
	}

	public function getPropRiscoData($mascara = 'Y-m-d H:i:s'){
		if ($this->PropRiscoData != null){
			return date($mascara, strtotime(str_replace('/','-', $this->PropRiscoData)));
		} else {
			return $this->PropRiscoData;
		}
	}

	public function setPropRiscoRating($PropRiscoRating){
		$this->PropRiscoRating = $PropRiscoRating;
	}

	public function getPropRiscoRating(){
		return $this->PropRiscoRating;
	}

	public function setPropTaxaNominal($PropTaxaNominal){
		$this->PropTaxaNominal = $PropTaxaNominal;
	}

	public function getPropTaxaNominal(){
		return $this->PropTaxaNominal;
	}

	public function setPropRiscoObs($PropRiscoObs){
		$this->PropRiscoObs = $PropRiscoObs;
	}

	public function getPropRiscoObs(){
		return $this->PropRiscoObs;
	}

	public function toHash(){
		 return $this->PropRiscoID;
	}

	public function toString(){
		return $this->PropRiscoID . " - " . $this->PropostaDetalheID . " - " . $this->PropRiscoConclusaoID . " - " . $this->PropRiscoArquivoID . " - " . $this->PropRiscoNumParecer . " - " . $this->PropRiscoData . " - " . $this->PropRiscoRating . " - " . $this->PropTaxaNominal . " - " . $this->PropRiscoObs;
	}

}
?>