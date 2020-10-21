<?php 

	class AtivosSaldosDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "AtivosSaldos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblAtivosSaldos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function getSaldosPorSecuritizadora(){
			$sql = "SELECT 
					E.EntidadeNomeFantasia as Securitizadora, Sum(S.SaldoValor) Saldo
				FROM 
					tblAtivos A INNER JOIN
					tblAtivosEntidades AE ON A.AtivoID = AE.AtivoID INNER JOIN
					tblEntidades E ON AE.EntidadeID = E.EntidadeID INNER JOIN
					( 
						SELECT 
							AtivoID, Max (SaldoID) AS SaldoID 
						FROM 
							tblAtivosSaldos 
						GROUP BY AtivoID
					) US ON A.AtivoID = US.AtivoID INNER JOIN
					tblAtivosSaldos S ON US.SaldoID = S.SaldoID
				WHERE 
					AE.EntidadePapelID = 1
				GROUP BY
					E.EntidadeNomeFantasia";

			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function getLastSaldoFGTSByAtivoCompetencia($ativoid, $competencia){
			/* Retora o último saldo lançado para uma competência e ativo */
			$dataMesIni = new DateTime($competencia . "-01");
			$dataMesFim = new DateTime($competencia . "-01");
			$dataMesFim = $dataMesFim->modify('+1 month');
			$dataMesFim = $dataMesFim->modify('-1 day');
			$sql = "SELECT TOP 1 (s.SaldoValor - s.ProvisaoTaxaRisco) as SaldoValor, MAX(s.SaldoData) as MaxSaldoData FROM tblAtivosSaldos s 
		 		WHERE s.AtivoID = $ativoid and s.SaldoData BETWEEN '" . $dataMesIni->format('Y-m-d') . "' AND '" . $dataMesFim->format('Y-m-d') . "'
		 		GROUP BY (s.SaldoValor - s.ProvisaoTaxaRisco)";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null || !isset($arr["SaldoValor"])) return 0.00;//"ERRO_CADASTRO";
			else return $arr["SaldoValor"];

		}

		public function getLastSaldoByAtivoCompetencia($ativoid, $competencia){
			/* Retora o último saldo lançado para uma competência e ativo */
			$dataMesIni = new DateTime($competencia . "-01");
			$dataMesFim = new DateTime($competencia . "-01");
			$dataMesFim = $dataMesFim->modify('+1 month');
			$dataMesFim = $dataMesFim->modify('-1 day');
			$sql = "SELECT TOP 1 SaldoValor, MAX(s.SaldoData) as MaxSaldoData FROM tblAtivosSaldos s 
		 		WHERE s.AtivoID = $ativoid and s.SaldoData BETWEEN '" . $dataMesIni->format('Y-m-d') . "' AND '" . $dataMesFim->format('Y-m-d') . "'
		 		GROUP BY s.SaldoValor";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null || !isset($arr["SaldoValor"])) return 0.00;//"ERRO_CADASTRO";
			else return $arr["SaldoValor"];
		}

		public function verificarSeExisteLancamentoSaldoCompetencia($mês, $ano){
			$sql = "SELECT * FROM tblAtivosSaldos
					WHERE MONTH(SaldoData) = CapturaControleID = 0 AND YEAR(SaldoData) = '$data'";			
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}	

		public function findByID($id){
			$sql = "SELECT * FROM tblAtivosSaldos s 
		 		WHERE s.SaldoID = $id";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listAllSaldosByIDAtivo($ativoid){
			$sql = "SELECT * FROM tblAtivosSaldos s 
		 		WHERE s.AtivoID = $ativoid";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>