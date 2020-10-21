<?php 
class Log { 

	const TABLE_NAME = "tblLog";
	const COLUMN_KEY = "ID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $ID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Grupo;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Tipo;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Modulo;

	/**
	* @var "TYPE" => "string", "LENGTH" => "7", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Matricula;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $DataHora;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $FKValue;

	/**
	* @var "TYPE" => "string", "LENGTH" => "2000", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Conteudo;


	public function setID($ID){
		$this->ID = $ID;
	}

	public function getID(){
		return $this->ID;
	}

	public function setGrupo($Grupo){
		$this->Grupo = $Grupo;
	}

	public function getGrupo(){
		return $this->Grupo;
	}

	public function setTipo($Tipo){
		$this->Tipo = $Tipo;
	}

	public function getTipo(){
		return $this->Tipo;
	}

	public function setModulo($Modulo){
		$this->Modulo = $Modulo;
	}

	public function getModulo(){
		return $this->Modulo;
	}

	public function setMatricula($Matricula){
		$this->Matricula = $Matricula;
	}

	public function getMatricula(){
		return $this->Matricula;
	}

	public function setDataHora($DataHora){
		$this->DataHora = $DataHora;
	}

	public function getDataHora($mascara = 'Y-m-d H:i:s'){
		if ($this->DataHora != null){
			return date($mascara, strtotime(str_replace('/','-', $this->DataHora)));
		} else {
			return $this->DataHora;
		}
	}

	public function setFKValue($FKValue){
		$this->FKValue = $FKValue;
	}

	public function getFKValue(){
		return $this->FKValue;
	}

	public function setConteudo($Conteudo){
		$this->Conteudo = $Conteudo;
	}

	public function getConteudo(){
		return $this->Conteudo;
	}

	public function toHash(){
		 return $this->ID;
	}

	public function toString(){
		return $this->ID . " - " . $this->Tipo . " - " . $this->Modulo . " - " . $this->Matricula . " - " . $this->DataHora . " - " . $this->FKValue . " - " . $this->Conteudo;
	}

}
?>