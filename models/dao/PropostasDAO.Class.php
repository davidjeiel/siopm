<?php 

	class PropostasDAO extends GenericDAO {

		const SQL_BASE = "SELECT P.*,D.*
						,S.StatusNome
						,FT.PropostaFaixaTipoNome
						,FS.PropostaFaseNome
						,O.OrcamentoAno
						,ES.EntidadeNomeFantasia AS SecuritizadoraNome
						,EO.EntidadeNomeFantasia AS OriginadorNome
						,PR.ProgramaNome 
					FROM tblPropostas AS P
					INNER JOIN tblProgramas 			AS PR 	ON PR.ProgramaID = P.ProgramaID 
					INNER JOIN tblPropostasDetalhes 	AS D 	ON D.PropostaID = P.PropostaID 
					INNER JOIN tblPropostasStatus 		AS S 	ON D.PropostaStatusID = S.PropostaStatusID
					INNER JOIN tblPropostasFaixas 		AS FX 	ON P.PropostaFaixaID = FX.PropostaFaixaID 
					INNER JOIN tblPropostasFaixasTipos 	AS FT 	ON FX.PropostaFaixaTipoID = FT.PropostaFaixaTipoID
					INNER JOIN tblPropostasFases 		AS FS 	ON D.PropostaFaseID = FS.PropostaFaseID
					INNER JOIN tblOrcamentos			AS O 	ON P.OrcamentoID = O.OrcamentoID
					LEFT OUTER JOIN	tblEntidades 		AS ES 	ON P.SecuritizadoraID = ES.EntidadeID 
					LEFT OUTER JOIN	tblEntidades 		AS EO 	ON D.OriginadorID = EO.EntidadeID 
					WHERE P.PropostaAtiva = 1";
                
		public function __construct($em){
			parent::__construct($em, "Propostas");
		}

		public function getCountPropostaByOrcamentoID($id){
			$sql = "SELECT count(PropostaID) as TOTPROP FROM tblPropostas where OrcamentoID = '$id'";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) return 0; else return $arr["TOTPROP"];
		}

		public function listAll(){
			$arr = parent::getListArray(self::SQL_BASE, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listAllPorAnoOrcamentario($ano){
			$sql = "SELECT P.PropostaNumero, ES.EntidadeNomeFantasia AS SecuritizadoraNome, D.ValorCRISenior, D.PropostaFaseID, S.StatusNome
					FROM tblPropostas as P 
					INNER JOIN tblPropostasDetalhes AS D ON D.PropostaID = P.PropostaID 
					INNER JOIN tblOrcamentos O ON P.OrcamentoID = O.OrcamentoID
					INNER JOIN tblPropostasStatus AS S ON D.PropostaStatusID = S.PropostaStatusID
					LEFT OUTER JOIN tblEntidades AS ES ON P.SecuritizadoraID = ES.EntidadeID
					WHERE P.PropostaAtiva = 1 AND O.OrcamentoAno = $ano --Year(D.DataRecepcao) = '$ano'";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listAllPreliminares(){
			return $this->listAllByFase(1);// Fase 1 = PRELIMINAR, 2 = DEFINITIVA
		}

		public function listAllDefinitivas(){
			return $this->listAllByFase(2);// Fase 1 = PRELIMINAR, 2 = DEFINITIVA
		}

		public function findArrayByID($id){
            $sql = self::SQL_BASE . " AND P.PropostaID = :propostasid";
			$arr = parent::getSingleResultArray($sql, array(":propostasid" => $id));
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findArrayByPropostaDetalheID($id){
            $sql = self::SQL_BASE . " AND D.PropostaDetalheID = $id";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findArrayForFinalizacaoByPropostaDetalheID($id){
            $sql = self::SQL_BASE . " AND D.PropostaDetalheID = $id";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		private function listAllByFase($fase){
			$sql = self::SQL_BASE . " AND D.PropostaFaseID = $fase"; 
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findViewArrayByPropostaDetalheID($id){
			$sql = "SELECT P.*,D.*
						,S.StatusNome
						,FT.PropostaFaixaTipoNome
						,FS.PropostaFaseNome
						,O.OrcamentoAno
						,ES.EntidadeNomeFantasia AS SecuritizadoraNome
						,EO.EntidadeNomeFantasia AS OriginadorNome
						,EC.EntidadeNomeFantasia AS CoordenadorLiderNome
						,EA.EntidadeNomeFantasia AS AgenteFiduciarioNome
						,PR.ProgramaNome, UN.UnidadeSigla , O.OrcamentoResolucao, ET.PropEmpreendNome
					FROM tblPropostas AS P
					INNER JOIN tblProgramas 			AS PR 	ON PR.ProgramaID = P.ProgramaID 
					INNER JOIN tblPropostasDetalhes 	AS D 	ON D.PropostaID = P.PropostaID 
					INNER JOIN tblPropostasStatus 		AS S 	ON D.PropostaStatusID = S.PropostaStatusID
					INNER JOIN tblPropostasFaixas 		AS FX 	ON P.PropostaFaixaID = FX.PropostaFaixaID 
					INNER JOIN tblPropostasFaixasTipos 	AS FT 	ON FX.PropostaFaixaTipoID = FT.PropostaFaixaTipoID
					INNER JOIN tblPropostasFases 		AS FS 	ON D.PropostaFaseID = FS.PropostaFaseID
					INNER JOIN tblOrcamentos			AS O 	ON P.OrcamentoID = O.OrcamentoID
					LEFT OUTER JOIN tblUnidades 		AS UN 	ON UN.UnidadeID = P.UnidadeID
					LEFT OUTER JOIN tblPropostasEmpreendimentosTipos AS ET ON ET.PropEmpreendTipoID = P.PropEmpreendTipoID
					LEFT OUTER JOIN	tblEntidades 		AS ES 	ON P.SecuritizadoraID = ES.EntidadeID 
					LEFT OUTER JOIN	tblEntidades 		AS EO 	ON D.OriginadorID = EO.EntidadeID 
					LEFT OUTER JOIN	tblEntidades 		AS EC 	ON D.CoordenadorLiderID = EC.EntidadeID
					LEFT OUTER JOIN	tblEntidades 		AS EA 	ON D.AgenteFiduciarioID = EA.EntidadeID 
					WHERE P.PropostaAtiva = 1";

            $sql .= " AND D.PropostaDetalheID = $id";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}
		
	}

?>