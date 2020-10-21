<?php 
class CapturaPlanilhaEventos { 

	const TABLE_NAME = "tblCapturaPlanilhaEventos";
	const COLUMN_KEY = "Id";
	const FIND_ALL = "SELECT * FROM tblCapturaPlanilhaEventos";
	const FIND_BY_Id = "SELECT * FROM tblCapturaPlanilhaEventos WHERE ID = :id";
	const FIND_BY_CapturaPlanilhaAtivosID = "SELECT * FROM tblCapturaPlanilhaEventos WHERE CAPTURAPLANILHAATIVOSID = :capturaplanilhaativosid";
	const FIND_BY_DataEvento = "SELECT * FROM tblCapturaPlanilhaEventos WHERE DATAEVENTO = :dataevento";
	const FIND_BY_Evento = "SELECT * FROM tblCapturaPlanilhaEventos WHERE EVENTO = :evento";
	const FIND_BY_Valor = "SELECT * FROM tblCapturaPlanilhaEventos WHERE VALOR = :valor";
	const FIND_BY_CapturaTesourariaID = "SELECT * FROM tblCapturaPlanilhaEventos WHERE CAPTURATESOURARIAID = :capturatesourariaid";
	const FIND_BY_TipoEventoID = "SELECT * FROM tblCapturaPlanilhaEventos WHERE TIPOEVENTOID = :tipoeventoid";
	const FIND_BY_EventoID = "SELECT * FROM tblCapturaPlanilhaEventos WHERE EVENTOID = :eventoid";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $Id;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $CapturaPlanilhaAtivosID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Evento;

	/**
	* @var "TYPE" => "double", "LENGTH" => "9", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Valor;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $CapturaTesourariaID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $TipoEventoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $EventoID;


	public function setId($Id){
		$this->Id = $Id;
	}

	public function getId(){
		return $this->Id;
	}

	public function setCapturaPlanilhaAtivosID($CapturaPlanilhaAtivosID){
		$this->CapturaPlanilhaAtivosID = $CapturaPlanilhaAtivosID;
	}

	public function getCapturaPlanilhaAtivosID(){
		return $this->CapturaPlanilhaAtivosID;
	}

	public function setEvento($Evento){
		$this->Evento = $Evento;
	}

	public function getEvento(){
		return $this->Evento;
	}

	public function setValor($Valor){
		$this->Valor = $Valor;
	}

	public function getValor(){
		return $this->Valor;
	}

	public function setCapturaTesourariaID($CapturaTesourariaID){
		$this->CapturaTesourariaID = $CapturaTesourariaID;
	}

	public function getCapturaTesourariaID(){
		return $this->CapturaTesourariaID;
	}

	public function setTipoEventoID($TipoEventoID){
		$this->TipoEventoID = $TipoEventoID;
	}

	public function getTipoEventoID(){
		return $this->TipoEventoID;
	}

	public function setEventoID($EventoID){
		$this->EventoID = $EventoID;
	}

	public function getEventoID(){
		return $this->EventoID;
	}

	public function toJSON(){

		$reflector = new ReflectionClass(CapturaPlanilhaEventos);

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
		return $this->Id . " - " . $this->CapturaPlanilhaAtivosID . " - " . $this->DataEvento . " - " . $this->Evento . " - " . $this->Valor . " - " . $this->CapturaTesourariaID . " - " . $this->TipoEventoID . " - " . $this->EventoID;
	}

}
?>