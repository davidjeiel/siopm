<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/EventosTipos.Class.php';

	class EventosTiposDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "EventosTipos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblEventosTipos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function procurarEventoTipo($tipoNome){
			$sql = "SELECT [EventoTipoID]
					  FROM [tblEventosTipos]
					  where EventoTipoNome = '$tipoNome'";
			$vo = parent::getVO($sql, array());
			if ($vo === null) return null;
			return $vo->getEventoTipoID();
		}

	}

?>