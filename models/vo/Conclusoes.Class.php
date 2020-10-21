<?php 
class Conclusoes { 

	const TABLE_NAME = "tblConclusoes";
	const COLUMN_KEY = "ConclusaoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $ConclusaoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ConclusaoDescricao;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ConclusaoAliasHabilitacao;


	public function setConclusaoID($ConclusaoID){
		$this->ConclusaoID = $ConclusaoID;
	}

	public function getConclusaoID(){
		return $this->ConclusaoID;
	}

	public function setConclusaoDescricao($ConclusaoDescricao){
		$this->ConclusaoDescricao = $ConclusaoDescricao;
	}

	public function getConclusaoDescricao(){
		return $this->ConclusaoDescricao;
	}

	public function setConclusaoAliasHabilitacao($ConclusaoAliasHabilitacao){
		$this->ConclusaoAliasHabilitacao = $ConclusaoAliasHabilitacao;
	}

	public function getConclusaoAliasHabilitacao(){
		return $this->ConclusaoAliasHabilitacao;
	}
	public function toHash(){
		 return $this->ConclusaoID;
	}

	public function toString(){
		return $this->ConclusaoID . " - " . $this->ConclusaoDescricao . " - " . $this->ConclusaoAliasHabilitacao;
	}

}

?>