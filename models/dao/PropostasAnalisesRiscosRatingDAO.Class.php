<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/PropostasAnalisesRiscosRating.Class.php';

	class PropostasAnalisesRiscosRatingDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "PropostasAnalisesRiscosRating");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblPropostasAnalisesRiscosRating
			order by PropRiscoRatingTaxaRisco";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>