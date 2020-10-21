<?php 

	class HabilitacoesAnalisesRiscosDAO extends GenericDAO {
   
		public function __construct($em){
			parent::__construct($em, "HabilitacoesAnalisesRiscos");
		}

		public function listAll(){

			$sql = "SELECT * FROM tblHabilitacoesAnalisesRiscos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;			
		}

		public function findByHabRiscoID($id){

			$sql = "SELECT * FROM tblHabilitacoesAnalisesRiscos WHERE HABRISCOID = :habriscoid";

			$arr = parent::getSingleResultArray($sql, array(":habriscoid" => $id));
			if ($arr === null) $arr = array();
			return $arr;
			
		}

		public function findByHabilitacaoID($id){

			$sql = "SELECT r.HabRiscoID, r.HabilitacaoID, r.HabRiscoConclusaoID, c.ConclusaoDescricao as HabRiscoConclusaoDescricao ,
							r.HabRiscoArquivoID, r.HabRiscoNumero, r.HabRiscoData, r.HabRiscoConsideracaoes, r.HabRiscoValidade,
							r.HabRiscoRating, a.ArquivoID, a.ArquivoNome AS HabRiscoArquivoNome, a.ArquivoExtensao, a.Arquivo 
					FROM tblHabilitacoesAnalisesRiscos r 
					LEFT OUTER JOIN tblConclusoes c ON r.HabRiscoConclusaoID = c.ConclusaoID
					LEFT OUTER JOIN tblArquivos a ON r.HabRiscoArquivoID = a.ArquivoID 
			        WHERE r.HABILITACAOID = :habilitacaoid";
			$arr = parent::getSingleResultArray($sql, array(":habilitacaoid" => $id));
			if ($arr === null) $arr = array();
			return $arr;
			
		}

	}

?>

