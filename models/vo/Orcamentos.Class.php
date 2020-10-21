<?php 
class Orcamentos { 

	const TABLE_NAME = "tblOrcamentos";
	const COLUMN_KEY = "OrcamentoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $OrcamentoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "2", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $OrcamentoAno;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $OrcamentoTipoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "300", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $OrcamentoResolucao;

	/**
	* @var "TYPE" => "date", "LENGTH" => "3", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $OrcamentoDataIni;

	/**
	* @var "TYPE" => "date", "LENGTH" => "3", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $OrcamentoDataFim;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $OrcamentoSaldoInicial;

	/**
	* @var "TYPE" => "double", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $OrcamentoSaldoAtual;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $OrcamentoAtivo;


	public function setOrcamentoID($OrcamentoID){
		$this->OrcamentoID = $OrcamentoID;
	}

	public function getOrcamentoID(){
		return $this->OrcamentoID;
	}

	public function setOrcamentoAno($OrcamentoAno){
		$this->OrcamentoAno = $OrcamentoAno;
	}

	public function getOrcamentoAno(){
		return $this->OrcamentoAno;
	}

	public function setOrcamentoTipoID($OrcamentoTipoID){
		$this->OrcamentoTipoID = $OrcamentoTipoID;
	}

	public function getOrcamentoTipoID(){
		return $this->OrcamentoTipoID;
	}

	public function setOrcamentoResolucao($OrcamentoResolucao){
		$this->OrcamentoResolucao = $OrcamentoResolucao;
	}

	public function getOrcamentoResolucao(){
		return $this->OrcamentoResolucao;
	}

	public function setOrcamentoDataIni($OrcamentoDataIni){
		$this->OrcamentoDataIni = $OrcamentoDataIni;
	}

	public function getOrcamentoDataIni($mascara = 'Y-m-d H:i:s'){
		if ($this->OrcamentoDataIni != null){
			return date($mascara, strtotime(str_replace('/','-', $this->OrcamentoDataIni)));
		} else {
			return $this->OrcamentoDataIni;
		}
	}

	public function setOrcamentoDataFim($OrcamentoDataFim){
		$this->OrcamentoDataFim = $OrcamentoDataFim;
	}

	public function getOrcamentoDataFim($mascara = 'Y-m-d H:i:s'){
		if ($this->OrcamentoDataFim != null){
			return date($mascara, strtotime(str_replace('/','-', $this->OrcamentoDataFim)));
		} else {
			return $this->OrcamentoDataFim;
		}
	}

	public function setOrcamentoSaldoInicial($OrcamentoSaldoInicial){
		$this->OrcamentoSaldoInicial = $OrcamentoSaldoInicial;
	}

	public function getOrcamentoSaldoInicial(){
		return $this->OrcamentoSaldoInicial;
	}

	public function setOrcamentoSaldoAtual($OrcamentoSaldoAtual){
		$this->OrcamentoSaldoAtual = $OrcamentoSaldoAtual;
	}

	public function getOrcamentoSaldoAtual(){
		return $this->OrcamentoSaldoAtual;
	}

	public function setOrcamentoAtivo($OrcamentoAtivo){
		$this->OrcamentoAtivo = $OrcamentoAtivo;
	}

	public function getOrcamentoAtivo(){
		return $this->OrcamentoAtivo;
	}

	public function toHash(){
		 return $this->OrcamentoID;
	}

	public function toString(){
		return $this->OrcamentoID . " - " . $this->OrcamentoAno . " - " . $this->OrcamentoTipoID . " - " . $this->OrcamentoResolucao . " - " . $this->OrcamentoDataIni . " - " . $this->OrcamentoDataFim . " - " . $this->OrcamentoSaldoInicial . " - " . $this->OrcamentoSaldoAtual . " - " . $this->OrcamentoAtivo;
	}

}
?>