<?php 
class Entidades { 

	const TABLE_NAME = "tblEntidades";
	const COLUMN_KEY = "EntidadeID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $EntidadeID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "36", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $EntidadeCnpj;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $EntidadeTipoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "14", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $MatriculaCOP;

	/**
	* @var "TYPE" => "string", "LENGTH" => "160", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $EntidadeNomeRazao;

	/**
	* @var "TYPE" => "string", "LENGTH" => "160", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $EntidadeNomeFantasia;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $EntidadeDataAbertura;

	/**
	* @var "TYPE" => "string", "LENGTH" => "32", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EntidadeFones;

	/**
	* @var "TYPE" => "string", "LENGTH" => "300", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EntidadeEmail;

	/**
	* @var "TYPE" => "string", "LENGTH" => "18", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EntidadeCEP;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EntidadeLogradouro;

	/**
	* @var "TYPE" => "string", "LENGTH" => "40", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EntidadeNumero;

	/**
	* @var "TYPE" => "string", "LENGTH" => "60", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EntidadeComplemento;

	/**
	* @var "TYPE" => "string", "LENGTH" => "60", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EntidadeBairro;

	/**
	* @var "TYPE" => "string", "LENGTH" => "60", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EntidadeCidade;

	/**
	* @var "TYPE" => "string", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EntidadeUF;

	/**
	* @var "TYPE" => "string", "LENGTH" => "200", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EntidadeObs;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EntidadeResponsavel;

	/**
	* @var "TYPE" => "string", "LENGTH" => "32", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EntidadeResponsavelFones;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EntidadeResponsavelEmail;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $EntidadeAtiva;


	public function setEntidadeID($EntidadeID){
		$this->EntidadeID = $EntidadeID;
	}

	public function getEntidadeID(){
		return $this->EntidadeID;
	}

	public function setEntidadeCnpj($EntidadeCnpj){
		$this->EntidadeCnpj = $EntidadeCnpj;
	}

	public function getEntidadeCnpj(){
		return $this->EntidadeCnpj;
	}

	public function setEntidadeTipoID($EntidadeTipoID){
		$this->EntidadeTipoID = $EntidadeTipoID;
	}

	public function getEntidadeTipoID(){
		return $this->EntidadeTipoID;
	}

	public function setMatriculaCOP($MatriculaCOP){
		$this->MatriculaCOP = $MatriculaCOP;
	}

	public function getMatriculaCOP(){
		return $this->MatriculaCOP;
	}

	public function setEntidadeNomeRazao($EntidadeNomeRazao){
		$this->EntidadeNomeRazao = $EntidadeNomeRazao;
	}

	public function getEntidadeNomeRazao(){
		return $this->EntidadeNomeRazao;
	}

	public function setEntidadeNomeFantasia($EntidadeNomeFantasia){
		$this->EntidadeNomeFantasia = $EntidadeNomeFantasia;
	}

	public function getEntidadeNomeFantasia(){
		return $this->EntidadeNomeFantasia;
	}

	public function setEntidadeDataAbertura($EntidadeDataAbertura){
		$this->EntidadeDataAbertura = $EntidadeDataAbertura;
	}

	public function getEntidadeDataAbertura($mascara = 'Y-m-d H:i:s'){
		if ($this->EntidadeDataAbertura != null){
			return date($mascara, strtotime(str_replace('/','-', $this->EntidadeDataAbertura)));
		} else {
			return $this->EntidadeDataAbertura;
		}
	}

	public function setEntidadeFones($EntidadeFones){
		$this->EntidadeFones = $EntidadeFones;
	}

	public function getEntidadeFones(){
		return $this->EntidadeFones;
	}

	public function setEntidadeEmail($EntidadeEmail){
		$this->EntidadeEmail = $EntidadeEmail;
	}

	public function getEntidadeEmail(){
		return $this->EntidadeEmail;
	}

	public function setEntidadeCEP($EntidadeCEP){
		$this->EntidadeCEP = $EntidadeCEP;
	}

	public function getEntidadeCEP(){
		return $this->EntidadeCEP;
	}

	public function setEntidadeLogradouro($EntidadeLogradouro){
		$this->EntidadeLogradouro = $EntidadeLogradouro;
	}

	public function getEntidadeLogradouro(){
		return $this->EntidadeLogradouro;
	}

	public function setEntidadeNumero($EntidadeNumero){
		$this->EntidadeNumero = $EntidadeNumero;
	}

	public function getEntidadeNumero(){
		return $this->EntidadeNumero;
	}

	public function setEntidadeComplemento($EntidadeComplemento){
		$this->EntidadeComplemento = $EntidadeComplemento;
	}

	public function getEntidadeComplemento(){
		return $this->EntidadeComplemento;
	}

	public function setEntidadeBairro($EntidadeBairro){
		$this->EntidadeBairro = $EntidadeBairro;
	}

	public function getEntidadeBairro(){
		return $this->EntidadeBairro;
	}

	public function setEntidadeCidade($EntidadeCidade){
		$this->EntidadeCidade = $EntidadeCidade;
	}

	public function getEntidadeCidade(){
		return $this->EntidadeCidade;
	}

	public function setEntidadeUF($EntidadeUF){
		$this->EntidadeUF = $EntidadeUF;
	}

	public function getEntidadeUF(){
		return $this->EntidadeUF;
	}

	public function setEntidadeObs($EntidadeObs){
		$this->EntidadeObs = $EntidadeObs;
	}

	public function getEntidadeObs(){
		return $this->EntidadeObs;
	}

	public function setEntidadeResponsavel($EntidadeResponsavel){
		$this->EntidadeResponsavel = $EntidadeResponsavel;
	}

	public function getEntidadeResponsavel(){
		return $this->EntidadeResponsavel;
	}

	public function setEntidadeResponsavelFones($EntidadeResponsavelFones){
		$this->EntidadeResponsavelFones = $EntidadeResponsavelFones;
	}

	public function getEntidadeResponsavelFones(){
		return $this->EntidadeResponsavelFones;
	}

	public function setEntidadeResponsavelEmail($EntidadeResponsavelEmail){
		$this->EntidadeResponsavelEmail = $EntidadeResponsavelEmail;
	}

	public function getEntidadeResponsavelEmail(){
		return $this->EntidadeResponsavelEmail;
	}

	public function setEntidadeAtiva($EntidadeAtiva){
		$this->EntidadeAtiva = $EntidadeAtiva;
	}

	public function getEntidadeAtiva(){
		return $this->EntidadeAtiva;
	}

	public function toHash(){
		 return $this->EntidadeID;
	}

	public function toString(){
		return $this->EntidadeID . " - " . $this->EntidadeCnpj . " - " . $this->EntidadeTipoID . " - " . $this->MatriculaCOP . " - " . $this->EntidadeNomeRazao . " - " . $this->EntidadeNomeFantasia . " - " . $this->EntidadeDataAbertura . " - " . $this->EntidadeFones . " - " . $this->EntidadeEmail . " - " . $this->EntidadeCEP . " - " . $this->EntidadeLogradouro . " - " . $this->EntidadeNumero . " - " . $this->EntidadeComplemento . " - " . $this->EntidadeBairro . " - " . $this->EntidadeCidade . " - " . $this->EntidadeUF . " - " . $this->EntidadeObs . " - " . $this->EntidadeResponsavel . " - " . $this->EntidadeResponsavelFones . " - " . $this->EntidadeResponsavelEmail . " - " . $this->EntidadeAtiva;
	}

}
?>