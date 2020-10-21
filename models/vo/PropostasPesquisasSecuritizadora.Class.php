<?php 
class PropostasPesquisasSecuritizadora { 

	const TABLE_NAME = "tblPropostasPesquisasSecuritizadora";
	const COLUMN_KEY = "PropPesqSecurID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PropPesqSecurID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropostaDetalheID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "2", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $CRFRegular;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $CRFValidade;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "2", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $CADINRegular;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $CADINDataPesquisa;


	public function setPropPesqSecurID($PropPesqSecurID){
		$this->PropPesqSecurID = $PropPesqSecurID;
	}

	public function getPropPesqSecurID(){
		return $this->PropPesqSecurID;
	}

	public function setPropostaDetalheID($PropostaDetalheID){
		$this->PropostaDetalheID = $PropostaDetalheID;
	}

	public function getPropostaDetalheID(){
		return $this->PropostaDetalheID;
	}

	public function setCRFRegular($CRFRegular){
		$this->CRFRegular = $CRFRegular;
	}

	public function getCRFRegular(){
		return $this->CRFRegular;
	}

	public function setCRFValidade($CRFValidade){
		$this->CRFValidade = $CRFValidade;
	}

	public function getCRFValidade($mascara = 'Y-m-d H:i:s'){
		if ($this->CRFValidade != null){
			return date($mascara, strtotime(str_replace('/','-', $this->CRFValidade)));
		} else {
			return $this->CRFValidade;
		}
	}

	public function setCADINRegular($CADINRegular){
		$this->CADINRegular = $CADINRegular;
	}

	public function getCADINRegular(){
		return $this->CADINRegular;
	}

	public function setCADINDataPesquisa($CADINDataPesquisa){
		$this->CADINDataPesquisa = $CADINDataPesquisa;
	}

	public function getCADINDataPesquisa($mascara = 'Y-m-d H:i:s'){
		if ($this->CADINDataPesquisa != null){
			return date($mascara, strtotime(str_replace('/','-', $this->CADINDataPesquisa)));
		} else {
			return $this->CADINDataPesquisa;
		}
	}

	public function toHash(){
		 return $this->PropPesqSecurID;
	}

	public function toString(){
		return $this->PropPesqSecurID . " - " . $this->PropostaDetalheID . " - " . $this->CRFRegular . " - " . $this->CRFValidade . " - " . $this->CADINRegular . " - " . $this->CADINDataPesquisa;
	}

}
?>