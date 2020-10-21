<?php 
class PropostasRequisIntegralizacoes { 

	const TABLE_NAME = "tblPropostasRequisIntegralizacoes";
	const COLUMN_KEY = "PropRequisIntegralizacaoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PropRequisIntegralizacaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropRequisIntegraTipoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropostaID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropPossueRequisito;

	/**
	* @var "TYPE" => "string", "LENGTH" => "1000", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $Observacoes;


	public function setPropRequisIntegralizacaoID($PropRequisIntegralizacaoID){
		$this->PropRequisIntegralizacaoID = $PropRequisIntegralizacaoID;
	}

	public function getPropRequisIntegralizacaoID(){
		return $this->PropRequisIntegralizacaoID;
	}

	public function setPropRequisIntegraTipoID($PropRequisIntegraTipoID){
		$this->PropRequisIntegraTipoID = $PropRequisIntegraTipoID;
	}

	public function getPropRequisIntegraTipoID(){
		return $this->PropRequisIntegraTipoID;
	}

	public function setPropostaID($PropostaID){
		$this->PropostaID = $PropostaID;
	}

	public function getPropostaID(){
		return $this->PropostaID;
	}

	public function setPropPossueRequisito($PropPossueRequisito){
		$this->PropPossueRequisito = $PropPossueRequisito;
	}

	public function getPropPossueRequisito(){
		return $this->PropPossueRequisito;
	}

	public function setObservacoes($Observacoes){
		$this->Observacoes = $Observacoes;
	}

	public function getObservacoes(){
		return $this->Observacoes;
	}

	public function toHash(){
		 return $this->PropRequisIntegralizacaoID;
	}

	public function toString(){
		return $this->PropRequisIntegralizacaoID . " - " . $this->PropRequisIntegraTipoID . " - " . $this->PropostaID . " - " . $this->PropPossueRequisito . " - " . $this->Observacoes;
	}

}
?>