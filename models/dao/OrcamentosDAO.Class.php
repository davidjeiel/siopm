<?php
	class OrcamentosDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "Orcamentos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblOrcamentos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listAllCRI(){
			$sql = "SELECT * FROM tblOrcamentos AS o WHERE o.OrcamentoTipoID = 1 "; //Tipo 1 - CRI
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listAllAtivaCRI(){
			$sql = "SELECT  o.OrcamentoID, o.OrcamentoAno, o.OrcamentoResolucao, o.OrcamentoDataIni, o.OrcamentoDataFim, o.OrcamentoSaldoInicial, 
						CASE 
							WHEN SUM(s.SubscricoesVolume) IS NULL THEN 0 
							ELSE SUM(s.SubscricoesVolume) 
						END AS TotalSubscricao, 
						CASE 
							WHEN SUM(s.SubscricoesVolume) IS NULL THEN o.OrcamentoSaldoInicial 
							ELSE o.OrcamentoSaldoInicial - SUM(s.SubscricoesVolume) 
						END AS SaldoOrcamento 
					FROM tblOrcamentos AS o 
					LEFT JOIN tblPropostas as p on p.OrcamentoID = o.OrcamentoID 
					LEFT JOIN tblAtivos as a on p.PropostaID = a.PropostaID 
					LEFT JOIN tblSubscricoes as s on a.AtivoID = s.AtivoID 
					WHERE o.OrcamentoTipoID = 1 and o.OrcamentoAtivo = 1 
					GROUP BY o.OrcamentoID, o.OrcamentoAno, o.OrcamentoResolucao, o.OrcamentoDataIni, o.OrcamentoDataFim, o.OrcamentoSaldoInicial;"; //Tipo 1 - CRI
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listSubscricoesByOrcamentoID($id){
			$sql = "SELECT o.OrcamentoID, s.SubscricoesID, p.PropostaNumero, a.AtivoCodigoSIOPM , a.AtivoID, s.SubscricoesData, s.SubscricoesVolume, s.SubscricoesQuantidade, s.SubscricoesValorUnitario
					FROM tblOrcamentos AS o
						INNER JOIN tblPropostas as p on p.OrcamentoID = o.OrcamentoID
						INNER JOIN tblAtivos as a on p.PropostaID = a.PropostaID
						INNER JOIN tblSubscricoes as s on a.AtivoID = s.AtivoID 
					WHERE o.OrcamentoTipoID = 1 and o.OrcamentoAtivo = 1 and o.OrcamentoID = $id";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function getAnosOrcamentarios(){
			$sql = "SELECT DISTINCT OrcamentoAno FROM tblOrcamentos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function getOrcamentoByID($id){
			$sql = "SELECT * FROM tblOrcamentos where OrcamentoID = $id";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function hasOrcamentoAnoCRI($ano){
			$sql = "SELECT OrcamentoAno FROM tblOrcamentos where OrcamentoAno = $ano and OrcamentoTipoID = 1 ";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			if (isset($arr["OrcamentoAno"])) return true; else return false;
		}

		public function getOrcamentoAnoByID($id){
			$sql = "SELECT OrcamentoAno FROM tblOrcamentos where OrcamentoID = $id";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			if (isset($arr["OrcamentoAno"])) return $arr["OrcamentoAno"]; else return "0000";
		}

	}
?>