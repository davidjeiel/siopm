<?php 
class PropostasArquivosTipos { 

	const TABLE_NAME = "tblPropostasArquivosTipos";
	const COLUMN_KEY = "PropostaArquivoTipoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PropostaArquivoTipoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropostaArquivoDescricao;


	public function setPropostaArquivoTipoID($PropostaArquivoTipoID){
		$this->PropostaArquivoTipoID = $PropostaArquivoTipoID;
	}

	public function getPropostaArquivoTipoID(){
		return $this->PropostaArquivoTipoID;
	}

	public function setPropostaArquivoDescricao($PropostaArquivoDescricao){
		$this->PropostaArquivoDescricao = $PropostaArquivoDescricao;
	}

	public function getPropostaArquivoDescricao(){
		return $this->PropostaArquivoDescricao;
	}

	public function toHash(){
		 return $this->PropostaArquivoTipoID;
	}

	public function toString(){
		return $this->PropostaArquivoTipoID . " - " . $this->PropostaArquivoDescricao;
	}

}
?>