<?php 
class Subscricoes { 

	const TABLE_NAME = "tblSubscricoes";
	const COLUMN_KEY = "SubscricoesID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $SubscricoesID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $AtivoID;

	/**
	* @var "TYPE" => "date", "LENGTH" => "3", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $SubscricoesData;

	/**
	* @var "TYPE" => "double", "LENGTH" => "17", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $SubscricoesVolume;

	/**
	* @var "TYPE" => "double", "LENGTH" => "17", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $SubscricoesQuantidade;

	/**
	* @var "TYPE" => "double", "LENGTH" => "17", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $SubscricoesValorUnitario;


	public function setSubscricoesID($SubscricoesID){
		$this->SubscricoesID = $SubscricoesID;
	}

	public function getSubscricoesID(){
		return $this->SubscricoesID;
	}

	public function setAtivoID($AtivoID){
		$this->AtivoID = $AtivoID;
	}

	public function getAtivoID(){
		return $this->AtivoID;
	}

	public function setSubscricoesData($SubscricoesData){
		$this->SubscricoesData = $SubscricoesData;
	}

	public function getSubscricoesData($mascara = 'Y-m-d H:i:s'){
		if ($this->SubscricoesData != null){
			return date($mascara, strtotime(str_replace('/','-', $this->SubscricoesData)));
		} else {
			return $this->SubscricoesData;
		}
	}

	public function setSubscricoesVolume($SubscricoesVolume){
		$this->SubscricoesVolume = $SubscricoesVolume;
	}

	public function getSubscricoesVolume(){
		return $this->SubscricoesVolume;
	}

	public function setSubscricoesQuantidade($SubscricoesQuantidade){
		$this->SubscricoesQuantidade = $SubscricoesQuantidade;
	}

	public function getSubscricoesQuantidade(){
		return $this->SubscricoesQuantidade;
	}

	public function setSubscricoesValorUnitario($SubscricoesValorUnitario){
		$this->SubscricoesValorUnitario = $SubscricoesValorUnitario;
	}

	public function getSubscricoesValorUnitario(){
		return $this->SubscricoesValorUnitario;
	}

	public function toHash(){
		 return $this->SubscricoesID;
	}

	public function toString(){
		return $this->SubscricoesID . " - " . $this->AtivoID . " - " . $this->SubscricoesData . " - " . $this->SubscricoesVolume . " - " . $this->SubscricoesQuantidade . " - " . $this->SubscricoesValorUnitario;
	}

}
?>