<?php 
class Usuarios { 

	const TABLE_NAME = "tblUsuarios";
	const COLUMN_KEY = "UsuarioMatricula";

	/**
	* @var "TYPE" => "string", "LENGTH" => "14", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $UsuarioMatricula;

	/**
	* @var "TYPE" => "string", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $UnidadeID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PerfilID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "200", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $UsuarioNome;

	/**
	* @var "TYPE" => "string", "LENGTH" => "14", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $UsuarioMatriculaResponsavel;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $UsuarioDataCadastro;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $UsuarioAtivo;


	public function setUsuarioMatricula($UsuarioMatricula){
		$this->UsuarioMatricula = $UsuarioMatricula;
	}

	public function getUsuarioMatricula(){
		return $this->UsuarioMatricula;
	}

	public function setUnidadeID($UnidadeID){
		$this->UnidadeID = $UnidadeID;
	}

	public function getUnidadeID(){
		return $this->UnidadeID;
	}

	public function setPerfilID($PerfilID){
		$this->PerfilID = $PerfilID;
	}

	public function getPerfilID(){
		return $this->PerfilID;
	}

	public function setUsuarioNome($UsuarioNome){
		$this->UsuarioNome = $UsuarioNome;
	}

	public function getUsuarioNome(){
		return $this->UsuarioNome;
	}

	public function setUsuarioMatriculaResponsavel($UsuarioMatriculaResponsavel){
		$this->UsuarioMatriculaResponsavel = $UsuarioMatriculaResponsavel;
	}

	public function getUsuarioMatriculaResponsavel(){
		return $this->UsuarioMatriculaResponsavel;
	}

	public function setUsuarioDataCadastro($UsuarioDataCadastro){
		$this->UsuarioDataCadastro = $UsuarioDataCadastro;
	}

	public function getUsuarioDataCadastro($mascara = 'Y-m-d H:i:s'){
		if ($this->UsuarioDataCadastro != null){
			return date($mascara, strtotime(str_replace('/','-', $this->UsuarioDataCadastro)));
		} else {
			return $this->UsuarioDataCadastro;
		}
	}

	public function setUsuarioAtivo($UsuarioAtivo){
		$this->UsuarioAtivo = $UsuarioAtivo;
	}

	public function getUsuarioAtivo(){
		return $this->UsuarioAtivo;
	}

	public function toHash(){
		 return $this->UsuarioMatricula;
	}

	public function toString(){
		return $this->UsuarioMatricula . " - " . $this->UnidadeID . " - " . $this->PerfilID . " - " . $this->UsuarioNome . " - " . $this->UsuarioMatriculaResponsavel . " - " . $this->UsuarioDataCadastro . " - " . $this->UsuarioAtivo;
	}

}
?>