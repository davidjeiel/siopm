<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/CapturaControle.Class.php';

	class CapturaControleDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "CapturaControle");
		}

		public function listAll(){
			$sql = "SELECT c.*, a.ArquivoNome FROM tblCapturaControle as c INNER JOIN tblArquivos AS a ON a.ArquivoID = c.ArquivoID";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listEventosByControleId($id){
			$sql = "SELECT c.Id as ControleID,c.Data,c.ArquivoID,a.ArquivoNome,c.Importador,c.DataCaptura,c.DataConciliacao,c.Conciliador
						  ,pe.Id as PlanilhaEventosID,pa.DataEvento,pe.Evento,pe.Valor,pe.CapturaTesourariaID ,pe.TipoEventoID,pe.EventoID
						  ,pa.Id as PlanilhaAtivosID,pa.CodigoAtivo,pa.AtivoID,pa.TransacaoID,pa.DemonstrativoID  
					  FROM tblCapturaControle as c
					  INNER JOIN tblCapturaPlanilhaAtivos AS pa ON pa.CapturaControleID = c.Id
					  LEFT JOIN tblCapturaPlanilhaEventos AS pe ON pe.CapturaPlanilhaAtivosID = pa.Id
					  LEFT JOIN tblArquivos AS a ON a.ArquivoID = c.ArquivoID
					WHERE  c.Id = $id";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listDemonstrativoByControleId($id){
			$sql = "SELECT D.*
						FROM tblCapturaControle AS C
						INNER JOIN tblCapturaDemonstrativo AS D ON D.CapturaControleID = C.ID
					WHERE  c.Id = $id";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}		

		public function listEventosByPlanilhaAtivoId($id){
			$sql = "SELECT c.Id as ControleID,c.Data,c.ArquivoID,a.ArquivoNome,c.Importador,c.DataCaptura,c.DataConciliacao,c.Conciliador
						  ,pe.Id as PlanilhaEventosID,pa.DataEvento,pe.Evento,pe.Valor,pe.CapturaTesourariaID ,pe.TipoEventoID,pe.EventoID
						  ,pa.Id as PlanilhaAtivosID,pa.CodigoAtivo,pa.AtivoID,pa.TransacaoID,pa.DemonstrativoID  
					  FROM tblCapturaControle as c
					  INNER JOIN tblCapturaPlanilhaAtivos AS pa ON pa.CapturaControleID = c.Id
					  LEFT JOIN tblCapturaPlanilhaEventos AS pe ON pe.CapturaPlanilhaAtivosID = pa.Id
					  LEFT JOIN tblArquivos AS a ON a.ArquivoID = c.ArquivoID
					WHERE  pa.Id = $id";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}	

		public function listPlanilhaAtivosByControleId($id){
			$sql = "SELECT c.Id as ControleID,c.Data,c.ArquivoID,a.ArquivoNome,c.Importador,c.DataCaptura,c.DataConciliacao,c.Conciliador
						,pa.DataEvento ,pa.Id as PlanilhaAtivosID,pa.CodigoAtivo,pa.AtivoID,pa.TransacaoID,pa.DemonstrativoID  
						FROM tblCapturaControle as c
						INNER JOIN tblCapturaPlanilhaAtivos AS pa ON pa.CapturaControleID = c.Id	
						LEFT JOIN tblArquivos AS a ON a.ArquivoID = c.ArquivoID
					WHERE  c.Id = $id";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}	

		public function pegarTaxadeRisco($controleID, $dataEvento, $ativoID){
			$sql = "SELECT c.Id as ControleID, pe.Id as PlanilhaEventosID,pa.DataEvento,pe.Evento,pe.Valor,
					pe.TipoEventoID,pe.EventoID,pa.Id as PlanilhaAtivosID,pa.CodigoAtivo, pa.AtivoID,pa.TransacaoID  
						FROM tblCapturaControle as c
						INNER JOIN tblCapturaPlanilhaAtivos AS pa ON pa.CapturaControleID = c.Id
						LEFT JOIN tblCapturaPlanilhaEventos AS pe ON pe.CapturaPlanilhaAtivosID = pa.Id
					WHERE  c.Id = $controleID and DataEvento = '$dataEvento' and tipoEventoID = 4 and AtivoID = $ativoID";
			$arr = parent::getSingleResultArray($sql, array());			
			if (empty($arr)) return null;
			return $arr["Valor"];			
		}

		public function verificarExistenciaLancamento($data,$valor){
			$sql ="SELECT top 1 ID
				   FROM tblCapturaTesouraria
				   WHERE data = '$data' AND ABS(Valor) = ABS($valor)";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listEventosByControleId_SemDataConciliacao($id){
			$sql = "SELECT c.Id as ControleID,c.Data,c.ArquivoID,a.ArquivoNome,c.Importador,c.DataCaptura,c.DataConciliacao,c.Conciliador
						  ,pe.Id as PlanilhaEventosID,pa.DataEvento,pe.Evento,pe.Valor,pe.CapturaTesourariaID ,pe.TipoEventoID,pe.EventoID
						  ,pa.Id as PlanilhaAtivosID,pa.CodigoAtivo,pa.AtivoID,pa.TransacaoID,pa.DemonstrativoID  
					  FROM tblCapturaControle as c
					  INNER JOIN tblCapturaPlanilhaAtivos AS pa ON pa.CapturaControleID = c.Id
					  LEFT JOIN tblCapturaPlanilhaEventos AS pe ON pe.CapturaPlanilhaAtivosID = pa.Id
					  LEFT JOIN tblArquivos AS a ON a.ArquivoID = c.ArquivoID
					WHERE  c.Id = $id and  c.DataConciliacao IS NULL ";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}	

		public function getDatasdaPlanilhaEvento(){
			$sql = "SELECT distinct pa.DataEvento  
					  FROM tblCapturaControle as c
					  INNER JOIN tblCapturaPlanilhaAtivos AS pa ON pa.CapturaControleID = c.Id					  
					  INNER JOIN tblArquivos AS a ON a.ArquivoID = c.ArquivoID  
					WHERE  c.DataCaptura IS NULL";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}	

		public function verificarEventoData($data,$ativoID)
		{
			$sql = "SELECT a.ativoID, a.AtivoCodigoCetip, t.transacaoID, t.TransacaoData,e.EventoID, e.EventoValor, e.EventoTipoID 
							FROM tblAtivos as a
							INNER JOIN tblTransacoes AS t ON a.AtivoID = t.AtivoID
							INNER JOIN tblEventos AS e ON t.TransacaoID = e.TransacaoID
					WHERE t.TransacaoData = '$data' and a.ativoID = $ativoID";
			$arr = parent::getListArray($sql, array());			
			if (empty($arr)) return false;
			return true;
		}

		public function verificarSePossuiEventoCapturadoParaMesmaData($data,$ativoID)
		{
			$sql = "SELECT A.*
						FROM tblCapturaPlanilhaAtivos as A
						INNER JOIN tblCapturaControle AS C ON C.Id = a.CapturaControleID
					WHERE A.DataEvento = '$data' and A.ativoID = $ativoID";
			$arr = parent::getListArray($sql, array());	
			if (empty($arr)) return false;
			return true;
		}

		public function findVOByID($ID){
			$sql = "SELECT Id,Data,ArquivoID,Importador, DataCaptura, DataConciliacao, Conciliador
					  FROM tblCapturaControle
					WHERE Id = $ID";
			$vo = parent::getVO($sql, array());
			if ($vo === null) return null;
			return $vo;
		}

		public function findByID($ID){
			$sql = "SELECT Id,Data,ArquivoID,Importador, DataCaptura, DataConciliacao, Conciliador
					  FROM tblCapturaControle
					WHERE Id = $ID";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>