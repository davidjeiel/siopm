<?php 
class FechamentoCompetencia { 

	const TABLE_NAME = "tblFechamentoCompetencia";
	const COLUMN_KEY = "ID";
	const FIND_ALL = "SELECT * FROM tblFechamentoCompetencia";
	const FIND_BY_ID = "SELECT * FROM tblFechamentoCompetencia WHERE ID = :id";
	const FIND_BY_Competencia = "SELECT * FROM tblFechamentoCompetencia WHERE COMPETENCIA = :competencia";
	const FIND_BY_Matricula = "SELECT * FROM tblFechamentoCompetencia WHERE MATRICULA = :matricula";
	const FIND_BY_DataFechamento = "SELECT * FROM tblFechamentoCompetencia WHERE DATAFECHAMENTO = :datafechamento";
	const FIND_BY_ModalidadeID = "SELECT * FROM tblFechamentoCompetencia WHERE MODALIDADEID = :modalidadeid";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $ID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "14", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Competencia;

	/**
	* @var "TYPE" => "string", "LENGTH" => "14", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $Matricula;

	/**
	* @var "TYPE" => "date", "LENGTH" => "3", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $DataFechamento;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ModalidadeID;


	public function setID($ID){
		$this->ID = $ID;
	}

	public function getID(){
		return $this->ID;
	}

	public function setCompetencia($Competencia){
		$this->Competencia = $Competencia;
	}

	public function getCompetencia(){
		return $this->Competencia;
	}

	public function setMatricula($Matricula){
		$this->Matricula = $Matricula;
	}

	public function getMatricula(){
		return $this->Matricula;
	}

	public function setDataFechamento($DataFechamento){
		$this->DataFechamento = $DataFechamento;
	}

	public function getDataFechamento($mascara = 'Y-m-d H:i:s'){
		if ($this->DataFechamento != null){
			return date($mascara, strtotime(str_replace('/','-', $this->DataFechamento)));
		} else {
			return $this->DataFechamento;
		}
	}

	public function setModalidadeID($ModalidadeID){
		$this->ModalidadeID = $ModalidadeID;
	}

	public function getModalidadeID(){
		return $this->ModalidadeID;
	}

	public function toJSON(){

		$reflector = new ReflectionClass(FechamentoCompetencia);

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
		 return $this->ID;
	}

	public function toString(){
		return $this->ID . " - " . $this->Competencia . " - " . $this->Matricula . " - " . $this->DataFechamento . " - " . $this->ModalidadeID;
	}

}
?>