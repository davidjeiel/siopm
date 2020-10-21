<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/CapturaDemonstrativo.Class.php';

	class CapturaDemonstrativoDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "CapturaDemonstrativo");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblCapturaDemonstrativo";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listarCapturadeSaldoMensal(){
			$sql = "SELECT Data, DataConciliacao
					FROM tblCapturaDemonstrativo
					WHERE CapturaControleID = 0
					GROUP BY Data, DataConciliacao, CapturaControleID";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listSaldosByDataCaptura($data){
			$sql = "SELECT * FROM tblCapturaDemonstrativo
					WHERE CapturaControleID = 0 and data = '$data'";			
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findByCodigoAtivoAndData($codigoAtivo,$data){
			$sql = "SELECT *
					  FROM tblCapturaDemonstrativo
					WHERE TitulosPrivados = '$codigoAtivo' and DATA = '$data'";
			$vo = parent::getVO($sql, array());
			if ($vo === null) return null;
			return $vo;
		}

	}

?>