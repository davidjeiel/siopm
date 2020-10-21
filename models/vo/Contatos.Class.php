<?php 
class Contatos { 

	const TABLE_NAME = "tblContatos";
	const COLUMN_KEY = "ContatoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $ContatoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "500", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ContatoNome;

	/**
	* @var "TYPE" => "string", "LENGTH" => "500", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ContatoEmail;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ContatoFone1;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ContatoFone2;

	/**
	* @var "TYPE" => "string", "LENGTH" => "1000", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ContatoObs;


	public function setContatoID($ContatoID){
		$this->ContatoID = $ContatoID;
	}

	public function getContatoID(){
		return $this->ContatoID;
	}

	public function setContatoNome($ContatoNome){
		$this->ContatoNome = $ContatoNome;
	}

	public function getContatoNome(){
		return $this->ContatoNome;
	}

	public function setContatoEmail($ContatoEmail){
		$this->ContatoEmail = $ContatoEmail;
	}

	public function getContatoEmail(){
		return $this->ContatoEmail;
	}

	public function setContatoFone1($ContatoFone1){
		$this->ContatoFone1 = $ContatoFone1;
	}

	public function getContatoFone1(){
		return $this->ContatoFone1;
	}

	public function setContatoFone2($ContatoFone2){
		$this->ContatoFone2 = $ContatoFone2;
	}

	public function getContatoFone2(){
		return $this->ContatoFone2;
	}

	public function setContatoObs($ContatoObs){
		$this->ContatoObs = $ContatoObs;
	}

	public function getContatoObs(){
		return $this->ContatoObs;
	}

	public function toHash(){
		 return $this->ContatoID;
	}

	public function toString(){
		return $this->ContatoID . " - " . $this->ContatoNome . " - " . $this->ContatoEmail . " - " . $this->ContatoFone1 . " - " . $this->ContatoFone2 . " - " . $this->ContatoObs;
	}

}
?>