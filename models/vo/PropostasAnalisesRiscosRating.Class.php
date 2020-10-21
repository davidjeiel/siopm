<?php 
class PropostasAnalisesRiscosRating { 

	const TABLE_NAME = "tblPropostasAnalisesRiscosRating";
	const COLUMN_KEY = "PropRiscoRatingID";
	/**
	* @var "TYPE" => "string", "LENGTH" => "4", "IS_PRIMARY" => false, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropRiscoRatingID;

	/**
	* @var "TYPE" => "double", "LENGTH" => "9", "IS_PRIMARY" => true, "IS_NULLABLE" => false, "IS_AUTO" => false
	*/
	private $PropRiscoRatingTaxaRisco;


	public function setPropRiscoRatingID($PropRiscoRatingID){
		$this->PropRiscoRatingID = $PropRiscoRatingID;
	}

	public function getPropRiscoRatingID(){
		return $this->PropRiscoRatingID;
	}

	public function setPropRiscoRatingTaxaRisco($PropRiscoRatingTaxaRisco){
		$this->PropRiscoRatingTaxaRisco = $PropRiscoRatingTaxaRisco;
	}

	public function getPropRiscoRatingTaxaRisco(){
		return $this->PropRiscoRatingTaxaRisco;
	}

	public function toHash(){
		 return $this->PropRiscoRatingID;
	}

	public function toString(){
		return $this->PropRiscoRatingID . " - " . $this->PropRiscoRatingTaxaRisco;
	}

}
?>