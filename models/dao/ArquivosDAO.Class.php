<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/Arquivos.Class.php';

	class ArquivosDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "Arquivos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblArquivos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function getArrayByID($id){
			$sql = "SELECT * FROM tblArquivos WHERE ArquivoID = :arquivoid";
			$arr = parent::getListArray($sql, array(":arquivoid" => $id));
			if ($arr === null) $arr = array();
			return $arr;
		}


	}

?>