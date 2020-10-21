<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/AtivosArquivos.Class.php';

	class AtivosArquivosDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "AtivosArquivos");
		}

		public function listAquivosByAtivoID($id){
			$sql = "SELECT aa.AtivoArquivoID, aa.AtivoID, aa.AtivoArquivoTipoID, 
				 		aat.AtivoArquivoDescricao, a.ArquivoID, a.ArquivoNome, a.Arquivo
					FROM tblArquivos as a 
					INNER JOIN tblAtivosArquivos AS aa ON a.ArquivoID = aa.ArquivoID 
					INNER JOIN tblAtivosArquivosTipos AS aat ON aa.AtivoArquivoTipoID = aat.AtivoArquivoTipoID
					WHERE aa.AtivoID = $id";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listAll(){
			$sql = "SELECT * FROM tblAtivosArquivos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}


		public function hasTermos($ativoid){
			$sql = "SELECT aa.ArquivoID
					FROM tblAtivosArquivos aa INNER JOIN 
					tblAtivos a  ON aa.AtivoID = a.AtivoID 
					WHERE (a.AtivoAtivo = 1) and (aa.AtivoArquivoTipoID = 1) and (a.AtivoID = $ativoid)";
			$arr = parent::getListArray($sql, array());
			if (count($arr) > 0 ){			 	
			 	return true;
			}else{				
				return false;
			}
		}

		public function hasBoletim($ativoid){
			$sql = "SELECT aa.ArquivoID
					FROM tblAtivosArquivos aa INNER JOIN 
					tblAtivos a  ON aa.AtivoID = a.AtivoID 
					WHERE (a.AtivoAtivo = 1) and (aa.AtivoArquivoTipoID = 3) and (a.AtivoID = $ativoid)";
			$arr = parent::getListArray($sql, array());
			if (count($arr) > 0 ){			 	
			 	return true;
			}else{				
				return false;
			}
		}

	}

?>