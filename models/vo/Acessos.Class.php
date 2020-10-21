<?php 
class Acessos { 

	const TABLE_NAME = "tblAcessos";
	const COLUMN_KEY = "ID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $ID;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $DataHora;

	/**
	* @var "TYPE" => "string", "LENGTH" => "7", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Matricula;

	/**
	* @var "TYPE" => "string", "LENGTH" => "255", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Controller;

	/**
	* @var "TYPE" => "string", "LENGTH" => "255", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Endereco;

	/**
	* @var "TYPE" => "string", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Unidade;

	/**
	* @var "TYPE" => "string", "LENGTH" => "1000", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $Acao;


	public function setID($ID){
		$this->ID = $ID;
	}

	public function getID(){
		return $this->ID;
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

	public function setMatricula($Matricula){
		$this->Matricula = $Matricula;
	}

	public function getMatricula(){
		return $this->Matricula;
	}

	public function setController($Controller){
		$this->Controller = $Controller;
	}

	public function getController(){
		return $this->Controller;
	}
	
	public function setEndereco($Endereco){
		$this->Endereco = $Endereco;
	}

	public function getEndereco(){
		return $this->Endereco;
	}

	public function setUnidade($Unidade){
		$this->Unidade = $Unidade;
	}

	public function getUnidade(){
		return $this->Unidade;
	}

	public function setAcao($Acao){
		$this->Acao = $Acao;
	}

	public function getAcao(){
		return $this->Acao;
	}

	public function toHash(){
		 return $this->ID;
	}

	public function toString(){
		return $this->ID . " - " . $this->DataHora . " - " . $this->Dominio . " - " . $this->Matricula . " - " . $this->Endereco . " - " . $this->Unidade  . " - " . $this->Acao;
	}

	public function getJsonData(){
        $var = get_object_vars($this);
        foreach($var as &$value){
           if(is_object($value) && method_exists($value,'getJsonData')){
              $value = $value->getJsonData();
           }
        }
        return $var;
    }
}
?>