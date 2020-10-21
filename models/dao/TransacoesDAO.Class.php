<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/Transacoes.Class.php';

	class TransacoesDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "Transacoes");
		}

		public function existeTransacao($transacao){
			$ativo = $transacao->getAtivoID();
			$data = $transacao->getTransacaoData("Y-m-d");
			$transacao = $transacao->getTransacaoID(); 
			$sql = "SELECT count(TransacaoID) as EXISTETRANSACAO 
					FROM tblTransacoes
					WHERE AtivoID = $ativo AND TransacaoData = '$data'
					 AND TransacaoID <> '$transacao'";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr['EXISTETRANSACAO'] > 0) return true; else return false;
		}

		public function listAll(){
			$sql = "SELECT * FROM tblTransacoes";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listarUltimasTransacoes(){
			$sql =  "SELECT  T.AtivoID,A.AtivoCodigoCetip, T.TransacaoID, E.somaEvento, TT.TransacaoData from
				(Select AtivoID, max(TransacaoID) as TransacaoID from tblTransacoes GROUP BY AtivoID) as T 
				INNER JOIN
				(Select TransacaoID, Sum(EventoValor) as somaEvento from tblEventos GROUP BY TransacaoID) as E 
				on T.TransacaoID = E.TransacaoID
				INNER JOIN 
				tblTransacoes TT on TT.TransacaoID = T.TransacaoID
				INNER JOIN 
				tblAtivos as A on T.AtivoID = A.AtivoID";
				$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listAllByAtivoID($id){
			$sql = "SELECT t.*,
					(
						SELECT SUM(EventoValor) 
						FROM tblEventos as e
						WHERE e.TransacaoID = t.TransacaoID
					) as TotalTransacao 
					FROM tblTransacoes as t 
					WHERE AtivoID = $id ORDER BY t.TransacaoData DESC";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findArrayByID($id){
			$sql = "SELECT * FROM tblTransacoes WHERE TransacaoID = $id";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>