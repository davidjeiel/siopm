<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/PropostasArquivos.Class.php';

	class PropostasArquivosDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "PropostasArquivos");
		}

		public function listAquivosByPropostaDetalheID($id){
			$sql = "SELECT pa.PropostaArquivoID, pa.PropostaDetalheID, pa.PropostaArquivoTipoID, 
				 		pat.PropostaArquivoDescricao, a.ArquivoID, a.ArquivoNome, a.Arquivo
					FROM tblArquivos as a 
					INNER JOIN tblPropostasArquivos AS pa ON a.ArquivoID = pa.ArquivoID 
					INNER JOIN tblPropostasArquivosTipos AS pat ON pa.PropostaArquivoTipoID = pat.PropostaArquivoTipoID
					WHERE pa.PropostaDetalheID = $id";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listAll(){
			$sql = "SELECT * FROM tblPropostasArquivos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>