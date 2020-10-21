<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/CapturaPlanilhaEventos.Class.php';

	class CapturaPlanilhaEventosDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "CapturaPlanilhaEventos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblCapturaPlanilhaEventos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findVoByID($Id){
			$sql = "SELECT Id, CapturaPlanilhaAtivosID, Evento, Valor, CapturaTesourariaID,TipoEventoID,EventoID
  						FROM tblCapturaPlanilhaEventos
					WHERE Id = $Id";
			$vo = parent::getVO($sql, array());
			if ($vo === null) return null;
			return $vo;
		}

	}

?>