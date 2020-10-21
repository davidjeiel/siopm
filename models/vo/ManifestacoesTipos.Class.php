<?php 
class ManifestacoesTipos { 

	const TABLE_NAME = "tblManifestacoesTipos";
	const COLUMN_KEY = "ManifestacaoTipoID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ManifestacaoTipoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "510", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $ManifestacaoTipoDescricao;


	public function setManifestacaoTipoID($ManifestacaoTipoID){
		$this->ManifestacaoTipoID = $ManifestacaoTipoID;
	}

	public function getManifestacaoTipoID(){
		return $this->ManifestacaoTipoID;
	}

	public function setManifestacaoTipoDescricao($ManifestacaoTipoDescricao){
		$this->ManifestacaoTipoDescricao = $ManifestacaoTipoDescricao;
	}

	public function getManifestacaoTipoDescricao(){
		return $this->ManifestacaoTipoDescricao;
	}

	public function toHash(){
		 return $this->ManifestacaoTipoID;
	}

	public function toString(){
		return $this->ManifestacaoTipoID . " - " . $this->ManifestacaoTipoDescricao;
	}

}
?>