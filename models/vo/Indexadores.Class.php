<?php 
class Indexadores { 

	const TABLE_NAME = "tblIndexadores";
	const COLUMN_KEY = "IndexadorID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $IndexadorID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $IndexadorNome;

	/**
	* @var "TYPE" => "string", "LENGTH" => "20", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $IndexadorAbreviatura;


	public function setIndexadorID($IndexadorID){
		$this->IndexadorID = $IndexadorID;
	}

	public function getIndexadorID(){
		return $this->IndexadorID;
	}

	public function setIndexadorNome($IndexadorNome){
		$this->IndexadorNome = $IndexadorNome;
	}

	public function getIndexadorNome(){
		return $this->IndexadorNome;
	}

	public function setIndexadorAbreviatura($IndexadorAbreviatura){
		$this->IndexadorAbreviatura = $IndexadorAbreviatura;
	}

	public function getIndexadorAbreviatura(){
		return $this->IndexadorAbreviatura;
	}

	public function toHash(){
		 return $this->IndexadorID;
	}

	public function toString(){
		return $this->IndexadorID . " - " . $this->IndexadorNome . " - " . $this->IndexadorAbreviatura;
	}

}
?>