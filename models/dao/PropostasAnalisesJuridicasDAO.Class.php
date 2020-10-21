<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/PropostasAnalisesJuridicas.Class.php';

	class PropostasAnalisesJuridicasDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "PropostasAnalisesJuridicas");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblPropostasAnalisesJuridicas";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findVOByPropostaDetalheID($detalheID){
			$sql = "SELECT * FROM tblPropostasAnalisesJuridicas WHERE PropostaDetalheID = :propostadetalheid";
			return parent::getVO($sql, array(":propostadetalheid" => $detalheID));
		} 

		public function findByPropostaDetalheID($detalheID){
			$sql = "SELECT P.*, A.ArquivoNome as PropJuridicaArquivoNome, C.ConclusaoDescricao
					FROM tblPropostasAnalisesJuridicas as P
					LEFT JOIN tblConclusoes as C ON C.ConclusaoID = P.PropJuridicaConclusaoID
					LEFT JOIN tblArquivos as A ON P.PropJuridicaArquivoID = A.ArquivoID 
					WHERE P.PropostaDetalheID = $detalheID";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>