<?php 

	class HabilitacoesDAO extends GenericDAO {
   
		public function __construct($em){
			parent::__construct($em, "Habilitacoes");
		}

		public function listAllLastHabilitacoes(){
			$sql = "SELECT 
				e.EntidadeID, e.EntidadeNomeRazao, e.EntidadeNomeFantasia, e.EntidadeCnpj, e.EntidadeTipoID, e.EntidadeUF, t.EntidadeTipoDescricao, 
				e.EntidadeTipoID, t.EntidadeTipoDescricao, 
				h.HabilitacaoID, h.UnidadeID, h.HabilitacaoMatriculaCadastro, h.HabilitacaoDataCadastro, h.HabilitacaoDataRecebimento,
				h.HabilitacaoMatriculaUltimoUpdade, h.HabilitacaoDataUltimoUpdate, h.HabilitacaoMatriculaFinalizacao, 
				h.HabilitacaoDataFinalizacao, h.HabilitacaoValidade, h.HabilitacaoObservacoes, 
				h.HabilitacaoAtiva,  h.HabilitacaoRating, h.HabilitacaoConclusaoID,
				c.ConclusaoDescricao, u.UnidadeSigla
			FROM tblEntidades as e  
				INNER JOIN tblEntidadesTipos t ON e.EntidadeTipoID = t.EntidadeTipoID 
				INNER JOIN tblHabilitacoes h ON h.HabilitacaoID = (
					SELECT TOP 1 HabilitacaoID 
					FROM tblHabilitacoes as hl
					WHERE hl.HabilitacaoAtiva = 1 AND hl.EntidadeID = e.EntidadeID 
					ORDER BY hl.HabilitacaoDataRecebimento DESC --LIMIT 1
				)
				INNER JOIN tblConclusoes c ON h.HabilitacaoConclusaoID = c.ConclusaoID
				INNER JOIN tblUnidades u on h.UnidadeID =  u.UnidadeID
			WHERE e.EntidadeAtiva = 1 
			ORDER BY e.EntidadeNomeRazao";

			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;

		}

		public function listAllHabilitacoesByIDEntidade($id){
			$sql = 
				"SELECT h.HabilitacaoID, h.EntidadeID, e.EntidadeNomeRazao, e.EntidadeNomeFantasia, e.EntidadeCnpj, 
					e.EntidadeTipoID, e.EntidadeUF, t.EntidadeTipoDescricao, 
					h.UnidadeID, h.HabilitacaoMatriculaCadastro, h.HabilitacaoDataCadastro, h.HabilitacaoDataRecebimento,
					h.HabilitacaoMatriculaUltimoUpdade, h.HabilitacaoDataUltimoUpdate, h.HabilitacaoMatriculaFinalizacao, 
					h.HabilitacaoDataFinalizacao, h.HabilitacaoValidade, h.HabilitacaoObservacoes, 
					h.HabilitacaoAtiva,  h.HabilitacaoRating, h.HabilitacaoConclusaoID, c.ConclusaoDescricao, u.UnidadeSigla
				FROM tblEntidades e INNER JOIN			
				    tblHabilitacoes h ON e.EntidadeID = h.EntidadeID INNER JOIN
				    tblUnidades u on h.UnidadeID =  u.UnidadeID INNER JOIN
				    tblEntidadesTipos t ON e.EntidadeTipoID = t.EntidadeTipoID LEFT JOIN
				    tblConclusoes c ON h.HabilitacaoConclusaoID = c.ConclusaoID
			 WHERE h.HabilitacaoAtiva = 1 and h.EntidadeID = :entidadeID";			

			$arr = parent::getListArray($sql, array(":entidadeID" => $id));
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listAll(){

			$sql = 
				"SELECT h.HabilitacaoID, h.EntidadeID, e.EntidadeNomeRazao, e.EntidadeCnpj, 
					e.EntidadeTipoID, e.EntidadeUF, t.EntidadeTipoDescricao, 
					h.UnidadeID, h.HabilitacaoMatriculaCadastro, h.HabilitacaoDataCadastro, h.HabilitacaoDataRecebimento,
					h.HabilitacaoMatriculaUltimoUpdade, h.HabilitacaoDataUltimoUpdate, h.HabilitacaoMatriculaFinalizacao, 
					h.HabilitacaoDataFinalizacao, h.HabilitacaoValidade, h.HabilitacaoObservacoes, 
					h.HabilitacaoAtiva,  h.HabilitacaoRating, h.HabilitacaoConclusaoID, c.ConclusaoDescricao, u.UnidadeSigla
				FROM tblEntidades e INNER JOIN			
				    tblHabilitacoes h ON e.EntidadeID = h.EntidadeID INNER JOIN
				    tblUnidades u on h.UnidadeID =  u.UnidadeID INNER JOIN
				    tblEntidadesTipos t ON e.EntidadeTipoID = t.EntidadeTipoID LEFT JOIN
				    tblConclusoes c ON h.HabilitacaoConclusaoID = c.ConclusaoID
				WHERE (h.HabilitacaoAtiva = 1)";


			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
			
		}

		public function listByID($id){

			$sql =
				"SELECT h.HabilitacaoID, h.EntidadeID, e.EntidadeNomeRazao, e.EntidadeCnpj, 
					e.EntidadeTipoID, e.EntidadeUF, t.EntidadeTipoDescricao, 
					h.UnidadeID, h.HabilitacaoMatriculaCadastro, h.HabilitacaoDataCadastro, h.HabilitacaoDataRecebimento,
					h.HabilitacaoMatriculaUltimoUpdade, h.HabilitacaoDataUltimoUpdate, h.HabilitacaoMatriculaFinalizacao, 
					h.HabilitacaoDataFinalizacao, h.HabilitacaoValidade, h.HabilitacaoObservacoes, 
					h.HabilitacaoAtiva,  h.HabilitacaoRating, h.HabilitacaoConclusaoID, c.ConclusaoDescricao, u.UnidadeSigla
				FROM tblEntidades e INNER JOIN			
				    tblHabilitacoes h ON e.EntidadeID = h.EntidadeID INNER JOIN
				    tblUnidades u on h.UnidadeID =  u.UnidadeID INNER JOIN
				    tblEntidadesTipos t ON e.EntidadeTipoID = t.EntidadeTipoID LEFT JOIN
				    tblConclusoes c ON h.HabilitacaoConclusaoID = c.ConclusaoID
				WHERE (h.HabilitacaoAtiva = 1) and (h.HabilitacaoID = :habilitacaoid)";

			$arr = parent::getSingleResultArray($sql, array(":habilitacaoid" => $id));
			if ($arr === null) $arr = array();
			return $arr;
			
		}

		public function listAllContatosByID($id){

			$sql =
		    	"SELECT h.HabilitacaoID, hc.HabContatoID, c.ContatoID, c.ContatoNome, c.ContatoEmail, c.ContatoFone1, c.ContatoFone2, c.ContatoObs
				 FROM tblHabilitacoes h 
				 INNER JOIN tblHabilitacoesContatos hc ON h.HabilitacaoID = hc.HabilitacaoID 
				 INNER JOIN tblContatos c ON hc.ContatoID = c.ContatoID
				 WHERE h.HabilitacaoID = :habilitacaoid";

			$arr = parent::getListArray($sql, array(":habilitacaoid" => $id));
			if ($arr === null) $arr = array();
			return $arr;
			
		}
		
	}

?>