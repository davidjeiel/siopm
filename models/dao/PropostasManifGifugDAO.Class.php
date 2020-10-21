<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/PropostasManifGifug.Class.php';

	class PropostasManifGifugDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "PropostasManifGifug");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblPropostasManifGifug";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findVOByPropostaDetalheID($detalheID){
			$sql = "SELECT * FROM tblPropostasManifGifug WHERE PropostaDetalheID = :propostadetalheid";
			return parent::getVO($sql, array(":propostadetalheid" => $detalheID));
		} 

		public function findByPropostaDetalheID($detalheID){
			$sql = "SELECT P.*, A.ArquivoNome as GifugArquivoNome, C.ConclusaoDescricao 
					FROM tblPropostasManifGifug as P 
					LEFT JOIN tblConclusoes as C ON C.ConclusaoID = P.GifugConclusaoID
					LEFT JOIN tblArquivos as A ON P.GifugArquivoID = A.ArquivoID 
					WHERE P.PropostaDetalheID = :propostadetalheid";
			$arr = parent::getSingleResultArray($sql, array(":propostadetalheid" => $detalheID));
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>