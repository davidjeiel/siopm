<?php 
class PropostasRequisIntegralizacoesTipos { 

	const TABLE_NAME = "tblPropostasRequisIntegralizacoesTipos";
	const COLUMN_KEY = "PropRequisIntegraTipoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PropRequisIntegraTipoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "500", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropRequisIntegraTipoNome;


	public function setPropRequisIntegraTipoID($PropRequisIntegraTipoID){
		$this->PropRequisIntegraTipoID = $PropRequisIntegraTipoID;
	}

	public function getPropRequisIntegraTipoID(){
		return $this->PropRequisIntegraTipoID;
	}

	public function setPropRequisIntegraTipoNome($PropRequisIntegraTipoNome){
		$this->PropRequisIntegraTipoNome = $PropRequisIntegraTipoNome;
	}

	public function getPropRequisIntegraTipoNome(){
		return $this->PropRequisIntegraTipoNome;
	}

	public function toHash(){
		 return $this->PropRequisIntegraTipoID;
	}

	public function toString(){
		return $this->PropRequisIntegraTipoID . " - " . $this->PropRequisIntegraTipoNome;
	}

}
?>