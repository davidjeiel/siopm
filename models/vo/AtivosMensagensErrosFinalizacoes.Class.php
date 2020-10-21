<?php 
class AtivosMensagensErrosFinalizacoes { 

	const TABLE_NAME = "tblAtivosMensagensErrosFinalizacoes";
	const COLUMN_KEY = "AtivoMensagemErroFinalizacaoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $AtivoMensagemErroFinalizacaoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $TabelaID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $CampoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $CampoNome;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $CampoTipoTeste;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ControllerAcao;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $NomeJanelaLocal;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $Aba;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AbaID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "510", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $MensagemErroPadrao;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $TesteCampoAtivo;


	public function setAtivoMensagemErroFinalizacaoID($AtivoMensagemErroFinalizacaoID){
		$this->AtivoMensagemErroFinalizacaoID = $AtivoMensagemErroFinalizacaoID;
	}

	public function getAtivoMensagemErroFinalizacaoID(){
		return $this->AtivoMensagemErroFinalizacaoID;
	}

	public function setTabelaID($TabelaID){
		$this->TabelaID = $TabelaID;
	}

	public function getTabelaID(){
		return $this->TabelaID;
	}

	public function setCampoID($CampoID){
		$this->CampoID = $CampoID;
	}

	public function getCampoID(){
		return $this->CampoID;
	}

	public function setCampoNome($CampoNome){
		$this->CampoNome = $CampoNome;
	}

	public function getCampoNome(){
		return $this->CampoNome;
	}

	public function setCampoTipoTeste($CampoTipoTeste){
		$this->CampoTipoTeste = $CampoTipoTeste;
	}

	public function getCampoTipoTeste(){
		return $this->CampoTipoTeste;
	}

	public function setControllerAcao($ControllerAcao){
		$this->ControllerAcao = $ControllerAcao;
	}

	public function getControllerAcao(){
		return $this->ControllerAcao;
	}

	public function setNomeJanelaLocal($NomeJanelaLocal){
		$this->NomeJanelaLocal = $NomeJanelaLocal;
	}

	public function getNomeJanelaLocal(){
		return $this->NomeJanelaLocal;
	}

	public function setAba($Aba){
		$this->Aba = $Aba;
	}

	public function getAba(){
		return $this->Aba;
	}

	public function setAbaID($AbaID){
		$this->AbaID = $AbaID;
	}

	public function getAbaID(){
		return $this->AbaID;
	}

	public function setMensagemErroPadrao($MensagemErroPadrao){
		$this->MensagemErroPadrao = $MensagemErroPadrao;
	}

	public function getMensagemErroPadrao(){
		return $this->MensagemErroPadrao;
	}

	public function setTesteCampoAtivo($TesteCampoAtivo){
		$this->TesteCampoAtivo = $TesteCampoAtivo;
	}

	public function getTesteCampoAtivo(){
		return $this->TesteCampoAtivo;
	}

	public function toHash(){
		 return $this->AtivoMensagemErroFinalizacaoID;
	}

	public function toString(){
		return $this->AtivoMensagemErroFinalizacaoID . " - " . $this->TabelaID . " - " . $this->CampoID . " - " . $this->CampoNome . " - " . $this->CampoTipoTeste . " - " . $this->ControllerAcao . " - " . $this->NomeJanelaLocal . " - " . $this->Aba . " - " . $this->AbaID . " - " . $this->MensagemErroPadrao . " - " . $this->TesteCampoAtivo;
	}

}
?>