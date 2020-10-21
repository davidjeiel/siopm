<?php 
class Datas { 

	const TABLE_NAME = "tblDatas";
	const COLUMN_KEY = "DataID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $DataID;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $DataData;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "1", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $DataFDS;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "1", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $DataFeriado;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "1", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $DataDU;


	public function setDataID($DataID){
		$this->DataID = $DataID;
	}

	public function getDataID(){
		return $this->DataID;
	}

	public function setDataData($DataData){
		$this->DataData = $DataData;
	}

	public function getDataData($mascara = 'Y-m-d H:i:s'){
		if ($this->DataData != null){
			return date($mascara, strtotime(str_replace('/','-', $this->DataData)));
		} else {
			return $this->DataData;
		}
	}

	public function setDataFDS($DataFDS){
		$this->DataFDS = $DataFDS;
	}

	public function getDataFDS(){
		return $this->DataFDS;
	}

	public function setDataFeriado($DataFeriado){
		$this->DataFeriado = $DataFeriado;
	}

	public function getDataFeriado(){
		return $this->DataFeriado;
	}

	public function setDataDU($DataDU){
		$this->DataDU = $DataDU;
	}

	public function getDataDU(){
		return $this->DataDU;
	}

	public function toHash(){
		 return $this->DataID;
	}

	public function toString(){
		return $this->DataID . " - " . $this->DataData . " - " . $this->DataFDS . " - " . $this->DataFeriado . " - " . $this->DataDU;
	}

}
?>