<?php 
class AtivosLiquidacoesTipos { 

	const TABLE_NAME = "tblAtivosLiquidacoesTipos";
	const COLUMN_KEY = "AtivoLiquidacaoTipoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $AtivoLiquidacaoTipoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "200", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $AtivoLiquidacaoTipoNome;


	public function setAtivoLiquidacaoTipoID($AtivoLiquidacaoTipoID){
		$this->AtivoLiquidacaoTipoID = $AtivoLiquidacaoTipoID;
	}

	public function getAtivoLiquidacaoTipoID(){
		return $this->AtivoLiquidacaoTipoID;
	}

	public function setAtivoLiquidacaoTipoNome($AtivoLiquidacaoTipoNome){
		$this->AtivoLiquidacaoTipoNome = $AtivoLiquidacaoTipoNome;
	}

	public function getAtivoLiquidacaoTipoNome(){
		return $this->AtivoLiquidacaoTipoNome;
	}

	public function toHash(){
		 return $this->AtivoLiquidacaoTipoID;
	}

	public function toString(){
		return $this->AtivoLiquidacaoTipoID . " - " . $this->AtivoLiquidacaoTipoNome;
	}

}
?>