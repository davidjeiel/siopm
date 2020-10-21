<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/FechamentoCompetencia.Class.php';

	class FechamentoCompetenciaDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "FechamentoCompetencia");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblFechamentoCompetencia";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function pegarUltimaCompetenciaFechada(){
			$sql = "SELECT TOP 1 ID, Competencia, Matricula, DataFechamento, ModalidadeID
						  FROM tblFechamentoCompetencia as F
						ORDER BY Competencia DESC";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function getListAtivosComTransacoesPorCompetencia($competencia){
			$sql = "SELECT a.AtivoCodigoCetip, a.AtivoCodigoSIOPM, t.TransacaoData, t.TransacaoID,
						   t.AtivoID, SUM(e.EventoValor) as ValorTotal
					FROM tblAtivos as a INNER JOIN tblTransacoes as t ON a.AtivoID = t.AtivoID 
									    LEFT JOIN tblEventos as e ON e.TransacaoID = t.TransacaoID
					WHERE CONVERT(VARCHAR(7),t.TransacaoData) = '$competencia'
					GROUP BY a.AtivoCodigoCetip, a.AtivoCodigoSIOPM, t.TransacaoData, t.TransacaoID, t.AtivoID";
					//COMPETENCIA FORMATO Y-m
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function verificarSeCompetenciaFechada($competencia){
			$sql = "SELECT Competencia, Matricula, DataFechamento
					FROM tblFechamentoCompetencia as c
					WHERE CONVERT(VARCHAR(7),c.Competencia) = '$competencia' ";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();			
			return $arr;
		}


	}

?>