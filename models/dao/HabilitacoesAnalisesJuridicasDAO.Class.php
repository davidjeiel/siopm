<?php 

	class HabilitacoesAnalisesJuridicasDAO extends GenericDAO {
   
		public function __construct($em){
			parent::__construct($em, "HabilitacoesAnalisesJuridicas");
		}

		public function listAll(){

			$sql = "SELECT * FROM tblHabilitacoesAnalisesJuridicas";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;			
		}

		public function findByHabJuridicaID($id){

			$sql = "SELECT * FROM tblHabilitacoesAnalisesJuridicas WHERE HABJURIDICAID = :habjuridicaid";

			$arr = parent::getSingleResultArray($sql, array(":habjuridicaid" => $id));
			if ($arr === null) $arr = array();
			return $arr;
			
		}

		public function findByHabilitacaoID($id){

			$sql = "SELECT j.HabJuridicaID, j.HabilitacaoID, j.HabJuridicaConclusaoID, j.HabJuridicaArquivoID, j.HabJuridicaNumero, j.HabJuridicaData, j.HabJuridicaConsideracaoes,
						a.ArquivoID, a.ArquivoNome AS HabJuridicaArquivoNome, a.ArquivoExtensao 
					FROM tblHabilitacoesAnalisesJuridicas j LEFT OUTER JOIN tblArquivos a ON 
						j.HabJuridicaArquivoID = a.ArquivoID 
					WHERE j.HABILITACAOID = :habilitacaoid";
			$arr = parent::getSingleResultArray($sql, array(":habilitacaoid" => $id));
			if ($arr === null) $arr = array();
			return $arr;
			
		}

	}

?>
