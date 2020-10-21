<?php 
class Modalidades { 

	const TABLE_NAME = "tblModalidades";
	const COLUMN_KEY = "ModalidadeID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ModalidadeID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "200", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ModalidadeNome;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $ModalidadeSetor;


	public function setModalidadeID($ModalidadeID){
		$this->ModalidadeID = $ModalidadeID;
	}

	public function getModalidadeID(){
		return $this->ModalidadeID;
	}

	public function setModalidadeNome($ModalidadeNome){
		$this->ModalidadeNome = $ModalidadeNome;
	}

	public function getModalidadeNome(){
		return $this->ModalidadeNome;
	}

	public function setModalidadeSetor($ModalidadeSetor){
		$this->ModalidadeSetor = $ModalidadeSetor;
	}

	public function getModalidadeSetor(){
		return $this->ModalidadeSetor;
	}

	public function toHash(){
		 return $this->ModalidadeID;
	}

	public function toString(){
		return $this->ModalidadeID . " - " . $this->ModalidadeNome . " - " . $this->ModalidadeSetor;
	}

}
?>