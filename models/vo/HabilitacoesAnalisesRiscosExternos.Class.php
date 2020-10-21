<?php 
class HabilitacoesAnalisesRiscosExternos { 

	const TABLE_NAME = "tblHabilitacoesAnalisesRiscosExternos";
	const COLUMN_KEY = "HabRiscoExtID";

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => true
	*/
	private $HabRiscoExtID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $HabilitacaoID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabRiscoExtEntidadeID;

	/**
	* @var "TYPE" => "integer", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabRiscoExtArquivoID;

	/**
	* @var "TYPE" => "string", "LENGTH" => "100", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabRiscoExtRating;

	/**
	* @var "TYPE" => "string", "LENGTH" => "2000", "IS_PRIMARY" => false, "IS_NULLABLE" => true, "IS_AUTO" => false
	*/
	private $HabRiscoExtConsideracoes;


	public function setHabRiscoExtID($HabRiscoExtID){
		$this->HabRiscoExtID = $HabRiscoExtID;
	}

	public function getHabRiscoExtID(){
		return $this->HabRiscoExtID;
	}

	public function setHabilitacaoID($HabilitacaoID){
		$this->HabilitacaoID = $HabilitacaoID;
	}

	public function getHabilitacaoID(){
		return $this->HabilitacaoID;
	}

	public function setHabRiscoExtEntidadeID($HabRiscoExtEntidadeID){
		$this->HabRiscoExtEntidadeID = $HabRiscoExtEntidadeID;
	}

	public function getHabRiscoExtEntidadeID(){
		return $this->HabRiscoExtEntidadeID;
	}

	public function setHabRiscoExtArquivoID($HabRiscoExtArquivoID){
		$this->HabRiscoExtArquivoID = $HabRiscoExtArquivoID;
	}

	public function getHabRiscoExtArquivoID(){
		return $this->HabRiscoExtArquivoID;
	}

	public function setHabRiscoExtRating($HabRiscoExtRating){
		$this->HabRiscoExtRating = $HabRiscoExtRating;
	}

	public function getHabRiscoExtRating(){
		return $this->HabRiscoExtRating;
	}

	public function setHabRiscoExtConsideracoes($HabRiscoExtConsideracoes){
		$this->HabRiscoExtConsideracoes = $HabRiscoExtConsideracoes;
	}

	public function getHabRiscoExtConsideracoes(){
		return $this->HabRiscoExtConsideracoes;
	}

	public function toHash(){
		 return $this->HabRiscoExtID;
	}

	public function toString(){
		return $this->HabRiscoExtID . " - " . $this->HabilitacaoID . " - " . $this->HabRiscoExtEntidadeID . " - " . $this->HabRiscoExtArquivoID . " - " . $this->HabRiscoExtRating . " - " . $this->HabRiscoExtConsideracoes;
	}

}
?>