<?php 
class HabilitacoesContatos { 

	const TABLE_NAME = "tblHabilitacoesContatos";
	const COLUMN_KEY = "HabContatoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $HabContatoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $HabilitacaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ContatoID;


	public function setHabContatoID($HabContatoID){
		$this->HabContatoID = $HabContatoID;
	}

	public function getHabContatoID(){
		return $this->HabContatoID;
	}

	public function setHabilitacaoID($HabilitacaoID){
		$this->HabilitacaoID = $HabilitacaoID;
	}

	public function getHabilitacaoID(){
		return $this->HabilitacaoID;
	}

	public function setContatoID($ContatoID){
		$this->ContatoID = $ContatoID;
	}

	public function getContatoID(){
		return $this->ContatoID;
	}

	public function toHash(){
		 return $this->HabContatoID;
	}

	public function toString(){
		return $this->HabContatoID . " - " . $this->HabilitacaoID . " - " . $this->ContatoID;
	}

}
?>