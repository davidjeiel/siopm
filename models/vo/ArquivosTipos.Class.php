<?php 
class ArquivosTipos { 

	const TABLE_NAME = "tblArquivosTipos";
	const COLUMN_KEY = "ArquivoTipoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ArquivoTipoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "20", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ArquivoTipoExtensao;

	/**
	* @var "TYPE" => "string", "LENGTH" => "150", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ArquivoTipoConteudoMime;


	public function setArquivoTipoID($ArquivoTipoID){
		$this->ArquivoTipoID = $ArquivoTipoID;
	}

	public function getArquivoTipoID(){
		return $this->ArquivoTipoID;
	}

	public function setArquivoTipoExtensao($ArquivoTipoExtensao){
		$this->ArquivoTipoExtensao = $ArquivoTipoExtensao;
	}

	public function getArquivoTipoExtensao(){
		return $this->ArquivoTipoExtensao;
	}

	public function setArquivoTipoConteudoMime($ArquivoTipoConteudoMime){
		$this->ArquivoTipoConteudoMime = $ArquivoTipoConteudoMime;
	}

	public function getArquivoTipoConteudoMime(){
		return $this->ArquivoTipoConteudoMime;
	}

	public function toHash(){
		 return $this->ArquivoTipoID;
	}

	public function toString(){
		return $this->ArquivoTipoID . " - " . $this->ArquivoTipoExtensao . " - " . $this->ArquivoTipoConteudoMime;
	}

}
?>