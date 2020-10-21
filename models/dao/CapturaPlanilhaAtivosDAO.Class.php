<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/CapturaPlanilhaAtivos.Class.php';

	class CapturaPlanilhaAtivosDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "CapturaPlanilhaAtivos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblCapturaPlanilhaAtivos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findByID($Id){
			$sql = "SELECT Id, CapturaControleID, DataEvento, CodigoAtivo, AtivoID, TransacaoID, DemonstrativoID
					  FROM tblCapturaPlanilhaAtivos
					WHERE Id = $Id";
	      	$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findVoByID($Id){
			$sql = "SELECT Id, CapturaControleID, DataEvento, CodigoAtivo, AtivoID, TransacaoID, DemonstrativoID
					  FROM tblCapturaPlanilhaAtivos
					WHERE Id = $Id";
			$vo = parent::getVO($sql, array());
			if ($vo === null) return null;
			return $vo;
		}

	}

?>