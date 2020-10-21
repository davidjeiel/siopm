<?php 
class PropostasFaixas { 

	const TABLE_NAME = "tblPropostasFaixas";
	const COLUMN_KEY = "PropostaFaixaID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PropostaFaixaID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropostaFaixaTipoID;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ValorMinimo;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ValorMaximo;

	/**
	* @var "TYPE" => "double", "LENGTH" => "9", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $TaxaJurosNominal;

	/**
	* @var "TYPE" => "double", "LENGTH" => "9", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $TaxaJurosEfetiva;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropostaFaixaIniVigencia;


	public function setPropostaFaixaID($PropostaFaixaID){
		$this->PropostaFaixaID = $PropostaFaixaID;
	}

	public function getPropostaFaixaID(){
		return $this->PropostaFaixaID;
	}

	public function setPropostaFaixaTipoID($PropostaFaixaTipoID){
		$this->PropostaFaixaTipoID = $PropostaFaixaTipoID;
	}

	public function getPropostaFaixaTipoID(){
		return $this->PropostaFaixaTipoID;
	}

	public function setValorMinimo($ValorMinimo){
		$this->ValorMinimo = $ValorMinimo;
	}

	public function getValorMinimo(){
		return $this->ValorMinimo;
	}

	public function setValorMaximo($ValorMaximo){
		$this->ValorMaximo = $ValorMaximo;
	}

	public function getValorMaximo(){
		return $this->ValorMaximo;
	}

	public function setTaxaJurosNominal($TaxaJurosNominal){
		$this->TaxaJurosNominal = $TaxaJurosNominal;
	}

	public function getTaxaJurosNominal(){
		return $this->TaxaJurosNominal;
	}

	public function setTaxaJurosEfetiva($TaxaJurosEfetiva){
		$this->TaxaJurosEfetiva = $TaxaJurosEfetiva;
	}

	public function getTaxaJurosEfetiva(){
		return $this->TaxaJurosEfetiva;
	}

	public function setPropostaFaixaIniVigencia($PropostaFaixaIniVigencia){
		$this->PropostaFaixaIniVigencia = $PropostaFaixaIniVigencia;
	}

	public function getPropostaFaixaIniVigencia($mascara = 'Y-m-d H:i:s'){
		if ($this->PropostaFaixaIniVigencia != null){
			return date($mascara, strtotime(str_replace('/','-', $this->PropostaFaixaIniVigencia)));
		} else {
			return $this->PropostaFaixaIniVigencia;
		}
	}

	public function toHash(){
		 return $this->PropostaFaixaID;
	}

	public function toString(){
		return $this->PropostaFaixaID . " - " . $this->PropostaFaixaTipoID . " - " . $this->ValorMinimo . " - " . $this->ValorMaximo . " - " . $this->TaxaJurosNominal . " - " . $this->TaxaJurosEfetiva . " - " . $this->PropostaFaixaIniVigencia;
	}

}
?>