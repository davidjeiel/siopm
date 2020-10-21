<?php 
class AtivosSituacoes { 

	const TABLE_NAME = "tblAtivosSituacoes";
	const COLUMN_KEY = "AtivoSituacaoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $AtivoSituacaoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoSituacaoNome;

	/**
	* @var "TYPE" => "string", "LENGTH" => "16", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoSituacaoDescricao;


	public function setAtivoSituacaoID($AtivoSituacaoID){
		$this->AtivoSituacaoID = $AtivoSituacaoID;
	}

	public function getAtivoSituacaoID(){
		return $this->AtivoSituacaoID;
	}

	public function setAtivoSituacaoNome($AtivoSituacaoNome){
		$this->AtivoSituacaoNome = $AtivoSituacaoNome;
	}

	public function getAtivoSituacaoNome(){
		return $this->AtivoSituacaoNome;
	}

	public function setAtivoSituacaoDescricao($AtivoSituacaoDescricao){
		$this->AtivoSituacaoDescricao = $AtivoSituacaoDescricao;
	}

	public function getAtivoSituacaoDescricao(){
		return $this->AtivoSituacaoDescricao;
	}

	public function toHash(){
		 return $this->AtivoSituacaoID;
	}

	public function toString(){
		return $this->AtivoSituacaoID . " - " . $this->AtivoSituacaoNome . " - " . $this->AtivoSituacaoDescricao;
	}

}
?>