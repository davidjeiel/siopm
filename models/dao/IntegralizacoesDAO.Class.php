<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/Integralizacoes.Class.php';

	class IntegralizacoesDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "Integralizacoes");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblIntegralizacoes";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findByID($id){
			$sql = "SELECT * FROM tblIntegralizacoes i 
			 		WHERE i.IntegralizacaoID = $id";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listAllBySubscricaoID($subscricoesid){
			$sql = 
				"SELECT s.*, i.* FROM tblSubscricoes s INNER JOIN tblIntegralizacoes i  ON i.SubscricoesID = s.SubscricoesID
										  			   INNER JOIN tblAtivos a 			ON a.AtivoID = s.AtivoID
			 	 WHERE s.SubscricoesID = $subscricoesid";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listVoBySubscricaoID($subscricoesid){
			$sql = 
				"SELECT i.* FROM tblSubscricoes s INNER JOIN 
								 tblIntegralizacoes i  ON i.SubscricoesID = s.SubscricoesID
							 	 WHERE s.SubscricoesID = $subscricoesid";
			$listIntegralizacao = parent::getList($sql, array());			
			return $listIntegralizacao;
		}

		public function GetSomatoriobySubscricoesID($subscricoesid){
			$sql = "SELECT SUM(IntegralizacaoQuantidade) AS AtivoQuantidade,
				             (SUM(IntegralizacaoValorUnitario*IntegralizacaoQuantidade)/sum(IntegralizacaoQuantidade)) as media ,
				             SUM(IntegralizacaoVolume) AS AtivoVolume
				FROM tblIntegralizacoes
				WHERE SubscricoesID = $subscricoesid";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function makeSomatoriobySubscricoesID($subscricoesid){

			$sql = "UPDATE tblAtivos SET AtivoQuantidade = (SELECT SUM(IntegralizacaoQuantidade)FROM tblIntegralizacoes	WHERE AtivoID = $ativoid),
							AtivoValorNominalUnitario= (SELECT (SUM(IntegralizacaoValorUnitario*IntegralizacaoQuantidade)/sum(IntegralizacaoQuantidade)) FROM tblIntegralizacoes	WHERE AtivoID = $ativoid),
							AtivoVolume = (SELECT SUM(IntegralizacaoVolume)FROM tblIntegralizacoes	WHERE SubscricoesID = $subscricoesid)
				WHERE SubscricoesID = $subscricoesid";
			parent::execute($sql );
		}

	}

?>