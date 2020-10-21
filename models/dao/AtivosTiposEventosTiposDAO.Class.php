<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/AtivosTiposEventosTipos.Class.php';

	class AtivosTiposEventosTiposDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "AtivosTiposEventosTipos");
		}

		public function listAllEventosTiposByAtivoTipoID($id){
			$sql = "SELECT at.*, et.EventoTipoNome FROM tblAtivosTiposEventosTipos AS at
					INNER JOIN tblEventosTipos AS et ON at.EventoTipoID = et.EventoTipoID
					WHERE at.AtivoTipoID = $id ORDER BY at.EventoTipoOrdem ";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listAllEventosTiposCRI(){
			return $this->listAllEventosTiposByAtivoTipoID(1); // 1 - CRI 
		}

		public function listAll(){
			$sql = "SELECT * FROM tblAtivosTiposEventosTipos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>