<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/PropostasResolucoes.Class.php';

	class PropostasResolucoesDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "PropostasResolucoes");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblPropostasResolucoes";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findVOByPropostaDetalheID($detalheID){
			$sql = "SELECT * FROM tblPropostasResolucoes WHERE PropostaDetalheID = :propostadetalheid";
			return parent::getVO($sql, array(":propostadetalheid" => $detalheID));
		} 

		public function findByPropostaDetalheID($detalheID){
			$sql = "SELECT P.*, A.ArquivoNome as PropResolucaoArquivoNome, C.ConclusaoDescricao 
					FROM tblPropostasResolucoes as P 
					LEFT JOIN tblConclusoes as C ON C.ConclusaoID = P.PropResolucaoConclusaoID
					LEFT JOIN tblArquivos as A ON P.PropResolucaoArquivoID = A.ArquivoID 
					WHERE P.PropostaDetalheID = $detalheID";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>