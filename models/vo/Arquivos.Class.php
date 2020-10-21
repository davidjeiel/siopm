<?php 
class Arquivos { 

	const TABLE_NAME = "tblArquivos";
	const COLUMN_KEY = "ArquivoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $ArquivoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "7", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ArquivoMatricula;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ArquivoNome;

	/**
	* @var "TYPE" => "string", "LENGTH" => "20", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ArquivoExtensao;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ArquivoMimeType;

	/**
	* @var "TYPE" => "string", "LENGTH" => "500", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ArquivoDescricao;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ArquivoTamanho;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ArquivoDataCadastro;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ArquivoDataAlteracao;

	/**
	* @var "TYPE" => "string", "LENGTH" => "500", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Arquivo;


	public function setArquivoID($ArquivoID){
		$this->ArquivoID = $ArquivoID;
	}

	public function getArquivoID(){
		return $this->ArquivoID;
	}

	public function setArquivoMatricula($ArquivoMatricula){
		$this->ArquivoMatricula = $ArquivoMatricula;
	}

	public function getArquivoMatricula(){
		return $this->ArquivoMatricula;
	}

	public function setArquivoNome($ArquivoNome){
		$this->ArquivoNome = $ArquivoNome;
	}

	public function getArquivoNome(){
		return $this->ArquivoNome;
	}

	public function setArquivoExtensao($ArquivoExtensao){
		$this->ArquivoExtensao = $ArquivoExtensao;
	}

	public function getArquivoExtensao(){
		return $this->ArquivoExtensao;
	}

	public function setArquivoMimeType($ArquivoMimeType){
		$this->ArquivoMimeType = $ArquivoMimeType;
	}

	public function getArquivoMimeType(){
		return $this->ArquivoMimeType;
	}

	public function setArquivoDescricao($ArquivoDescricao){
		$this->ArquivoDescricao = $ArquivoDescricao;
	}

	public function getArquivoDescricao(){
		return $this->ArquivoDescricao;
	}

	public function setArquivoTamanho($ArquivoTamanho){
		$this->ArquivoTamanho = $ArquivoTamanho;
	}

	public function getArquivoTamanho(){
		return $this->ArquivoTamanho;
	}

	public function setArquivoDataCadastro($ArquivoDataCadastro){
		$this->ArquivoDataCadastro = $ArquivoDataCadastro;
	}

	public function getArquivoDataCadastro($mascara = 'Y-m-d H:i:s'){
		if ($this->ArquivoDataCadastro != null){
			return date($mascara, strtotime(str_replace('/','-', $this->ArquivoDataCadastro)));
		} else {
			return $this->ArquivoDataCadastro;
		}
	}

	public function setArquivoDataAlteracao($ArquivoDataAlteracao){
		$this->ArquivoDataAlteracao = $ArquivoDataAlteracao;
	}

	public function getArquivoDataAlteracao($mascara = 'Y-m-d H:i:s'){
		if ($this->ArquivoDataAlteracao != null){
			return date($mascara, strtotime(str_replace('/','-', $this->ArquivoDataAlteracao)));
		} else {
			return $this->ArquivoDataAlteracao;
		}
	}

	public function setArquivo($Arquivo){
		$this->Arquivo = $Arquivo;
	}

	public function getArquivo(){
		return $this->Arquivo;
	}

	public function toHash(){
		 return $this->ArquivoID;
	}

	public function toString(){
		return $this->ArquivoID . " - " . $this->ArquivoMatricula . " - " . $this->ArquivoNome . " - " . $this->ArquivoExtensao . " - " . $this->ArquivoMimeType . " - " . $this->ArquivoDescricao . " - " . $this->ArquivoTamanho . " - " . $this->ArquivoDataCadastro . " - " . $this->ArquivoDataAlteracao . " - " . $this->Arquivo;
	}

}
?>