<?php 
class Ativos { 

	const TABLE_NAME = "tblAtivos";
	const COLUMN_KEY = "AtivoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $AtivoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ModalidadeID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropostaID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoTipoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ContaID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "14", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $AtivoCodigoSIOPM;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoCodigoCetip;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoCodigoBmfBovespa;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoCodigoIsin;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoNumeroEmissao;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoNumeroSerie;

	/**
	* @var "TYPE" => "date", "LENGTH" => "3", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoDataEmissao;

	/**
	* @var "TYPE" => "date", "LENGTH" => "3", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoDataVencimento;

	/**
	* @var "TYPE" => "double", "LENGTH" => "17", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoValorSubscricao;

	/**
	* @var "TYPE" => "double", "LENGTH" => "17", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoQuantidade;

	/**
	* @var "TYPE" => "double", "LENGTH" => "17", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoValorNominalUnitario;

	/**
	* @var "TYPE" => "date", "LENGTH" => "3", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoDataRegistroCvm;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoSituacaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoLocalNegociacaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoSubtipoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $IndexadorID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $DiasAnoIndexadorID;

	/**
	* @var "TYPE" => "date", "LENGTH" => "3", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoDataPrimeiraRemuneracao;

	/**
	* @var "TYPE" => "double", "LENGTH" => "17", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoVolume;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $IntervaloRemuneracaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $DiasBaseRemuneracaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $DiaAnoJurosID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoJurosTipoID;

	/**
	* @var "TYPE" => "double", "LENGTH" => "5", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoTaxaRiscoNominal;

	/**
	* @var "TYPE" => "double", "LENGTH" => "5", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoTaxaEstruturacaoNominal;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoAmortizacaoTipoID;

	/**
	* @var "TYPE" => "date", "LENGTH" => "3", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoDataPrimeiraAmortizacao;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $IntervaloAmortizacaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $DiasBaseAmortizacaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $DiasAnoAmortizacaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoAtivo;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoDataFinalizacao;

	/**
	* @var "TYPE" => "string", "LENGTH" => "500", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoObservacoes;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoDataLiquidacao;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoDataCadastro;


	public function setAtivoID($AtivoID){
		$this->AtivoID = $AtivoID;
	}

	public function getAtivoID(){
		return $this->AtivoID;
	}

	public function setModalidadeID($ModalidadeID){
		$this->ModalidadeID = $ModalidadeID;
	}

	public function getModalidadeID(){
		return $this->ModalidadeID;
	}

	public function setPropostaID($PropostaID){
		$this->PropostaID = $PropostaID;
	}

	public function getPropostaID(){
		return $this->PropostaID;
	}

	public function setAtivoTipoID($AtivoTipoID){
		$this->AtivoTipoID = $AtivoTipoID;
	}

	public function getAtivoTipoID(){
		return $this->AtivoTipoID;
	}

	public function setContaID($ContaID){
		$this->ContaID = $ContaID;
	}

	public function getContaID(){
		return $this->ContaID;
	}

	public function setAtivoCodigoSIOPM($AtivoCodigoSIOPM){
		$this->AtivoCodigoSIOPM = $AtivoCodigoSIOPM;
	}

	public function getAtivoCodigoSIOPM(){
		return $this->AtivoCodigoSIOPM;
	}

	public function setAtivoCodigoCetip($AtivoCodigoCetip){
		$this->AtivoCodigoCetip = $AtivoCodigoCetip;
	}

	public function getAtivoCodigoCetip(){
		return $this->AtivoCodigoCetip;
	}

	public function setAtivoCodigoBmfBovespa($AtivoCodigoBmfBovespa){
		$this->AtivoCodigoBmfBovespa = $AtivoCodigoBmfBovespa;
	}

	public function getAtivoCodigoBmfBovespa(){
		return $this->AtivoCodigoBmfBovespa;
	}

	public function setAtivoCodigoIsin($AtivoCodigoIsin){
		$this->AtivoCodigoIsin = $AtivoCodigoIsin;
	}

	public function getAtivoCodigoIsin(){
		return $this->AtivoCodigoIsin;
	}

	public function setAtivoNumeroEmissao($AtivoNumeroEmissao){
		$this->AtivoNumeroEmissao = $AtivoNumeroEmissao;
	}

	public function getAtivoNumeroEmissao(){
		return $this->AtivoNumeroEmissao;
	}

	public function setAtivoNumeroSerie($AtivoNumeroSerie){
		$this->AtivoNumeroSerie = $AtivoNumeroSerie;
	}

	public function getAtivoNumeroSerie(){
		return $this->AtivoNumeroSerie;
	}

	public function setAtivoDataEmissao($AtivoDataEmissao){
		$this->AtivoDataEmissao = $AtivoDataEmissao;
	}

	public function getAtivoDataEmissao($mascara = 'Y-m-d H:i:s'){
		if ($this->AtivoDataEmissao != null){
			return date($mascara, strtotime(str_replace('/','-', $this->AtivoDataEmissao)));
		} else {
			return $this->AtivoDataEmissao;
		}
	}

	public function setAtivoDataVencimento($AtivoDataVencimento){
		$this->AtivoDataVencimento = $AtivoDataVencimento;
	}

	public function getAtivoDataVencimento($mascara = 'Y-m-d H:i:s'){
		if ($this->AtivoDataVencimento != null){
			return date($mascara, strtotime(str_replace('/','-', $this->AtivoDataVencimento)));
		} else {
			return $this->AtivoDataVencimento;
		}
	}

	public function setAtivoValorSubscricao($AtivoValorSubscricao){
		$this->AtivoValorSubscricao = $AtivoValorSubscricao;
	}

	public function getAtivoValorSubscricao(){
		return $this->AtivoValorSubscricao;
	}

	public function setAtivoQuantidade($AtivoQuantidade){
		$this->AtivoQuantidade = $AtivoQuantidade;
	}

	public function getAtivoQuantidade(){
		return $this->AtivoQuantidade;
	}

	public function setAtivoValorNominalUnitario($AtivoValorNominalUnitario){
		$this->AtivoValorNominalUnitario = $AtivoValorNominalUnitario;
	}

	public function getAtivoValorNominalUnitario(){
		return $this->AtivoValorNominalUnitario;
	}

	public function setAtivoDataRegistroCvm($AtivoDataRegistroCvm){
		$this->AtivoDataRegistroCvm = $AtivoDataRegistroCvm;
	}

	public function getAtivoDataRegistroCvm($mascara = 'Y-m-d H:i:s'){
		if ($this->AtivoDataRegistroCvm != null){
			return date($mascara, strtotime(str_replace('/','-', $this->AtivoDataRegistroCvm)));
		} else {
			return $this->AtivoDataRegistroCvm;
		}
	}

	public function setAtivoSituacaoID($AtivoSituacaoID){
		$this->AtivoSituacaoID = $AtivoSituacaoID;
	}

	public function getAtivoSituacaoID(){
		return $this->AtivoSituacaoID;
	}

	public function setAtivoLocalNegociacaoID($AtivoLocalNegociacaoID){
		$this->AtivoLocalNegociacaoID = $AtivoLocalNegociacaoID;
	}

	public function getAtivoLocalNegociacaoID(){
		return $this->AtivoLocalNegociacaoID;
	}

	public function setAtivoSubtipoID($AtivoSubtipoID){
		$this->AtivoSubtipoID = $AtivoSubtipoID;
	}

	public function getAtivoSubtipoID(){
		return $this->AtivoSubtipoID;
	}

	public function setIndexadorID($IndexadorID){
		$this->IndexadorID = $IndexadorID;
	}

	public function getIndexadorID(){
		return $this->IndexadorID;
	}

	public function setDiasAnoIndexadorID($DiasAnoIndexadorID){
		$this->DiasAnoIndexadorID = $DiasAnoIndexadorID;
	}

	public function getDiasAnoIndexadorID(){
		return $this->DiasAnoIndexadorID;
	}

	public function setAtivoDataPrimeiraRemuneracao($AtivoDataPrimeiraRemuneracao){
		$this->AtivoDataPrimeiraRemuneracao = $AtivoDataPrimeiraRemuneracao;
	}

	public function getAtivoDataPrimeiraRemuneracao($mascara = 'Y-m-d H:i:s'){
		if ($this->AtivoDataPrimeiraRemuneracao != null){
			return date($mascara, strtotime(str_replace('/','-', $this->AtivoDataPrimeiraRemuneracao)));
		} else {
			return $this->AtivoDataPrimeiraRemuneracao;
		}
	}

	public function setAtivoVolume($AtivoVolume){
		$this->AtivoVolume = $AtivoVolume;
	}

	public function getAtivoVolume(){
		return $this->AtivoVolume;
	}

	public function setIntervaloRemuneracaoID($IntervaloRemuneracaoID){
		$this->IntervaloRemuneracaoID = $IntervaloRemuneracaoID;
	}

	public function getIntervaloRemuneracaoID(){
		return $this->IntervaloRemuneracaoID;
	}

	public function setDiasBaseRemuneracaoID($DiasBaseRemuneracaoID){
		$this->DiasBaseRemuneracaoID = $DiasBaseRemuneracaoID;
	}

	public function getDiasBaseRemuneracaoID(){
		return $this->DiasBaseRemuneracaoID;
	}

	public function setDiaAnoJurosID($DiaAnoJurosID){
		$this->DiaAnoJurosID = $DiaAnoJurosID;
	}

	public function getDiaAnoJurosID(){
		return $this->DiaAnoJurosID;
	}

	public function setAtivoJurosTipoID($AtivoJurosTipoID){
		$this->AtivoJurosTipoID = $AtivoJurosTipoID;
	}

	public function getAtivoJurosTipoID(){
		return $this->AtivoJurosTipoID;
	}

	public function setAtivoTaxaRiscoNominal($AtivoTaxaRiscoNominal){
		$this->AtivoTaxaRiscoNominal = $AtivoTaxaRiscoNominal;
	}

	public function getAtivoTaxaRiscoNominal(){
		return $this->AtivoTaxaRiscoNominal;
	}

	public function setAtivoTaxaEstruturacaoNominal($AtivoTaxaEstruturacaoNominal){
		$this->AtivoTaxaEstruturacaoNominal = $AtivoTaxaEstruturacaoNominal;
	}

	public function getAtivoTaxaEstruturacaoNominal(){
		return $this->AtivoTaxaEstruturacaoNominal;
	}

	public function setAtivoAmortizacaoTipoID($AtivoAmortizacaoTipoID){
		$this->AtivoAmortizacaoTipoID = $AtivoAmortizacaoTipoID;
	}

	public function getAtivoAmortizacaoTipoID(){
		return $this->AtivoAmortizacaoTipoID;
	}

	public function setAtivoDataPrimeiraAmortizacao($AtivoDataPrimeiraAmortizacao){
		$this->AtivoDataPrimeiraAmortizacao = $AtivoDataPrimeiraAmortizacao;
	}

	public function getAtivoDataPrimeiraAmortizacao($mascara = 'Y-m-d H:i:s'){
		if ($this->AtivoDataPrimeiraAmortizacao != null){
			return date($mascara, strtotime(str_replace('/','-', $this->AtivoDataPrimeiraAmortizacao)));
		} else {
			return $this->AtivoDataPrimeiraAmortizacao;
		}
	}

	public function setIntervaloAmortizacaoID($IntervaloAmortizacaoID){
		$this->IntervaloAmortizacaoID = $IntervaloAmortizacaoID;
	}

	public function getIntervaloAmortizacaoID(){
		return $this->IntervaloAmortizacaoID;
	}

	public function setDiasBaseAmortizacaoID($DiasBaseAmortizacaoID){
		$this->DiasBaseAmortizacaoID = $DiasBaseAmortizacaoID;
	}

	public function getDiasBaseAmortizacaoID(){
		return $this->DiasBaseAmortizacaoID;
	}

	public function setDiasAnoAmortizacaoID($DiasAnoAmortizacaoID){
		$this->DiasAnoAmortizacaoID = $DiasAnoAmortizacaoID;
	}

	public function getDiasAnoAmortizacaoID(){
		return $this->DiasAnoAmortizacaoID;
	}

	public function setAtivoAtivo($AtivoAtivo){
		$this->AtivoAtivo = $AtivoAtivo;
	}

	public function getAtivoAtivo(){
		return $this->AtivoAtivo;
	}

	public function setAtivoDataFinalizacao($AtivoDataFinalizacao){
		$this->AtivoDataFinalizacao = $AtivoDataFinalizacao;
	}

	public function getAtivoDataFinalizacao($mascara = 'Y-m-d H:i:s'){
		if ($this->AtivoDataFinalizacao != null){
			return date($mascara, strtotime(str_replace('/','-', $this->AtivoDataFinalizacao)));
		} else {
			return $this->AtivoDataFinalizacao;
		}
	}

	public function setAtivoObservacoes($AtivoObservacoes){
		$this->AtivoObservacoes = $AtivoObservacoes;
	}

	public function getAtivoObservacoes(){
		return $this->AtivoObservacoes;
	}

	public function setAtivoDataLiquidacao($AtivoDataLiquidacao){
		$this->AtivoDataLiquidacao = $AtivoDataLiquidacao;
	}

	public function getAtivoDataLiquidacao($mascara = 'Y-m-d H:i:s'){
		if ($this->AtivoDataLiquidacao != null){
			return date($mascara, strtotime(str_replace('/','-', $this->AtivoDataLiquidacao)));
		} else {
			return $this->AtivoDataLiquidacao;
		}
	}

	public function setAtivoDataCadastro($AtivoDataCadastro){
		$this->AtivoDataCadastro = $AtivoDataCadastro;
	}

	public function getAtivoDataCadastro($mascara = 'Y-m-d H:i:s'){
		if ($this->AtivoDataCadastro != null){
			return date($mascara, strtotime(str_replace('/','-', $this->AtivoDataCadastro)));
		} else {
			return $this->AtivoDataCadastro;
		}
	}

	public function toHash(){
		 return $this->AtivoID;
	}

	public function toString(){
		return $this->AtivoID . " - " . $this->ModalidadeID . " - " . $this->PropostaID . " - " . $this->AtivoTipoID . " - " . $this->ContaID . " - " . $this->AtivoCodigoSIOPM . " - " . $this->AtivoCodigoCetip . " - " . $this->AtivoCodigoBmfBovespa . " - " . $this->AtivoCodigoIsin . " - " . $this->AtivoNumeroEmissao . " - " . $this->AtivoNumeroSerie . " - " . $this->AtivoDataEmissao . " - " . $this->AtivoDataVencimento . " - " . $this->AtivoValorSubscricao . " - " . $this->AtivoQuantidade . " - " . $this->AtivoValorNominalUnitario . " - " . $this->AtivoDataRegistroCvm . " - " . $this->AtivoSituacaoID . " - " . $this->AtivoLocalNegociacaoID . " - " . $this->AtivoSubtipoID . " - " . $this->IndexadorID . " - " . $this->DiasAnoIndexadorID . " - " . $this->AtivoDataPrimeiraRemuneracao . " - " . $this->AtivoVolume . " - " . $this->IntervaloRemuneracaoID . " - " . $this->DiasBaseRemuneracaoID . " - " . $this->DiaAnoJurosID . " - " . $this->AtivoJurosTipoID . " - " . $this->AtivoTaxaRiscoNominal . " - " . $this->AtivoTaxaEstruturacaoNominal . " - " . $this->AtivoAmortizacaoTipoID . " - " . $this->AtivoDataPrimeiraAmortizacao . " - " . $this->IntervaloAmortizacaoID . " - " . $this->DiasBaseAmortizacaoID . " - " . $this->DiasAnoAmortizacaoID . " - " . $this->AtivoAtivo . " - " . $this->AtivoDataFinalizacao . " - " . $this->AtivoObservacoes . " - " . $this->AtivoDataLiquidacao . " - " . $this->AtivoDataCadastro;
	}

}
?>