<?php 
class Empreendimentos { 

	const TABLE_NAME = "tblEmpreendimentos";
	const COLUMN_KEY = "EmpreendimentoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $EmpreendimentoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EmpreendimentoNome;

	/**
	* @var "TYPE" => "string", "LENGTH" => "1000", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EmpreendimentoDescricao;

	/**
	* @var "TYPE" => "string", "LENGTH" => "20", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EmpreendimentoCep;

	/**
	* @var "TYPE" => "string", "LENGTH" => "200", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EmpreendimentoLogradouro;

	/**
	* @var "TYPE" => "string", "LENGTH" => "20", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EmpreendimentoNumero;

	/**
	* @var "TYPE" => "string", "LENGTH" => "200", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EmpreendimentoComplemento;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EmpreendimentoBairro;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $MunicipioID;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EmpreendimentoValor;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EmpreendimentoCusto;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EmpreendimentoValorInvestido;

	/**
	* @var "TYPE" => "double", "LENGTH" => "5", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EmpreendimentoEstagioObra;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EmpreendimentoLancamentoPrevisao;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EmpreendimentoPopulacaoBeneficiada;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EmpreendimentoEmpregosGerados;


	public function setEmpreendimentoID($EmpreendimentoID){
		$this->EmpreendimentoID = $EmpreendimentoID;
	}

	public function getEmpreendimentoID(){
		return $this->EmpreendimentoID;
	}

	public function setAtivoID($AtivoID){
		$this->AtivoID = $AtivoID;
	}

	public function getAtivoID(){
		return $this->AtivoID;
	}

	public function setEmpreendimentoNome($EmpreendimentoNome){
		$this->EmpreendimentoNome = $EmpreendimentoNome;
	}

	public function getEmpreendimentoNome(){
		return $this->EmpreendimentoNome;
	}

	public function setEmpreendimentoDescricao($EmpreendimentoDescricao){
		$this->EmpreendimentoDescricao = $EmpreendimentoDescricao;
	}

	public function getEmpreendimentoDescricao(){
		return $this->EmpreendimentoDescricao;
	}

	public function setEmpreendimentoCep($EmpreendimentoCep){
		$this->EmpreendimentoCep = $EmpreendimentoCep;
	}

	public function getEmpreendimentoCep(){
		return $this->EmpreendimentoCep;
	}

	public function setEmpreendimentoLogradouro($EmpreendimentoLogradouro){
		$this->EmpreendimentoLogradouro = $EmpreendimentoLogradouro;
	}

	public function getEmpreendimentoLogradouro(){
		return $this->EmpreendimentoLogradouro;
	}

	public function setEmpreendimentoNumero($EmpreendimentoNumero){
		$this->EmpreendimentoNumero = $EmpreendimentoNumero;
	}

	public function getEmpreendimentoNumero(){
		return $this->EmpreendimentoNumero;
	}

	public function setEmpreendimentoComplemento($EmpreendimentoComplemento){
		$this->EmpreendimentoComplemento = $EmpreendimentoComplemento;
	}

	public function getEmpreendimentoComplemento(){
		return $this->EmpreendimentoComplemento;
	}

	public function setEmpreendimentoBairro($EmpreendimentoBairro){
		$this->EmpreendimentoBairro = $EmpreendimentoBairro;
	}

	public function getEmpreendimentoBairro(){
		return $this->EmpreendimentoBairro;
	}

	public function setMunicipioID($MunicipioID){
		$this->MunicipioID = $MunicipioID;
	}

	public function getMunicipioID(){
		return $this->MunicipioID;
	}

	public function setEmpreendimentoValor($EmpreendimentoValor){
		$this->EmpreendimentoValor = $EmpreendimentoValor;
	}

	public function getEmpreendimentoValor(){
		return $this->EmpreendimentoValor;
	}

	public function setEmpreendimentoCusto($EmpreendimentoCusto){
		$this->EmpreendimentoCusto = $EmpreendimentoCusto;
	}

	public function getEmpreendimentoCusto(){
		return $this->EmpreendimentoCusto;
	}

	public function setEmpreendimentoValorInvestido($EmpreendimentoValorInvestido){
		$this->EmpreendimentoValorInvestido = $EmpreendimentoValorInvestido;
	}

	public function getEmpreendimentoValorInvestido(){
		return $this->EmpreendimentoValorInvestido;
	}

	public function setEmpreendimentoEstagioObra($EmpreendimentoEstagioObra){
		$this->EmpreendimentoEstagioObra = $EmpreendimentoEstagioObra;
	}

	public function getEmpreendimentoEstagioObra(){
		return $this->EmpreendimentoEstagioObra;
	}

	public function setEmpreendimentoLancamentoPrevisao($EmpreendimentoLancamentoPrevisao){
		$this->EmpreendimentoLancamentoPrevisao = $EmpreendimentoLancamentoPrevisao;
	}

	public function getEmpreendimentoLancamentoPrevisao($mascara = 'Y-m-d H:i:s'){
		if ($this->EmpreendimentoLancamentoPrevisao != null){
			return date($mascara, strtotime(str_replace('/','-', $this->EmpreendimentoLancamentoPrevisao)));
		} else {
			return $this->EmpreendimentoLancamentoPrevisao;
		}
	}

	public function setEmpreendimentoPopulacaoBeneficiada($EmpreendimentoPopulacaoBeneficiada){
		$this->EmpreendimentoPopulacaoBeneficiada = $EmpreendimentoPopulacaoBeneficiada;
	}

	public function getEmpreendimentoPopulacaoBeneficiada(){
		return $this->EmpreendimentoPopulacaoBeneficiada;
	}

	public function setEmpreendimentoEmpregosGerados($EmpreendimentoEmpregosGerados){
		$this->EmpreendimentoEmpregosGerados = $EmpreendimentoEmpregosGerados;
	}

	public function getEmpreendimentoEmpregosGerados(){
		return $this->EmpreendimentoEmpregosGerados;
	}

	public function toHash(){
		 return $this->EmpreendimentoID;
	}

	public function toString(){
		return $this->EmpreendimentoID . " - " . $this->AtivoID . " - " . $this->EmpreendimentoNome . " - " . $this->EmpreendimentoDescricao . " - " . $this->EmpreendimentoCep . " - " . $this->EmpreendimentoLogradouro . " - " . $this->EmpreendimentoNumero . " - " . $this->EmpreendimentoComplemento . " - " . $this->EmpreendimentoBairro . " - " . $this->MunicipioID . " - " . $this->EmpreendimentoValor . " - " . $this->EmpreendimentoCusto . " - " . $this->EmpreendimentoValorInvestido . " - " . $this->EmpreendimentoEstagioObra . " - " . $this->EmpreendimentoLancamentoPrevisao . " - " . $this->EmpreendimentoPopulacaoBeneficiada . " - " . $this->EmpreendimentoEmpregosGerados;
	}

}
?>