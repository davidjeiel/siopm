<?php 
class OrcamentosTipo { 

	const TABLE_NAME = "tblOrcamentosTipo";
	const COLUMN_KEY = "OrcamentoTipoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $OrcamentoTipoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $OrcamentoTipoNome;


	public function setOrcamentoTipoID($OrcamentoTipoID){
		$this->OrcamentoTipoID = $OrcamentoTipoID;
	}

	public function getOrcamentoTipoID(){
		return $this->OrcamentoTipoID;
	}

	public function setOrcamentoTipoNome($OrcamentoTipoNome){
		$this->OrcamentoTipoNome = $OrcamentoTipoNome;
	}

	public function getOrcamentoTipoNome(){
		return $this->OrcamentoTipoNome;
	}

	public function toHash(){
		 return $this->OrcamentoTipoID;
	}

	public function toString(){
		return $this->OrcamentoTipoID . " - " . $this->OrcamentoTipoNome;
	}

}
?>