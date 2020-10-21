<?php 
class PropostasManifGefom { 

	const TABLE_NAME = "tblPropostasManifGefom";
	const COLUMN_KEY = "PropManifGefomID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PropManifGefomID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropostaDetalheID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $GefomConclusaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $GefomArquivoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "20", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $GefomOficioVoto;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ManifGefomData;

	/**
	* @var "TYPE" => "string", "LENGTH" => "2000", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ManifGefomObs;


	public function setPropManifGefomID($PropManifGefomID){
		$this->PropManifGefomID = $PropManifGefomID;
	}

	public function getPropManifGefomID(){
		return $this->PropManifGefomID;
	}

	public function setPropostaDetalheID($PropostaDetalheID){
		$this->PropostaDetalheID = $PropostaDetalheID;
	}

	public function getPropostaDetalheID(){
		return $this->PropostaDetalheID;
	}

	public function setGefomConclusaoID($GefomConclusaoID){
		$this->GefomConclusaoID = $GefomConclusaoID;
	}

	public function getGefomConclusaoID(){
		return $this->GefomConclusaoID;
	}

	public function setGefomArquivoID($GefomArquivoID){
		$this->GefomArquivoID = $GefomArquivoID;
	}

	public function getGefomArquivoID(){
		return $this->GefomArquivoID;
	}

	public function setGefomOficioVoto($GefomOficioVoto){
		$this->GefomOficioVoto = $GefomOficioVoto;
	}

	public function getGefomOficioVoto(){
		return $this->GefomOficioVoto;
	}

	public function setManifGefomData($ManifGefomData){
		$this->ManifGefomData = $ManifGefomData;
	}

	public function getManifGefomData($mascara = 'Y-m-d H:i:s'){
		if ($this->ManifGefomData != null){
			return date($mascara, strtotime(str_replace('/','-', $this->ManifGefomData)));
		} else {
			return $this->ManifGefomData;
		}
	}

	public function setManifGefomObs($ManifGefomObs){
		$this->ManifGefomObs = $ManifGefomObs;
	}

	public function getManifGefomObs(){
		return $this->ManifGefomObs;
	}

	public function toHash(){
		 return $this->PropManifGefomID;
	}

	public function toString(){
		return $this->PropManifGefomID . " - " . $this->PropostaDetalheID . " - " . $this->GefomConclusaoID . " - " . $this->GefomArquivoID . " - " . $this->GefomOficioVoto . " - " . $this->ManifGefomData . " - " . $this->ManifGefomObs;
	}

}
?>