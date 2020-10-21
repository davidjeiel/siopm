<?php 
class Programas { 

	const TABLE_NAME = "tblProgramas";
	const COLUMN_KEY = "ProgramaID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $ProgramaID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "200", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ProgramaNome;


	public function setProgramaID($ProgramaID){
		$this->ProgramaID = $ProgramaID;
	}

	public function getProgramaID(){
		return $this->ProgramaID;
	}

	public function setProgramaNome($ProgramaNome){
		$this->ProgramaNome = $ProgramaNome;
	}

	public function getProgramaNome(){
		return $this->ProgramaNome;
	}

	public function toHash(){
		 return $this->ProgramaID;
	}

	public function toString(){
		return $this->ProgramaID . " - " . $this->ProgramaNome;
	}

}
?>