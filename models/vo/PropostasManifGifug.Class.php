<?php 
class PropostasManifGifug { 

	const TABLE_NAME = "tblPropostasManifGifug";
	const COLUMN_KEY = "PropManifGifugID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PropManifGifugID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropostaDetalheID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $GifugConclusaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $GifugArquivoID;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ManifGifugData;

	/**
	* @var "TYPE" => "string", "LENGTH" => "2000", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ManifGifugObs;


	public function setPropManifGifugID($PropManifGifugID){
		$this->PropManifGifugID = $PropManifGifugID;
	}

	public function getPropManifGifugID(){
		return $this->PropManifGifugID;
	}

	public function setPropostaDetalheID($PropostaDetalheID){
		$this->PropostaDetalheID = $PropostaDetalheID;
	}

	public function getPropostaDetalheID(){
		return $this->PropostaDetalheID;
	}

	public function setGifugConclusaoID($GifugConclusaoID){
		$this->GifugConclusaoID = $GifugConclusaoID;
	}

	public function getGifugConclusaoID(){
		return $this->GifugConclusaoID;
	}

	public function setGifugArquivoID($GifugArquivoID){
		$this->GifugArquivoID = $GifugArquivoID;
	}

	public function getGifugArquivoID(){
		return $this->GifugArquivoID;
	}

	public function setManifGifugData($ManifGifugData){
		$this->ManifGifugData = $ManifGifugData;
	}

	public function getManifGifugData($mascara = 'Y-m-d H:i:s'){
		if ($this->ManifGifugData != null){
			return date($mascara, strtotime(str_replace('/','-', $this->ManifGifugData)));
		} else {
			return $this->ManifGifugData;
		}
	}

	public function setManifGifugObs($ManifGifugObs){
		$this->ManifGifugObs = $ManifGifugObs;
	}

	public function getManifGifugObs(){
		return $this->ManifGifugObs;
	}

	public function toHash(){
		 return $this->PropManifGifugID;
	}

	public function toString(){
		return $this->PropManifGifugID . " - " . $this->PropostaDetalheID . " - " . $this->GifugConclusaoID . " - " . $this->GifugArquivoID . " - " . $this->ManifGifugData . " - " . $this->ManifGifugObs;
	}

}
?>