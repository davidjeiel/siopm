<?php 

	class EntidadesDAO extends GenericDAO {
   
		public function __construct($em){
			parent::__construct($em, "Entidades");
		}

		public function getEntidadeNomeFantasiaByID($id){
			$sql = "SELECT EntidadeNomeFantasia FROM tblEntidades WHERE EntidadeID = $id"; 
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr["EntidadeNomeFantasia"] === null) return "ENTIDADE NÃO CADASTRADA";
			else return $arr["EntidadeNomeFantasia"];
		}

		public function findByID($id){

			$sql = "SELECT e.EntidadeID, e.EntidadeCnpj, e.EntidadeTipoID, e.MatriculaCOP, 
			 				e.EntidadeNomeRazao, e.EntidadeNomeFantasia, 
		                       e.EntidadeDataAbertura, e.EntidadeEmail, e.EntidadeCEP, e.EntidadeLogradouro, e.EntidadeNumero, 
		                       e.EntidadeComplemento, e.EntidadeBairro, e.EntidadeCidade, e.EntidadeUF, 
		                       e.EntidadeFones, e.EntidadeObs, e.EntidadeResponsavel, e.EntidadeResponsavelFones, 
		                       e.EntidadeResponsavelEmail, e.EntidadeAtiva, t.EntidadeTipoDescricao
			 			FROM  tblEntidades e INNER JOIN
		                       tblEntidadesTipos t ON e.EntidadeTipoID = t.EntidadeTipoID
		         WHERE e.EntidadeID = :entidadeid ";

	        $arr = parent::getSingleResultArray($sql, array(":entidadeid" => $id));
			if ($arr === null) $arr = array();
			return $arr;

		}

		public function findByCnpj($cnpj){

			$sql = "SELECT e.EntidadeID, e.EntidadeCnpj, e.EntidadeTipoID, e.MatriculaCOP, 
			 				e.EntidadeNomeRazao, e.EntidadeNomeFantasia, 
		                       e.EntidadeDataAbertura, e.EntidadeEmail, e.EntidadeCEP, e.EntidadeLogradouro, e.EntidadeNumero, 
		                       e.EntidadeComplemento, e.EntidadeBairro, e.EntidadeCidade, e.EntidadeUF, 
		                       e.EntidadeFones, e.EntidadeObs, e.EntidadeResponsavel, e.EntidadeResponsavelFones, 
		                       e.EntidadeResponsavelEmail, e.EntidadeAtiva, t.EntidadeTipoDescricao
			 			FROM  tblEntidades e INNER JOIN
		                       tblEntidadesTipos t ON e.EntidadeTipoID = t.EntidadeTipoID
		         WHERE e.EntidadeCnpj = ':entidadecnpj' ";

	        $arr = parent::getSingleResultArray($sql, array(":entidadecnpj" => $cnpj));
			if ($arr === null) $arr = array();
			return $arr;

		}


		public function listAll(){

			$sql = "SELECT e.*, t.EntidadeTipoDescricao
				FROM  tblEntidades e INNER JOIN
                      tblEntidadesTipos t ON e.EntidadeTipoID = t.EntidadeTipoID ORDER BY e.EntidadeNomeFantasia";

			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;

		}

		public function listAllAtivas(){

			$sql = "SELECT e.EntidadeID, e.EntidadeCnpj, e.EntidadeTipoID, e.matriculaCOP, 
					e.EntidadeNomeRazao, e.EntidadeNomeFantasia, 
                      e.EntidadeDataAbertura, e.EntidadeEmail, e.EntidadeCEP, e.EntidadeLogradouro, e.EntidadeNumero, 
                      e.EntidadeComplemento, e.EntidadeBairro, e.EntidadeCidade, e.EntidadeUF,  
                      e.EntidadeFones, e.EntidadeObs, e.EntidadeResponsavel, e.EntidadeResponsavelFones, 
                      e.EntidadeResponsavelEmail, e.EntidadeAtiva, t.EntidadeTipoDescricao
				FROM  tblEntidades e INNER JOIN
                      tblEntidadesTipos t ON e.EntidadeTipoID = t.EntidadeTipoID
				WHERE e.EntidadeAtiva = 1";

			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;

		}

		public function listAllEntidadesPodeHabilitar(){
			
			$sql = "SELECT e.EntidadeID, e.EntidadeCnpj, e.EntidadeTipoID, e.matriculaCOP, 
		       e.EntidadeNomeRazao, e.EntidadeNomeFantasia, 
		          e.EntidadeDataAbertura, e.EntidadeEmail, e.EntidadeCEP, e.EntidadeLogradouro, e.EntidadeNumero, 
		          e.EntidadeComplemento, e.EntidadeBairro, e.EntidadeCidade, e.EntidadeUF,  
		          e.EntidadeFones, e.EntidadeObs, e.EntidadeResponsavel, e.EntidadeResponsavelFones, 
		          e.EntidadeResponsavelEmail, e.EntidadeAtiva, t.EntidadeTipoDescricao
			FROM  tblEntidades e INNER JOIN
		          tblEntidadesTipos t ON e.EntidadeTipoID = t.EntidadeTipoID
		    WHERE e.EntidadeAtiva = 1 AND e.EntidadeID NOT IN 
		    (SELECT E.EntidadeID FROM tblEntidades as E LEFT JOIN
			     tblHabilitacoes as HL ON E.EntidadeID = HL.EntidadeID
				WHERE HL.HabilitacaoAtiva = 1 AND HL.HabilitacaoConclusaoId = 1 or E.EntidadeTipoID = 5
			)
		    ORDER BY e.EntidadeNomeRazao";

		    $arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;

		}

		public function listAllSecuritizadoras(){
			// As entidades de tipo '3' são securitizadoras
			return $this->getListEntidadesByTipoEntidade(3);
		}

		public function listAllAgentesFiduciarios(){
			// As entidades de tipo '2' são agentes Fiduciarios
			return $this->getListEntidadesByTipoEntidade(2);
		}

		public function listAllAgentesRating(){
			// As entidades de tipo '5' são agentes de Rating
			return $this->getListEntidadesByTipoEntidade(5);
		}

		public function listAllCoordenadoresLideres(){
			// Não há tipo específico para Cordenador Lider
			return $this->listAllAtivas();
		}

		public function listAllOriginadoresCreditos(){
			// Não há tipo específico para Originadores de Créditos
			return $this->listAllAtivas();
		}

		private function listAtivasByTipoEntidade($id){

			$sql = "SELECT e.EntidadeID, e.EntidadeCnpj, e.EntidadeTipoID, e.matriculaCOP, 
					e.EntidadeNomeRazao, e.EntidadeNomeFantasia, 
                      e.EntidadeDataAbertura, e.EntidadeEmail, e.EntidadeCEP, e.EntidadeLogradouro, e.EntidadeNumero, 
                      e.EntidadeComplemento, e.EntidadeBairro, e.EntidadeCidade, e.EntidadeUF,  
                      e.EntidadeFones, e.EntidadeObs, e.EntidadeResponsavel, e.EntidadeResponsavelFones, 
                      e.EntidadeResponsavelEmail, e.EntidadeAtiva, t.EntidadeTipoDescricao
				FROM  tblEntidades e INNER JOIN
                      tblEntidadesTipos t ON e.EntidadeTipoID = t.EntidadeTipoID
				WHERE e.EntidadeAtiva = 1 AND e.EntidadeTipoID = $id";

			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;

		}

		public function getEntidadeArrayByEntidadeID($id){

			//Retorna todas as Entidades pelo tipo e a última habilitaçao caso exista.

			$sql = "SELECT 
						e.EntidadeID, e.EntidadeNomeRazao, e.EntidadeNomeFantasia, e.EntidadeCnpj, e.EntidadeTipoID, e.EntidadeUF, t.EntidadeTipoDescricao, 
						e.EntidadeTipoID, t.EntidadeTipoDescricao, 
						h.HabilitacaoID, h.UnidadeID, h.HabilitacaoMatriculaCadastro, h.HabilitacaoDataCadastro, h.HabilitacaoDataRecebimento,
						h.HabilitacaoMatriculaUltimoUpdade, h.HabilitacaoDataUltimoUpdate, h.HabilitacaoMatriculaFinalizacao, 
						h.HabilitacaoDataFinalizacao, h.HabilitacaoValidade, h.HabilitacaoObservacoes, 
						h.HabilitacaoAtiva,  h.HabilitacaoRating, h.HabilitacaoConclusaoID,
						c.ConclusaoDescricao, u.UnidadeSigla,
						CASE WHEN h.HabilitacaoConclusaoID IS NULL THEN
							'Não Habilitado'
						ELSE
							CASE WHEN h.HabilitacaoConclusaoID IN (2,3) THEN
								CASE WHEN h.HabilitacaoValidade >= GETDATE() THEN
									'Vigente'
								ELSE
									'Vencida'
								END
							ELSE
								CASE h.HabilitacaoConclusaoID 
									WHEN 4 THEN
										'Negada'
									WHEN 1 THEN
										'Em Atualização'
								END
							END
						END as StatusHabilitacao
					FROM tblEntidades as e  
						INNER JOIN tblEntidadesTipos t ON e.EntidadeTipoID = t.EntidadeTipoID 
						LEFT JOIN tblHabilitacoes h ON h.HabilitacaoID = (
							SELECT TOP 1 HabilitacaoID 
							FROM tblHabilitacoes as hl
							WHERE hl.HabilitacaoAtiva = 1 AND hl.EntidadeID = e.EntidadeID 
							ORDER BY hl.HabilitacaoDataRecebimento DESC --LIMIT 1
						)
						LEFT JOIN tblConclusoes c ON h.HabilitacaoConclusaoID = c.ConclusaoID
						LEFT JOIN tblUnidades u on h.UnidadeID =  u.UnidadeID
					WHERE e.EntidadeAtiva = 1 AND e.EntidadeID = :entidadeid 
					ORDER BY e.EntidadeNomeRazao";

			$arr = parent::getSingleResultArray($sql, array(":entidadeid" => $id));
			if ($arr === null) $arr = array();
			return $arr;

		}
		
		private function getListEntidadesByTipoEntidade($id){

			//Retorna todas as Entidades pelo tipo e a última habilitaçao caso exista.

			$sql = "SELECT 
						e.EntidadeID, e.EntidadeNomeRazao, e.EntidadeNomeFantasia, e.EntidadeCnpj, e.EntidadeTipoID, e.EntidadeUF, t.EntidadeTipoDescricao, 
						e.EntidadeTipoID, t.EntidadeTipoDescricao, 
						h.HabilitacaoID, h.UnidadeID, h.HabilitacaoMatriculaCadastro, h.HabilitacaoDataCadastro, h.HabilitacaoDataRecebimento,
						h.HabilitacaoMatriculaUltimoUpdade, h.HabilitacaoDataUltimoUpdate, h.HabilitacaoMatriculaFinalizacao, 
						h.HabilitacaoDataFinalizacao, h.HabilitacaoValidade, h.HabilitacaoObservacoes, 
						h.HabilitacaoAtiva,  h.HabilitacaoRating, h.HabilitacaoConclusaoID,
						c.ConclusaoDescricao, u.UnidadeSigla,
						CASE WHEN h.HabilitacaoConclusaoID IS NULL THEN
							'Não Habilitado'
						ELSE
							CASE WHEN h.HabilitacaoConclusaoID IN (2,3) THEN
								CASE WHEN h.HabilitacaoValidade >= GETDATE() THEN
									'Vigente'
								ELSE
									'Vencida'
								END
							ELSE
								CASE h.HabilitacaoConclusaoID 
									WHEN 4 THEN
										'Negada'
									WHEN 1 THEN
										'Em Atualização'
								END
							END
						END as StatusHabilitacao
					FROM tblEntidades as e  
						INNER JOIN tblEntidadesTipos t ON e.EntidadeTipoID = t.EntidadeTipoID 
						LEFT JOIN tblHabilitacoes h ON h.HabilitacaoID = (
							SELECT TOP 1 HabilitacaoID 
							FROM tblHabilitacoes as hl
							WHERE hl.HabilitacaoAtiva = 1 AND hl.EntidadeID = e.EntidadeID 
							ORDER BY hl.HabilitacaoDataRecebimento DESC --LIMIT 1
						)
						LEFT JOIN tblConclusoes c ON h.HabilitacaoConclusaoID = c.ConclusaoID
						LEFT JOIN tblUnidades u on h.UnidadeID =  u.UnidadeID
					WHERE e.EntidadeAtiva = 1 AND e.EntidadeTipoID = :entidadetipo -- (1 - Agente Financeiro, 2 - Agente Fiduciário, 3 - Securitizadora) 
					ORDER BY e.EntidadeNomeRazao";

			$arr = parent::getListArray($sql, array(":entidadetipo" => $id));
			if ($arr === null) $arr = array();
			return $arr;

		}

	}

?>
