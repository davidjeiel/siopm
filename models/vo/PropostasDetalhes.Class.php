<?php 
class PropostasDetalhes { 

	const TABLE_NAME = "tblPropostasDetalhes";
	const COLUMN_KEY = "PropostaDetalheID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PropostaDetalheID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropostaID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropostaFaseID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "2", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropostaStatusID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $OriginadorID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $CoordenadorLiderID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AgenteFiduciarioID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AgenteFiduciarioStatus;

	/**
	* @var "TYPE" => "string", "LENGTH" => "20", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AgenteFiduciarioRating;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AgenteFiduciarioValidade;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ValorGlobalProposta;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $DataRecepcao;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ValorUnitarioSenior;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $QuantidadeSenior;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ValorCRISenior;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ValorUnitarioSubordinado;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $QuantidadeSubordinado;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ValorSubordinado;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PrazoCarencia;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PrazoAmortizacao;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $DataFinalizacao;


	public function setPropostaDetalheID($PropostaDetalheID){
		$this->PropostaDetalheID = $PropostaDetalheID;
	}

	public function getPropostaDetalheID(){
		return $this->PropostaDetalheID;
	}

	public function setPropostaID($PropostaID){
		$this->PropostaID = $PropostaID;
	}

	public function getPropostaID(){
		return $this->PropostaID;
	}

	public function setPropostaFaseID($PropostaFaseID){
		$this->PropostaFaseID = $PropostaFaseID;
	}

	public function getPropostaFaseID(){
		return $this->PropostaFaseID;
	}

	public function setPropostaStatusID($PropostaStatusID){
		$this->PropostaStatusID = $PropostaStatusID;
	}

	public function getPropostaStatusID(){
		return $this->PropostaStatusID;
	}

	public function setOriginadorID($OriginadorID){
		$this->OriginadorID = $OriginadorID;
	}

	public function getOriginadorID(){
		return $this->OriginadorID;
	}

	public function setCoordenadorLiderID($CoordenadorLiderID){
		$this->CoordenadorLiderID = $CoordenadorLiderID;
	}

	public function getCoordenadorLiderID(){
		return $this->CoordenadorLiderID;
	}

	public function setAgenteFiduciarioID($AgenteFiduciarioID){
		$this->AgenteFiduciarioID = $AgenteFiduciarioID;
	}

	public function getAgenteFiduciarioID(){
		return $this->AgenteFiduciarioID;
	}

	public function setAgenteFiduciarioStatus($AgenteFiduciarioStatus){
		$this->AgenteFiduciarioStatus = $AgenteFiduciarioStatus;
	}

	public function getAgenteFiduciarioStatus(){
		return $this->AgenteFiduciarioStatus;
	}

	public function setAgenteFiduciarioRating($AgenteFiduciarioRating){
		$this->AgenteFiduciarioRating = $AgenteFiduciarioRating;
	}

	public function getAgenteFiduciarioRating(){
		return $this->AgenteFiduciarioRating;
	}

	public function setAgenteFiduciarioValidade($AgenteFiduciarioValidade){
		$this->AgenteFiduciarioValidade = $AgenteFiduciarioValidade;
	}

	public function getAgenteFiduciarioValidade($mascara = 'Y-m-d H:i:s'){
		if ($this->AgenteFiduciarioValidade != null){
			return date($mascara, strtotime(str_replace('/','-', $this->AgenteFiduciarioValidade)));
		} else {
			return $this->AgenteFiduciarioValidade;
		}
	}

	public function setValorGlobalProposta($ValorGlobalProposta){
		$this->ValorGlobalProposta = $ValorGlobalProposta;
	}

	public function getValorGlobalProposta(){
		return $this->ValorGlobalProposta;
	}

	public function setDataRecepcao($DataRecepcao){
		$this->DataRecepcao = $DataRecepcao;
	}

	public function getDataRecepcao($mascara = 'Y-m-d H:i:s'){
		if ($this->DataRecepcao != null){
			return date($mascara, strtotime(str_replace('/','-', $this->DataRecepcao)));
		} else {
			return $this->DataRecepcao;
		}
	}

	public function setValorUnitarioSenior($ValorUnitarioSenior){
		$this->ValorUnitarioSenior = $ValorUnitarioSenior;
	}

	public function getValorUnitarioSenior(){
		return $this->ValorUnitarioSenior;
	}

	public function setQuantidadeSenior($QuantidadeSenior){
		$this->QuantidadeSenior = $QuantidadeSenior;
	}

	public function getQuantidadeSenior(){
		return $this->QuantidadeSenior;
	}

	public function setValorCRISenior($ValorCRISenior){
		$this->ValorCRISenior = $ValorCRISenior;
	}

	public function getValorCRISenior(){
		return $this->ValorCRISenior;
	}

	public function setValorUnitarioSubordinado($ValorUnitarioSubordinado){
		$this->ValorUnitarioSubordinado = $ValorUnitarioSubordinado;
	}

	public function getValorUnitarioSubordinado(){
		return $this->ValorUnitarioSubordinado;
	}

	public function setQuantidadeSubordinado($QuantidadeSubordinado){
		$this->QuantidadeSubordinado = $QuantidadeSubordinado;
	}

	public function getQuantidadeSubordinado(){
		return $this->QuantidadeSubordinado;
	}

	public function setValorSubordinado($ValorSubordinado){
		$this->ValorSubordinado = $ValorSubordinado;
	}

	public function getValorSubordinado(){
		return $this->ValorSubordinado;
	}

	public function setPrazoCarencia($PrazoCarencia){
		$this->PrazoCarencia = $PrazoCarencia;
	}

	public function getPrazoCarencia(){
		return $this->PrazoCarencia;
	}

	public function setPrazoAmortizacao($PrazoAmortizacao){
		$this->PrazoAmortizacao = $PrazoAmortizacao;
	}

	public function getPrazoAmortizacao(){
		return $this->PrazoAmortizacao;
	}

	public function setDataFinalizacao($DataFinalizacao){
		$this->DataFinalizacao = $DataFinalizacao;
	}

	public function getDataFinalizacao($mascara = 'Y-m-d H:i:s'){
		if ($this->DataFinalizacao != null){
			return date($mascara, strtotime(str_replace('/','-', $this->DataFinalizacao)));
		} else {
			return $this->DataFinalizacao;
		}
	}

	public function toHash(){
		 return $this->PropostaDetalheID;
	}

	public function toString(){
		return $this->PropostaDetalheID . " - " . $this->PropostaID . " - " . $this->PropostaFaseID . " - " . $this->PropostaStatusID . " - " . $this->OriginadorID . " - " . $this->CoordenadorLiderID . " - " . $this->AgenteFiduciarioID . " - " . $this->AgenteFiduciarioStatus . " - " . $this->AgenteFiduciarioRating . " - " . $this->AgenteFiduciarioValidade . " - " . $this->ValorGlobalProposta . " - " . $this->DataRecepcao . " - " . $this->ValorUnitarioSenior . " - " . $this->QuantidadeSenior . " - " . $this->ValorCRISenior . " - " . $this->ValorUnitarioSubordinado . " - " . $this->QuantidadeSubordinado . " - " . $this->ValorSubordinado . " - " . $this->PrazoCarencia . " - " . $this->PrazoAmortizacao . " - " . $this->DataFinalizacao;
	}

}
?>