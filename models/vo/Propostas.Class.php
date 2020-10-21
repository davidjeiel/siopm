<?php 
class Propostas { 

	const TABLE_NAME = "tblPropostas";
	const COLUMN_KEY = "PropostaID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PropostaID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "16", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropostaNumero;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $OrcamentoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ProgramaID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $UnidadeID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $SecuritizadoraID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $SecuritizadoraStatus;

	/**
	* @var "TYPE" => "string", "LENGTH" => "20", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $SecuritizadoraRating;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $SecuritizadoraValidade;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropostaFaixaID;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropostaFaixaVlrMin;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropostaFaixaVlrMax;

	/**
	* @var "TYPE" => "double", "LENGTH" => "9", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropostaFaixaTaxaJurosNominal;

	/**
	* @var "TYPE" => "double", "LENGTH" => "9", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropostaFaixaTaxaJurosEfetiva;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropEmpreendTipoID;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ValorAprovadoGEFOM;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropostaAtiva;


	public function setPropostaID($PropostaID){
		$this->PropostaID = $PropostaID;
	}

	public function getPropostaID(){
		return $this->PropostaID;
	}

	public function setPropostaNumero($PropostaNumero){
		$this->PropostaNumero = $PropostaNumero;
	}

	public function getPropostaNumero(){
		return $this->PropostaNumero;
	}

	public function setOrcamentoID($OrcamentoID){
		$this->OrcamentoID = $OrcamentoID;
	}

	public function getOrcamentoID(){
		return $this->OrcamentoID;
	}

	public function setProgramaID($ProgramaID){
		$this->ProgramaID = $ProgramaID;
	}

	public function getProgramaID(){
		return $this->ProgramaID;
	}

	public function setUnidadeID($UnidadeID){
		$this->UnidadeID = $UnidadeID;
	}

	public function getUnidadeID(){
		return $this->UnidadeID;
	}

	public function setSecuritizadoraID($SecuritizadoraID){
		$this->SecuritizadoraID = $SecuritizadoraID;
	}

	public function getSecuritizadoraID(){
		return $this->SecuritizadoraID;
	}

	public function setSecuritizadoraStatus($SecuritizadoraStatus){
		$this->SecuritizadoraStatus = $SecuritizadoraStatus;
	}

	public function getSecuritizadoraStatus(){
		return $this->SecuritizadoraStatus;
	}

	public function setSecuritizadoraRating($SecuritizadoraRating){
		$this->SecuritizadoraRating = $SecuritizadoraRating;
	}

	public function getSecuritizadoraRating(){
		return $this->SecuritizadoraRating;
	}

	public function setSecuritizadoraValidade($SecuritizadoraValidade){
		$this->SecuritizadoraValidade = $SecuritizadoraValidade;
	}

	public function getSecuritizadoraValidade($mascara = 'Y-m-d H:i:s'){
		if ($this->SecuritizadoraValidade != null){
			return date($mascara, strtotime(str_replace('/','-', $this->SecuritizadoraValidade)));
		} else {
			return $this->SecuritizadoraValidade;
		}
	}

	public function setPropostaFaixaID($PropostaFaixaID){
		$this->PropostaFaixaID = $PropostaFaixaID;
	}

	public function getPropostaFaixaID(){
		return $this->PropostaFaixaID;
	}

	public function setPropostaFaixaVlrMin($PropostaFaixaVlrMin){
		$this->PropostaFaixaVlrMin = $PropostaFaixaVlrMin;
	}

	public function getPropostaFaixaVlrMin(){
		return $this->PropostaFaixaVlrMin;
	}

	public function setPropostaFaixaVlrMax($PropostaFaixaVlrMax){
		$this->PropostaFaixaVlrMax = $PropostaFaixaVlrMax;
	}

	public function getPropostaFaixaVlrMax(){
		return $this->PropostaFaixaVlrMax;
	}

	public function setPropostaFaixaTaxaJurosNominal($PropostaFaixaTaxaJurosNominal){
		$this->PropostaFaixaTaxaJurosNominal = $PropostaFaixaTaxaJurosNominal;
	}

	public function getPropostaFaixaTaxaJurosNominal(){
		return $this->PropostaFaixaTaxaJurosNominal;
	}

	public function setPropostaFaixaTaxaJurosEfetiva($PropostaFaixaTaxaJurosEfetiva){
		$this->PropostaFaixaTaxaJurosEfetiva = $PropostaFaixaTaxaJurosEfetiva;
	}

	public function getPropostaFaixaTaxaJurosEfetiva(){
		return $this->PropostaFaixaTaxaJurosEfetiva;
	}

	public function setPropEmpreendTipoID($PropEmpreendTipoID){
		$this->PropEmpreendTipoID = $PropEmpreendTipoID;
	}

	public function getPropEmpreendTipoID(){
		return $this->PropEmpreendTipoID;
	}

	public function setValorAprovadoGEFOM($ValorAprovadoGEFOM){
		$this->ValorAprovadoGEFOM = $ValorAprovadoGEFOM;
	}

	public function getValorAprovadoGEFOM(){
		return $this->ValorAprovadoGEFOM;
	}

	public function setPropostaAtiva($PropostaAtiva){
		$this->PropostaAtiva = $PropostaAtiva;
	}

	public function getPropostaAtiva(){
		return $this->PropostaAtiva;
	}

	public function toHash(){
		 return $this->PropostaID;
	}

	public function toString(){
		return $this->PropostaID . " - " . $this->PropostaNumero . " - " . $this->OrcamentoID . " - " . $this->ProgramaID . " - " . $this->UnidadeID . " - " . $this->SecuritizadoraID . " - " . $this->SecuritizadoraStatus . " - " . $this->SecuritizadoraRating . " - " . $this->SecuritizadoraValidade . " - " . $this->PropostaFaixaID . " - " . $this->PropostaFaixaVlrMin . " - " . $this->PropostaFaixaVlrMax . " - " . $this->PropostaFaixaTaxaJurosNominal . " - " . $this->PropostaFaixaTaxaJurosEfetiva . " - " . $this->PropEmpreendTipoID . " - " . $this->ValorAprovadoGEFOM . " - " . $this->PropostaAtiva;
	}

}
?>