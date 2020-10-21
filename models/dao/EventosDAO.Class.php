<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/Eventos.Class.php';

	class EventosDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "Eventos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblEventos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function getArrayBySql($sql, $param){
			$arr = parent::getListArray($sql, $param);
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listEventosByAllAtivos(){
			$sql = "SELECT a.AtivoCodigoSIOPM,
					[Amortizacao]=(SELECT SUM(e.EventoValor) FROM tblEventos AS e INNER JOIN
									tblTransacoes AS t ON t.TransacaoID = e.TransacaoID 
									WHERE e.EventoTipoID = 1 and a.AtivoID = t.AtivoID and a.ModalidadeID = 1 AND t.TransacaoData BETWEEN '2008-01-31' AND '2014-12-31'),
					[AmortizacaoExtraordinaria] =(SELECT SUM(e.EventoValor) FROM tblEventos AS e INNER JOIN
									tblTransacoes AS t ON t.TransacaoID = e.TransacaoID 
									WHERE e.EventoTipoID = 2 and a.AtivoID = t.AtivoID),
					[Juros]=(SELECT SUM(e.EventoValor) FROM tblEventos AS e INNER JOIN
									tblTransacoes AS t ON t.TransacaoID = e.TransacaoID 
									WHERE e.EventoTipoID = 3 and a.AtivoID = t.AtivoID),
					[TaxaRisco]=(SELECT SUM(e.EventoValor) FROM tblEventos AS e INNER JOIN
									tblTransacoes AS t ON t.TransacaoID = e.TransacaoID 
									WHERE e.EventoTipoID = 4 and a.AtivoID = t.AtivoID),
					[Multa]=(SELECT SUM(e.EventoValor) FROM tblEventos AS e INNER JOIN
									tblTransacoes AS t ON t.TransacaoID = e.TransacaoID 
									WHERE e.EventoTipoID = 5 and a.AtivoID = t.AtivoID),
					[JurosMora]=(SELECT SUM(e.EventoValor) FROM tblEventos AS e INNER JOIN
									tblTransacoes AS t ON t.TransacaoID = e.TransacaoID 
									WHERE e.EventoTipoID = 6 and a.AtivoID = t.AtivoID),

					[TotalTransacao]=(SELECT SUM(e.EventoValor) FROM tblEventos AS e INNER JOIN
									tblTransacoes AS t ON t.TransacaoID = e.TransacaoID
									WHERE a.AtivoID = t.AtivoID)

			FROM tblAtivos as a";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}
			

		public function listByData($ativoid, $dataini, $datafim){
			$sql = "SELECT t.AtivoID, t.EventoTipoID, SUM(e.EventoValor) AS TOTALEVENTO
					FROM tblTransacoes t INNER JOIN tblEventos e 
						ON t.TransacaoID = e.TransacaoID
					WHERE (t.AtivoID = $ativoid) and (t.TransacaoData between '$dataini' and '$datafim')
					GROUP BY tblTransacoes.AtivoID, tblEventos.EventoTipoID";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function getEventoValorByTransacaoTipoEventoID($TransacaoID, $EventoTipoID){
			$sql = "SELECT EventoValor FROM tblEventos 
					WHERE TransacaoID = $TransacaoID AND EventoTipoID = $EventoTipoID";
			$arr = parent::getSingleResultArray($sql, array());
			if (isset($arr['EventoValor'])) return $arr['EventoValor']; else return "0,00";
		}

		public function listByTransacaoID($id){
			$sql = "SELECT E.*, ET.EventoTipoNome FROM tblEventos as E
					INNER JOIN tblEventosTipos as ET ON E.EventoTipoID = ET.EventoTipoID
					WHERE E.TransacaoID = $id ORDER BY ET.EventoTipoNome";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findArrayByID($id){
			$sql = "SELECT E.*, ET.EventoTipoNome FROM tblEventos as E
					INNER JOIN tblEventosTipos as ET ON E.EventoTipoID = ET.EventoTipoID
					WHERE E.EventoID = $id";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>