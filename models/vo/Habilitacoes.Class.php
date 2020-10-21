<?php 
class Habilitacoes { 

	const TABLE_NAME = "tblHabilitacoes";
	const COLUMN_KEY = "HabilitacaoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $HabilitacaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $EntidadeID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $UnidadeID;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabilitacaoDataRecebimento;

	/**
	* @var "TYPE" => "string", "LENGTH" => "7", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $HabilitacaoMatriculaCadastro;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $HabilitacaoDataCadastro;

	/**
	* @var "TYPE" => "string", "LENGTH" => "7", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabilitacaoMatriculaUltimoUpdade;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabilitacaoDataUltimoUpdate;

	/**
	* @var "TYPE" => "string", "LENGTH" => "7", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabilitacaoMatriculaFinalizacao;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabilitacaoDataFinalizacao;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabilitacaoValidade;

	/**
	* @var "TYPE" => "string", "LENGTH" => "2000", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabilitacaoObservacoes;

	/**
	* @var "TYPE" => "string", "LENGTH" => "10", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabilitacaoRating;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabilitacaoConclusaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabilitacaoAtiva;


	public function setHabilitacaoID($HabilitacaoID){
		$this->HabilitacaoID = $HabilitacaoID;
	}

	public function getHabilitacaoID(){
		return $this->HabilitacaoID;
	}

	public function setEntidadeID($EntidadeID){
		$this->EntidadeID = $EntidadeID;
	}

	public function getEntidadeID(){
		return $this->EntidadeID;
	}

	public function setUnidadeID($UnidadeID){
		$this->UnidadeID = $UnidadeID;
	}

	public function getUnidadeID(){
		return $this->UnidadeID;
	}

	public function setHabilitacaoDataRecebimento($HabilitacaoDataRecebimento){
		$this->HabilitacaoDataRecebimento = $HabilitacaoDataRecebimento;
	}

	public function getHabilitacaoDataRecebimento($mascara = 'Y-m-d H:i:s'){
		if ($this->HabilitacaoDataRecebimento != null){
			return date($mascara, strtotime(str_replace('/','-', $this->HabilitacaoDataRecebimento)));
		} else {
			return $this->HabilitacaoDataRecebimento;
		}
	}

	public function setHabilitacaoMatriculaCadastro($HabilitacaoMatriculaCadastro){
		$this->HabilitacaoMatriculaCadastro = $HabilitacaoMatriculaCadastro;
	}

	public function getHabilitacaoMatriculaCadastro(){
		return $this->HabilitacaoMatriculaCadastro;
	}

	public function setHabilitacaoDataCadastro($HabilitacaoDataCadastro){
		$this->HabilitacaoDataCadastro = $HabilitacaoDataCadastro;
	}

	public function getHabilitacaoDataCadastro($mascara = 'Y-m-d H:i:s'){
		if ($this->HabilitacaoDataCadastro != null){
			return date($mascara, strtotime(str_replace('/','-', $this->HabilitacaoDataCadastro)));
		} else {
			return $this->HabilitacaoDataCadastro;
		}
	}

	public function setHabilitacaoMatriculaUltimoUpdade($HabilitacaoMatriculaUltimoUpdade){
		$this->HabilitacaoMatriculaUltimoUpdade = $HabilitacaoMatriculaUltimoUpdade;
	}

	public function getHabilitacaoMatriculaUltimoUpdade(){
		return $this->HabilitacaoMatriculaUltimoUpdade;
	}

	public function setHabilitacaoDataUltimoUpdate($HabilitacaoDataUltimoUpdate){
		$this->HabilitacaoDataUltimoUpdate = $HabilitacaoDataUltimoUpdate;
	}

	public function getHabilitacaoDataUltimoUpdate($mascara = 'Y-m-d H:i:s'){
		if ($this->HabilitacaoDataUltimoUpdate != null){
			return date($mascara, strtotime(str_replace('/','-', $this->HabilitacaoDataUltimoUpdate)));
		} else {
			return $this->HabilitacaoDataUltimoUpdate;
		}
	}

	public function setHabilitacaoMatriculaFinalizacao($HabilitacaoMatriculaFinalizacao){
		$this->HabilitacaoMatriculaFinalizacao = $HabilitacaoMatriculaFinalizacao;
	}

	public function getHabilitacaoMatriculaFinalizacao(){
		return $this->HabilitacaoMatriculaFinalizacao;
	}

	public function setHabilitacaoDataFinalizacao($HabilitacaoDataFinalizacao){
		$this->HabilitacaoDataFinalizacao = $HabilitacaoDataFinalizacao;
	}

	public function getHabilitacaoDataFinalizacao($mascara = 'Y-m-d H:i:s'){
		if ($this->HabilitacaoDataFinalizacao != null){
			return date($mascara, strtotime(str_replace('/','-', $this->HabilitacaoDataFinalizacao)));
		} else {
			return $this->HabilitacaoDataFinalizacao;
		}
	}

	public function setHabilitacaoValidade($HabilitacaoValidade){
		$this->HabilitacaoValidade = $HabilitacaoValidade;
	}

	public function getHabilitacaoValidade($mascara = 'Y-m-d H:i:s'){
		if ($this->HabilitacaoValidade != null){
			return date($mascara, strtotime(str_replace('/','-', $this->HabilitacaoValidade)));
		} else {
			return $this->HabilitacaoValidade;
		}
	}

	public function setHabilitacaoObservacoes($HabilitacaoObservacoes){
		$this->HabilitacaoObservacoes = $HabilitacaoObservacoes;
	}

	public function getHabilitacaoObservacoes(){
		return $this->HabilitacaoObservacoes;
	}

	public function setHabilitacaoRating($HabilitacaoRating){
		$this->HabilitacaoRating = $HabilitacaoRating;
	}

	public function getHabilitacaoRating(){
		return $this->HabilitacaoRating;
	}

	public function setHabilitacaoConclusaoID($HabilitacaoConclusaoID){
		$this->HabilitacaoConclusaoID = $HabilitacaoConclusaoID;
	}

	public function getHabilitacaoConclusaoID(){
		return $this->HabilitacaoConclusaoID;
	}

	public function setHabilitacaoAtiva($HabilitacaoAtiva){
		$this->HabilitacaoAtiva = $HabilitacaoAtiva;
	}

	public function getHabilitacaoAtiva(){
		return $this->HabilitacaoAtiva;
	}

	public function toHash(){
		 return $this->HabilitacaoID;
	}

	public function toString(){
		return $this->HabilitacaoID . " - " . $this->EntidadeID . " - " . $this->UnidadeID . " - " . $this->HabilitacaoDataRecebimento . " - " . $this->HabilitacaoMatriculaCadastro . " - " . $this->HabilitacaoDataCadastro . " - " . $this->HabilitacaoMatriculaUltimoUpdade . " - " . $this->HabilitacaoDataUltimoUpdate . " - " . $this->HabilitacaoMatriculaFinalizacao . " - " . $this->HabilitacaoDataFinalizacao . " - " . $this->HabilitacaoValidade . " - " . $this->HabilitacaoObservacoes . " - " . $this->HabilitacaoRating . " - " . $this->HabilitacaoConclusaoID . " - " . $this->HabilitacaoAtiva;
	}

}
?>