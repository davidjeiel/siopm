<?php 
class PropostasManifSecuritizadoras { 

	const TABLE_NAME = "tblPropostasManifSecuritizadoras";
	const COLUMN_KEY = "PropManifSecurID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PropManifSecurID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropostaDetalheID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "1000", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropManifSecurAnaliseEngImoveis;

	/**
	* @var "TYPE" => "string", "LENGTH" => "1000", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropManifSecurAnaliseTrabSocial;

	/**
	* @var "TYPE" => "string", "LENGTH" => "1000", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PropManifSecurAnaliseJurImoveis;

	/**
	* @var "TYPE" => "string", "LENGTH" => "2000", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ConclusaoManifSecuritizadora;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $DataConclusaoManifSecuritizadora;


	public function setPropManifSecurID($PropManifSecurID){
		$this->PropManifSecurID = $PropManifSecurID;
	}

	public function getPropManifSecurID(){
		return $this->PropManifSecurID;
	}

	public function setPropostaDetalheID($PropostaDetalheID){
		$this->PropostaDetalheID = $PropostaDetalheID;
	}

	public function getPropostaDetalheID(){
		return $this->PropostaDetalheID;
	}

	public function setPropManifSecurAnaliseEngImoveis($PropManifSecurAnaliseEngImoveis){
		$this->PropManifSecurAnaliseEngImoveis = $PropManifSecurAnaliseEngImoveis;
	}

	public function getPropManifSecurAnaliseEngImoveis(){
		return $this->PropManifSecurAnaliseEngImoveis;
	}

	public function setPropManifSecurAnaliseTrabSocial($PropManifSecurAnaliseTrabSocial){
		$this->PropManifSecurAnaliseTrabSocial = $PropManifSecurAnaliseTrabSocial;
	}

	public function getPropManifSecurAnaliseTrabSocial(){
		return $this->PropManifSecurAnaliseTrabSocial;
	}

	public function setPropManifSecurAnaliseJurImoveis($PropManifSecurAnaliseJurImoveis){
		$this->PropManifSecurAnaliseJurImoveis = $PropManifSecurAnaliseJurImoveis;
	}

	public function getPropManifSecurAnaliseJurImoveis(){
		return $this->PropManifSecurAnaliseJurImoveis;
	}

	public function setConclusaoManifSecuritizadora($ConclusaoManifSecuritizadora){
		$this->ConclusaoManifSecuritizadora = $ConclusaoManifSecuritizadora;
	}

	public function getConclusaoManifSecuritizadora(){
		return $this->ConclusaoManifSecuritizadora;
	}

	public function setDataConclusaoManifSecuritizadora($DataConclusaoManifSecuritizadora){
		$this->DataConclusaoManifSecuritizadora = $DataConclusaoManifSecuritizadora;
	}

	public function getDataConclusaoManifSecuritizadora($mascara = 'Y-m-d H:i:s'){
		if ($this->DataConclusaoManifSecuritizadora != null){
			return date($mascara, strtotime(str_replace('/','-', $this->DataConclusaoManifSecuritizadora)));
		} else {
			return $this->DataConclusaoManifSecuritizadora;
		}
	}

	public function toHash(){
		 return $this->PropManifSecurID;
	}

	public function toString(){
		return $this->PropManifSecurID . " - " . $this->PropostaDetalheID . " - " . $this->PropManifSecurAnaliseEngImoveis . " - " . $this->PropManifSecurAnaliseTrabSocial . " - " . $this->PropManifSecurAnaliseJurImoveis . " - " . $this->ConclusaoManifSecuritizadora . " - " . $this->DataConclusaoManifSecuritizadora;
	}

}
?>