<?php 
class PropostasEnquadramentos { 

	const TABLE_NAME = "tblPropostasEnquadramentos";
	const COLUMN_KEY = "PropostaEnquadramentoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PropostaEnquadramentoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropostaDetalheID;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ValorMaximo;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ValorMinimo;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ValorMedio;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ValorTotal;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PorcentagemMaxFianciamento;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PorcentagemMedFianciamento;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $TxJurosMaxima;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $TxJurosMinima;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $TxJurosMedia;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "2", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PrazoMaximo;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "2", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PrazoMinimo;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "2", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PrazoMedio;

	/**
	* @var "TYPE" => "string", "LENGTH" => "2000", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $Observacoes;


	public function setPropostaEnquadramentoID($PropostaEnquadramentoID){
		$this->PropostaEnquadramentoID = $PropostaEnquadramentoID;
	}

	public function getPropostaEnquadramentoID(){
		return $this->PropostaEnquadramentoID;
	}

	public function setPropostaDetalheID($PropostaDetalheID){
		$this->PropostaDetalheID = $PropostaDetalheID;
	}

	public function getPropostaDetalheID(){
		return $this->PropostaDetalheID;
	}

	public function setValorMaximo($ValorMaximo){
		$this->ValorMaximo = $ValorMaximo;
	}

	public function getValorMaximo(){
		return $this->ValorMaximo;
	}

	public function setValorMinimo($ValorMinimo){
		$this->ValorMinimo = $ValorMinimo;
	}

	public function getValorMinimo(){
		return $this->ValorMinimo;
	}

	public function setValorMedio($ValorMedio){
		$this->ValorMedio = $ValorMedio;
	}

	public function getValorMedio(){
		return $this->ValorMedio;
	}

	public function setValorTotal($ValorTotal){
		$this->ValorTotal = $ValorTotal;
	}

	public function getValorTotal(){
		return $this->ValorTotal;
	}

	public function setPorcentagemMaxFianciamento($PorcentagemMaxFianciamento){
		$this->PorcentagemMaxFianciamento = $PorcentagemMaxFianciamento;
	}

	public function getPorcentagemMaxFianciamento(){
		return $this->PorcentagemMaxFianciamento;
	}

	public function setPorcentagemMedFianciamento($PorcentagemMedFianciamento){
		$this->PorcentagemMedFianciamento = $PorcentagemMedFianciamento;
	}

	public function getPorcentagemMedFianciamento(){
		return $this->PorcentagemMedFianciamento;
	}

	public function setTxJurosMaxima($TxJurosMaxima){
		$this->TxJurosMaxima = $TxJurosMaxima;
	}

	public function getTxJurosMaxima(){
		return $this->TxJurosMaxima;
	}

	public function setTxJurosMinima($TxJurosMinima){
		$this->TxJurosMinima = $TxJurosMinima;
	}

	public function getTxJurosMinima(){
		return $this->TxJurosMinima;
	}

	public function setTxJurosMedia($TxJurosMedia){
		$this->TxJurosMedia = $TxJurosMedia;
	}

	public function getTxJurosMedia(){
		return $this->TxJurosMedia;
	}

	public function setPrazoMaximo($PrazoMaximo){
		$this->PrazoMaximo = $PrazoMaximo;
	}

	public function getPrazoMaximo(){
		return $this->PrazoMaximo;
	}

	public function setPrazoMinimo($PrazoMinimo){
		$this->PrazoMinimo = $PrazoMinimo;
	}

	public function getPrazoMinimo(){
		return $this->PrazoMinimo;
	}

	public function setPrazoMedio($PrazoMedio){
		$this->PrazoMedio = $PrazoMedio;
	}

	public function getPrazoMedio(){
		return $this->PrazoMedio;
	}

	public function setObservacoes($Observacoes){
		$this->Observacoes = $Observacoes;
	}

	public function getObservacoes(){
		return $this->Observacoes;
	}

	public function toHash(){
		 return $this->PropostaEnquadramentoID;
	}

	public function toString(){
		return $this->PropostaEnquadramentoID . " - " . $this->PropostaDetalheID . " - " . $this->ValorMaximo . " - " . $this->ValorMinimo . " - " . $this->ValorMedio . " - " . $this->ValorTotal . " - " . $this->PorcentagemMaxFianciamento . " - " . $this->PorcentagemMedFianciamento . " - " . $this->TxJurosMaxima . " - " . $this->TxJurosMinima . " - " . $this->TxJurosMedia . " - " . $this->PrazoMaximo . " - " . $this->PrazoMinimo . " - " . $this->PrazoMedio . " - " . $this->Observacoes;
	}

}
?>