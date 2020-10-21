<?php 
class CapturaPlanilhaAtivos { 

	const TABLE_NAME = "tblCapturaPlanilhaAtivos";
	const COLUMN_KEY = "Id";
	const FIND_ALL = "SELECT * FROM tblCapturaPlanilhaAtivos";
	const FIND_BY_Id = "SELECT * FROM tblCapturaPlanilhaAtivos WHERE ID = :id";
	const FIND_BY_CapturaControleID = "SELECT * FROM tblCapturaPlanilhaAtivos WHERE CAPTURACONTROLEID = :capturacontroleid";
	const FIND_BY_DataEvento = "SELECT * FROM tblCapturaPlanilhaAtivos WHERE DATAEVENTO = :dataevento";
	const FIND_BY_CodigoAtivo = "SELECT * FROM tblCapturaPlanilhaAtivos WHERE CODIGOATIVO = :codigoativo";
	const FIND_BY_AtivoID = "SELECT * FROM tblCapturaPlanilhaAtivos WHERE ATIVOID = :ativoid";
	const FIND_BY_TransacaoID = "SELECT * FROM tblCapturaPlanilhaAtivos WHERE TRANSACAOID = :transacaoid";
	const FIND_BY_DemonstrativoID = "SELECT * FROM tblCapturaPlanilhaAtivos WHERE DEMONSTRATIVOID = :demonstrativoid";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $Id;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $CapturaControleID;

	/**
	* @var "TYPE" => "date", "LENGTH" => "3", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $DataEvento;

	/**
	* @var "TYPE" => "string", "LENGTH" => "10", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $CodigoAtivo;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $AtivoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $TransacaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $DemonstrativoID;


	public function setId($Id){
		$this->Id = $Id;
	}

	public function getId(){
		return $this->Id;
	}

	public function setCapturaControleID($CapturaControleID){
		$this->CapturaControleID = $CapturaControleID;
	}

	public function getCapturaControleID(){
		return $this->CapturaControleID;
	}

	public function setDataEvento($DataEvento){
		$this->DataEvento = $DataEvento;
	}

	public function getDataEvento($mascara = 'Y-m-d H:i:s'){
		if ($this->DataEvento != null){
			return date($mascara, strtotime(str_replace('/','-', $this->DataEvento)));
		} else {
			return $this->DataEvento;
		}
	}

	public function setCodigoAtivo($CodigoAtivo){
		$this->CodigoAtivo = $CodigoAtivo;
	}

	public function getCodigoAtivo(){
		return $this->CodigoAtivo;
	}

	public function setAtivoID($AtivoID){
		$this->AtivoID = $AtivoID;
	}

	public function getAtivoID(){
		return $this->AtivoID;
	}

	public function setTransacaoID($TransacaoID){
		$this->TransacaoID = $TransacaoID;
	}

	public function getTransacaoID(){
		return $this->TransacaoID;
	}

	public function setDemonstrativoID($DemonstrativoID){
		$this->DemonstrativoID = $DemonstrativoID;
	}

	public function getDemonstrativoID(){
		return $this->DemonstrativoID;
	}

	public function toJSON(){

		$reflector = new ReflectionClass(CapturaPlanilhaAtivos);

		$jVar = '';

		foreach ($reflector->getProperties() as $indice => $campo) { 

			if ($reflector->hasMethod('get' . ucfirst($campo->name))) { 

				$jVar .= ($jVar == '') ? '' : ', '; 
				eval('$valor = $this->get' . ucfirst($campo->name) . '();'); 
				if (gettype($valor) == 'array') $valor = json_encode($valor); 
				elseif (gettype($valor) == 'boolean') $valor = (($valor) ? "true" : "false");  
				elseif (gettype($valor) == 'integer') $valor = $valor;  
				else $valor = "'" . $valor . "'";  
				$jVar .= '\'' . $campo->name . '\': ' . $valor;  

			}

		}

		echo $jVar;
	}

	public function toHash(){
		 return $this->Id;
	}

	public function toString(){
		return $this->Id . " - " . $this->CapturaControleID . " - " . $this->DataEvento . " - " . $this->CodigoAtivo . " - " . $this->AtivoID . " - " . $this->TransacaoID . " - " . $this->DemonstrativoID;
	}

}
?>