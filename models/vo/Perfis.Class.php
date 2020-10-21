<?php 
class Perfis { 

	const TABLE_NAME = "tblPerfis";
	const COLUMN_KEY = "PerfilID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PerfilID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "120", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PerfilNome;

	/**
	* @var "TYPE" => "string", "LENGTH" => "510", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $PerfilDescricao;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PerfilAtivo;


	public function setPerfilID($PerfilID){
		$this->PerfilID = $PerfilID;
	}

	public function getPerfilID(){
		return $this->PerfilID;
	}

	public function setPerfilNome($PerfilNome){
		$this->PerfilNome = $PerfilNome;
	}

	public function getPerfilNome(){
		return $this->PerfilNome;
	}

	public function setPerfilDescricao($PerfilDescricao){
		$this->PerfilDescricao = $PerfilDescricao;
	}

	public function getPerfilDescricao(){
		return $this->PerfilDescricao;
	}

	public function setPerfilAtivo($PerfilAtivo){
		$this->PerfilAtivo = $PerfilAtivo;
	}

	public function getPerfilAtivo(){
		return $this->PerfilAtivo;
	}

	public function toHash(){
		 return $this->PerfilID;
	}

	public function toString(){
		return $this->PerfilID . " - " . $this->PerfilNome . " - " . $this->PerfilDescricao . " - " . $this->PerfilAtivo;
	}

}
?>