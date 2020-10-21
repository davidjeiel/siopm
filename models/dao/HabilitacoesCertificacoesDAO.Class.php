<?php 

	class HabilitacoesCertificacoesDAO extends GenericDAO {
   
		public function __construct($em){
			parent::__construct($em, "HabilitacoesCertificacoes");
		}

		public function listAll(){

			$sql = "SELECT * FROM tblHabilitacoesCertificacoes";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;			
		}

		public function findByHabCertID($id){

			$sql = "SELECT * FROM tblHabilitacoesCertificacoes WHERE HABCERTID = :habcertid";
			$arr = parent::getSingleResultArray($sql, array(":habcertid" => $id));
			if ($arr === null) $arr = array();
			return $arr;			
		}

		public function findByHabilitacaoID($id){

			$sql = "SELECT c.HabCertID, c.HabilitacaoID, c.HabCertConclusaoID, c.HabCertArquivoID, c.HabCertNumero, c.HabCertData, c.HabCertConsideracoes, 
						c.HabCertValidade, c.HabCertRating,	a.ArquivoID, a.ArquivoNome AS HabCertArquivoNome, a.ArquivoExtensao
					FROM tblHabilitacoesCertificacoes c LEFT OUTER JOIN tblArquivos a ON 
						c.HabCertArquivoID = a.ArquivoID 
					WHERE c.HabilitacaoID = :habilitacaoid";
			$arr = parent::getSingleResultArray($sql, array(":habilitacaoid" => $id));
			if ($arr === null) $arr = array();
			return $arr;
			
		}

	}

?>
