<?php 
class Contas { 

	const TABLE_NAME = "tblContas";
	const COLUMN_KEY = "ContaID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ContaID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ContaNome;

	/**
	* @var "TYPE" => "string", "LENGTH" => "1000", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ContaDescricao;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ContaDataInicio;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ContaDataFim;

	/**
	* @var "TYPE" => "string", "LENGTH" => "2", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ContaNatureza;

	/**
	* @var "TYPE" => "string", "LENGTH" => "2", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ContaTipo;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ContaGrupo;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ContaSaldoAtual;

	/**
	* @var "TYPE" => "string", "LENGTH" => "2", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ContaNaturezaSaldo;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ContaDataUltimaAtualizacaoSaldo;


	public function setContaID($ContaID){
		$this->ContaID = $ContaID;
	}

	public function getContaID(){
		return $this->ContaID;
	}

	public function setContaNome($ContaNome){
		$this->ContaNome = $ContaNome;
	}

	public function getContaNome(){
		return $this->ContaNome;
	}

	public function setContaDescricao($ContaDescricao){
		$this->ContaDescricao = $ContaDescricao;
	}

	public function getContaDescricao(){
		return $this->ContaDescricao;
	}

	public function setContaDataInicio($ContaDataInicio){
		$this->ContaDataInicio = $ContaDataInicio;
	}

	public function getContaDataInicio($mascara = 'Y-m-d H:i:s'){
		if ($this->ContaDataInicio != null){
			return date($mascara, strtotime(str_replace('/','-', $this->ContaDataInicio)));
		} else {
			return $this->ContaDataInicio;
		}
	}

	public function setContaDataFim($ContaDataFim){
		$this->ContaDataFim = $ContaDataFim;
	}

	public function getContaDataFim($mascara = 'Y-m-d H:i:s'){
		if ($this->ContaDataFim != null){
			return date($mascara, strtotime(str_replace('/','-', $this->ContaDataFim)));
		} else {
			return $this->ContaDataFim;
		}
	}

	public function setContaNatureza($ContaNatureza){
		$this->ContaNatureza = $ContaNatureza;
	}

	public function getContaNatureza(){
		return $this->ContaNatureza;
	}

	public function setContaTipo($ContaTipo){
		$this->ContaTipo = $ContaTipo;
	}

	public function getContaTipo(){
		return $this->ContaTipo;
	}

	public function setContaGrupo($ContaGrupo){
		$this->ContaGrupo = $ContaGrupo;
	}

	public function getContaGrupo(){
		return $this->ContaGrupo;
	}

	public function setContaSaldoAtual($ContaSaldoAtual){
		$this->ContaSaldoAtual = $ContaSaldoAtual;
	}

	public function getContaSaldoAtual(){
		return $this->ContaSaldoAtual;
	}

	public function setContaNaturezaSaldo($ContaNaturezaSaldo){
		$this->ContaNaturezaSaldo = $ContaNaturezaSaldo;
	}

	public function getContaNaturezaSaldo(){
		return $this->ContaNaturezaSaldo;
	}

	public function setContaDataUltimaAtualizacaoSaldo($ContaDataUltimaAtualizacaoSaldo){
		$this->ContaDataUltimaAtualizacaoSaldo = $ContaDataUltimaAtualizacaoSaldo;
	}

	public function getContaDataUltimaAtualizacaoSaldo($mascara = 'Y-m-d H:i:s'){
		if ($this->ContaDataUltimaAtualizacaoSaldo != null){
			return date($mascara, strtotime(str_replace('/','-', $this->ContaDataUltimaAtualizacaoSaldo)));
		} else {
			return $this->ContaDataUltimaAtualizacaoSaldo;
		}
	}

	public function toHash(){
		 return $this->ContaID;
	}

	public function toString(){
		return $this->ContaID . " - " . $this->ContaNome . " - " . $this->ContaDescricao . " - " . $this->ContaDataInicio . " - " . $this->ContaDataFim . " - " . $this->ContaNatureza . " - " . $this->ContaTipo . " - " . $this->ContaGrupo . " - " . $this->ContaSaldoAtual . " - " . $this->ContaNaturezaSaldo . " - " . $this->ContaDataUltimaAtualizacaoSaldo;
	}

}
?>