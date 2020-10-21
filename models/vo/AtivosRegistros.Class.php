<?php 
class AtivosRegistros { 

	const TABLE_NAME = "tblAtivosRegistros";
	const COLUMN_KEY = "AtivoRegistroID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $AtivoRegistroID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $AtivoID;

	/**
	* @var "TYPE" => "date", "LENGTH" => "8", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoRegistroDataCVM;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoLiquidacaoTipoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoRegistroEsforcoRestrito;

	/**
	* @var "TYPE" => "string", "LENGTH" => "255", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $AtivoRegistroCVM;


	public function setAtivoRegistroID($AtivoRegistroID){
		$this->AtivoRegistroID = $AtivoRegistroID;
	}

	public function getAtivoRegistroID(){
		return $this->AtivoRegistroID;
	}

	public function setAtivoID($AtivoID){
		$this->AtivoID = $AtivoID;
	}

	public function getAtivoID(){
		return $this->AtivoID;
	}

	public function setAtivoRegistroDataCVM($AtivoRegistroDataCVM){
		$this->AtivoRegistroDataCVM = $AtivoRegistroDataCVM;
	}

	public function getAtivoRegistroDataCVM($mascara = 'Y-m-d H:i:s'){
		if ($this->AtivoRegistroDataCVM != null){
			return date($mascara, strtotime(str_replace('/','-', $this->AtivoRegistroDataCVM)));
		} else {
			return $this->AtivoRegistroDataCVM;
		}
	}

	public function setAtivoLiquidacaoTipoID($AtivoLiquidacaoTipoID){
		$this->AtivoLiquidacaoTipoID = $AtivoLiquidacaoTipoID;
	}

	public function getAtivoLiquidacaoTipoID(){
		return $this->AtivoLiquidacaoTipoID;
	}

	public function setAtivoRegistroEsforcoRestrito($AtivoRegistroEsforcoRestrito){
		$this->AtivoRegistroEsforcoRestrito = $AtivoRegistroEsforcoRestrito;
	}

	public function getAtivoRegistroEsforcoRestrito(){
		return $this->AtivoRegistroEsforcoRestrito;
	}

	public function setAtivoRegistroCVM($AtivoRegistroCVM){
		$this->AtivoRegistroCVM = $AtivoRegistroCVM;
	}

	public function getAtivoRegistroCVM(){
		return $this->AtivoRegistroCVM;
	}

	public function toHash(){
		 return $this->AtivoRegistroID;
	}

	public function toString(){
		return $this->AtivoRegistroID . " - " . $this->AtivoID . " - " . $this->AtivoRegistroDataCVM . " - " . $this->AtivoLiquidacaoTipoID . " - " . $this->AtivoRegistroEsforcoRestrito . " - " . $this->AtivoRegistroCVM;
	}

}
?>