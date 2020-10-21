<?php 
class PropostasEmpreendimentosTipos { 

	const TABLE_NAME = "tblPropostasEmpreendimentosTipos";
	const COLUMN_KEY = "PropEmpreendTipoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $PropEmpreendTipoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropEmpreendNome;


	public function setPropEmpreendTipoID($PropEmpreendTipoID){
		$this->PropEmpreendTipoID = $PropEmpreendTipoID;
	}

	public function getPropEmpreendTipoID(){
		return $this->PropEmpreendTipoID;
	}

	public function setPropEmpreendNome($PropEmpreendNome){
		$this->PropEmpreendNome = $PropEmpreendNome;
	}

	public function getPropEmpreendNome(){
		return $this->PropEmpreendNome;
	}

	public function toHash(){
		 return $this->PropEmpreendTipoID;
	}

	public function toString(){
		return $this->PropEmpreendTipoID . " - " . $this->PropEmpreendNome;
	}

}
?>