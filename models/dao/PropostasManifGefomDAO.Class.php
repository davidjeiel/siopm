<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/PropostasManifGefom.Class.php';

	class PropostasManifGefomDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "PropostasManifGefom");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblPropostasManifGefom";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findVOByPropostaDetalheID($detalheID){
			$sql = "SELECT * FROM tblPropostasManifGefom WHERE PropostaDetalheID = :propostadetalheid";
			return parent::getVO($sql, array(":propostadetalheid" => $detalheID));
		} 

		public function findByPropostaDetalheID($detalheID){
			$sql = "SELECT P.*, A.ArquivoNome as GefomArquivoNome, C.ConclusaoDescricao 
					FROM tblPropostasManifGefom as P 
					LEFT JOIN tblConclusoes as C ON C.ConclusaoID = P.GefomConclusaoID
					LEFT JOIN tblArquivos as A ON P.GefomArquivoID = A.ArquivoID 
					WHERE P.PropostaDetalheID = :propostadetalheid";
			$arr = parent::getSingleResultArray($sql, array(":propostadetalheid" => $detalheID));
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>