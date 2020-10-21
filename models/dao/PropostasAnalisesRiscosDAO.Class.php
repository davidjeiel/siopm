<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/PropostasAnalisesRiscos.Class.php';

	class PropostasAnalisesRiscosDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "PropostasAnalisesRiscos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblPropostasAnalisesRiscos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findVOByPropostaDetalheID($detalheID){
			$sql = "SELECT * FROM tblPropostasAnalisesRiscos WHERE PropostaDetalheID = :propostadetalheid";
			return parent::getVO($sql, array(":propostadetalheid" => $detalheID));
		} 

		public function findByPropostaDetalheID($detalheID){
			$sql = "SELECT P.*, A.ArquivoNome as PropRiscoArquivoNome, C.ConclusaoDescricao
					FROM tblPropostasAnalisesRiscos as P
					LEFT JOIN tblConclusoes as C ON C.ConclusaoID = P.PropRiscoConclusaoID
					LEFT JOIN tblArquivos as A ON P.PropRiscoArquivoID = A.ArquivoID 
					WHERE P.PropostaDetalheID = $detalheID";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>