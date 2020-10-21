<?php 
class AtivosArquivosTipos { 

	const TABLE_NAME = "tblAtivosArquivosTipos";
	const COLUMN_KEY = "AtivoArquivoTipoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $AtivoArquivoTipoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $AtivoArquivoDescricao;


	public function setAtivoArquivoTipoID($AtivoArquivoTipoID){
		$this->AtivoArquivoTipoID = $AtivoArquivoTipoID;
	}

	public function getAtivoArquivoTipoID(){
		return $this->AtivoArquivoTipoID;
	}

	public function setAtivoArquivoDescricao($AtivoArquivoDescricao){
		$this->AtivoArquivoDescricao = $AtivoArquivoDescricao;
	}

	public function getAtivoArquivoDescricao(){
		return $this->AtivoArquivoDescricao;
	}

	public function toHash(){
		 return $this->AtivoArquivoTipoID;
	}

	public function toString(){
		return $this->AtivoArquivoTipoID . " - " . $this->AtivoArquivoDescricao;
	}

}
?>