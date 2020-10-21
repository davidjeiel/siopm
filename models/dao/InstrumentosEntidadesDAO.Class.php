<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/InstrumentosEntidades.Class.php';

	class InstrumentosEntidadesDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "InstrumentosEntidades");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblInstrumentosEntidades";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findByID($id){
			$sql = "SELECT * FROM tblInstrumentosEntidades ie 
			 		WHERE ie.InstrumentoEntidadeID = $id";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listAllByIDInstrumento($instrumentoid){
			$sql = "SELECT ie.InstrumentoEntidadeID, ie.InstrumentoID, ie.EntidadeID, ie.EntidadePapelID, e.EntidadeCnpj, e.EntidadeNomeFantasia, ep.EntidadePapelNome
					FROM tblInstrumentosEntidades ie INNER JOIN			
						    tblEntidades e ON ie.EntidadeID = e.EntidadeID INNER JOIN			
						    tblEntidadesPapeis ep ON ie.EntidadePapelID = ep.EntidadePapelID
					WHERE ie.InstrumentoID = $instrumentoid";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}		

	}

?>