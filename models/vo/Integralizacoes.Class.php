<?php 
class Integralizacoes { 

	const TABLE_NAME = "tblIntegralizacoes";
	const COLUMN_KEY = "IntegralizacaoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $IntegralizacaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $SubscricoesID;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $IntegralizacaoData;

	/**
	* @var "TYPE" => "double", "LENGTH" => "17", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $IntegralizacaoQuantidade;

	/**
	* @var "TYPE" => "double", "LENGTH" => "17", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $IntegralizacaoValorUnitario;

	/**
	* @var "TYPE" => "double", "LENGTH" => "17", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $IntegralizacaoVolume;


	public function setIntegralizacaoID($IntegralizacaoID){
		$this->IntegralizacaoID = $IntegralizacaoID;
	}

	public function getIntegralizacaoID(){
		return $this->IntegralizacaoID;
	}

	public function setSubscricoesID($SubscricoesID){
		$this->SubscricoesID = $SubscricoesID;
	}

	public function getSubscricoesID(){
		return $this->SubscricoesID;
	}

	public function setIntegralizacaoData($IntegralizacaoData){
		$this->IntegralizacaoData = $IntegralizacaoData;
	}

	public function getIntegralizacaoData($mascara = 'Y-m-d H:i:s'){
		if ($this->IntegralizacaoData != null){
			return date($mascara, strtotime(str_replace('/','-', $this->IntegralizacaoData)));
		} else {
			return $this->IntegralizacaoData;
		}
	}

	public function setIntegralizacaoQuantidade($IntegralizacaoQuantidade){
		$this->IntegralizacaoQuantidade = $IntegralizacaoQuantidade;
	}

	public function getIntegralizacaoQuantidade(){
		return $this->IntegralizacaoQuantidade;
	}

	public function setIntegralizacaoValorUnitario($IntegralizacaoValorUnitario){
		$this->IntegralizacaoValorUnitario = $IntegralizacaoValorUnitario;
	}

	public function getIntegralizacaoValorUnitario(){
		return $this->IntegralizacaoValorUnitario;
	}

	public function setIntegralizacaoVolume($IntegralizacaoVolume){
		$this->IntegralizacaoVolume = $IntegralizacaoVolume;
	}

	public function getIntegralizacaoVolume(){
		return $this->IntegralizacaoVolume;
	}

	public function toHash(){
		 return $this->IntegralizacaoID;
	}

	public function toString(){
		return $this->IntegralizacaoID . " - " . $this->SubscricoesID . " - " . $this->IntegralizacaoData . " - " . $this->IntegralizacaoQuantidade . " - " . $this->IntegralizacaoValorUnitario . " - " . $this->IntegralizacaoVolume;
	}

}
?>