<?php 
class AtivosArquivos { 

	const TABLE_NAME = "tblAtivosArquivos";
	const COLUMN_KEY = "AtivoArquivoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $AtivoArquivoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $AtivoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $AtivoArquivoTipoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ArquivoID;


	public function setAtivoArquivoID($AtivoArquivoID){
		$this->AtivoArquivoID = $AtivoArquivoID;
	}

	public function getAtivoArquivoID(){
		return $this->AtivoArquivoID;
	}

	public function setAtivoID($AtivoID){
		$this->AtivoID = $AtivoID;
	}

	public function getAtivoID(){
		return $this->AtivoID;
	}

	public function setAtivoArquivoTipoID($AtivoArquivoTipoID){
		$this->AtivoArquivoTipoID = $AtivoArquivoTipoID;
	}

	public function getAtivoArquivoTipoID(){
		return $this->AtivoArquivoTipoID;
	}

	public function setArquivoID($ArquivoID){
		$this->ArquivoID = $ArquivoID;
	}

	public function getArquivoID(){
		return $this->ArquivoID;
	}

	public function toHash(){
		 return $this->AtivoArquivoID;
	}

	public function toString(){
		return $this->AtivoArquivoID . " - " . $this->AtivoID . " - " . $this->AtivoArquivoTipoID . " - " . $this->ArquivoID;
	}

}
?>