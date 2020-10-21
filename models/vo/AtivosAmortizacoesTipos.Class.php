<?php 
class AtivosAmortizacoesTipos { 

	const TABLE_NAME = "tblAtivosAmortizacoesTipos";
	const COLUMN_KEY = "AtivoAmortizacaoTipoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $AtivoAmortizacaoTipoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoAmortizacaoTipoNome;


	public function setAtivoAmortizacaoTipoID($AtivoAmortizacaoTipoID){
		$this->AtivoAmortizacaoTipoID = $AtivoAmortizacaoTipoID;
	}

	public function getAtivoAmortizacaoTipoID(){
		return $this->AtivoAmortizacaoTipoID;
	}

	public function setAtivoAmortizacaoTipoNome($AtivoAmortizacaoTipoNome){
		$this->AtivoAmortizacaoTipoNome = $AtivoAmortizacaoTipoNome;
	}

	public function getAtivoAmortizacaoTipoNome(){
		return $this->AtivoAmortizacaoTipoNome;
	}

	public function toHash(){
		 return $this->AtivoAmortizacaoTipoID;
	}

	public function toString(){
		return $this->AtivoAmortizacaoTipoID . " - " . $this->AtivoAmortizacaoTipoNome;
	}

}
?>