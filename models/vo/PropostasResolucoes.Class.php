<?php 
class PropostasResolucoes { 

	const TABLE_NAME = "tblPropostasResolucoes";
	const COLUMN_KEY = "PropResolucaoConselhoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PropResolucaoConselhoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropostaDetalheID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropResolucaoConclusaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropResolucaoArquivoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "20", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropResolucaoNumero;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropResolucaoData;

	/**
	* @var "TYPE" => "string", "LENGTH" => "2000", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropResolucaoObs;


	public function setPropResolucaoConselhoID($PropResolucaoConselhoID){
		$this->PropResolucaoConselhoID = $PropResolucaoConselhoID;
	}

	public function getPropResolucaoConselhoID(){
		return $this->PropResolucaoConselhoID;
	}

	public function setPropostaDetalheID($PropostaDetalheID){
		$this->PropostaDetalheID = $PropostaDetalheID;
	}

	public function getPropostaDetalheID(){
		return $this->PropostaDetalheID;
	}

	public function setPropResolucaoConclusaoID($PropResolucaoConclusaoID){
		$this->PropResolucaoConclusaoID = $PropResolucaoConclusaoID;
	}

	public function getPropResolucaoConclusaoID(){
		return $this->PropResolucaoConclusaoID;
	}

	public function setPropResolucaoArquivoID($PropResolucaoArquivoID){
		$this->PropResolucaoArquivoID = $PropResolucaoArquivoID;
	}

	public function getPropResolucaoArquivoID(){
		return $this->PropResolucaoArquivoID;
	}

	public function setPropResolucaoNumero($PropResolucaoNumero){
		$this->PropResolucaoNumero = $PropResolucaoNumero;
	}

	public function getPropResolucaoNumero(){
		return $this->PropResolucaoNumero;
	}

	public function setPropResolucaoData($PropResolucaoData){
		$this->PropResolucaoData = $PropResolucaoData;
	}

	public function getPropResolucaoData($mascara = 'Y-m-d H:i:s'){
		if ($this->PropResolucaoData != null){
			return date($mascara, strtotime(str_replace('/','-', $this->PropResolucaoData)));
		} else {
			return $this->PropResolucaoData;
		}
	}

	public function setPropResolucaoObs($PropResolucaoObs){
		$this->PropResolucaoObs = $PropResolucaoObs;
	}

	public function getPropResolucaoObs(){
		return $this->PropResolucaoObs;
	}

	public function toHash(){
		 return $this->PropResolucaoConselhoID;
	}

	public function toString(){
		return $this->PropResolucaoConselhoID . " - " . $this->PropostaDetalheID . " - " . $this->PropResolucaoConclusaoID . " - " . $this->PropResolucaoArquivoID . " - " . $this->PropResolucaoNumero . " - " . $this->PropResolucaoData . " - " . $this->PropResolucaoObs;
	}

}
?>