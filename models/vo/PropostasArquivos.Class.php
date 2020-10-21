<?php 
class PropostasArquivos { 

	const TABLE_NAME = "tblPropostasArquivos";
	const COLUMN_KEY = "PropostaArquivoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PropostaArquivoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropostaDetalheID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropostaArquivoTipoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ArquivoID;


	public function setPropostaArquivoID($PropostaArquivoID){
		$this->PropostaArquivoID = $PropostaArquivoID;
	}

	public function getPropostaArquivoID(){
		return $this->PropostaArquivoID;
	}

	public function setPropostaDetalheID($PropostaDetalheID){
		$this->PropostaDetalheID = $PropostaDetalheID;
	}

	public function getPropostaDetalheID(){
		return $this->PropostaDetalheID;
	}

	public function setPropostaArquivoTipoID($PropostaArquivoTipoID){
		$this->PropostaArquivoTipoID = $PropostaArquivoTipoID;
	}

	public function getPropostaArquivoTipoID(){
		return $this->PropostaArquivoTipoID;
	}

	public function setArquivoID($ArquivoID){
		$this->ArquivoID = $ArquivoID;
	}

	public function getArquivoID(){
		return $this->ArquivoID;
	}

	public function toHash(){
		 return $this->PropostaArquivoID;
	}

	public function toString(){
		return $this->PropostaArquivoID . " - " . $this->PropostaDetalheID . " - " . $this->PropostaArquivoTipoID . " - " . $this->ArquivoID;
	}

}
?>