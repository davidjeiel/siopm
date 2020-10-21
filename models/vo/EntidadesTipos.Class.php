<?php 
class EntidadesTipos { 

	const TABLE_NAME = "tblEntidadesTipos";
	const COLUMN_KEY = "EntidadeTipoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $EntidadeTipoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $EntidadeTipoDescricao;


	public function setEntidadeTipoID($EntidadeTipoID){
		$this->EntidadeTipoID = $EntidadeTipoID;
	}

	public function getEntidadeTipoID(){
		return $this->EntidadeTipoID;
	}

	public function setEntidadeTipoDescricao($EntidadeTipoDescricao){
		$this->EntidadeTipoDescricao = $EntidadeTipoDescricao;
	}

	public function getEntidadeTipoDescricao(){
		return $this->EntidadeTipoDescricao;
	}

	public function toHash(){
		 return $this->EntidadeTipoID;
	}

	public function toString(){
		return $this->EntidadeTipoID . " - " . $this->EntidadeTipoDescricao;
	}

}
?>