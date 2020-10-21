<?php 

	class HabilitacoesAnalisesRiscosExternosDAO extends GenericDAO {
   
		public function __construct($em){
			parent::__construct($em, "HabilitacoesAnalisesRiscosExternos");
		}

		public function listAll(){

			$sql = "SELECT * FROM tblHabilitacoesAnalisesRiscosExternos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;			
		}

		public function findByHabRiscoID($id){

			$sql = "SELECT * FROM tblHabilitacoesAnalisesRiscosExternos WHERE HABRISCOEXTID = :habriscoextid";
			$arr = parent::getSingleResultArray($sql, array(":habriscoextid" => $id));
			if ($arr === null) $arr = array();
			return $arr;
			
		}

		public function findByHabilitacaoID($id){

			$sql = "SELECT e.HabRiscoExtID, e.HabilitacaoID, e.HabRiscoExtEntidadeID, e.HabRiscoExtArquivoID,  e.HabRiscoExtConsideracoes,
			e.HabRiscoExtRating, a.ArquivoID, a.ArquivoNome AS HabRiscoExtArquivoNome, a.ArquivoExtensao
		FROM tblHabilitacoesAnalisesRiscosExternos e LEFT OUTER JOIN tblArquivos a ON 
			e.HabRiscoExtArquivoID = a.ArquivoID 
        WHERE e.HabilitacaoID = :habilitacaoid";
			$arr = parent::getSingleResultArray($sql, array(":habilitacaoid" => $id));
			if ($arr === null) $arr = array();
			return $arr;
			
		}

	}

?>
