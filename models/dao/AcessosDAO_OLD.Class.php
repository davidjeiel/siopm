<?php 

	// $ambienteIP = new AmbienteInformativoPEFUG();
	// $ambienteIP->declararClasse("Acessos","/informativoPEFUG/vo/Acessos.Class.php");

	class AcessosDAO_OLD {

		private $em;

		public function __construct($em){
			$this->em = $em;
		}

		public function insert($vo){
			return $this->em->insert($vo);
		}

		public function update($vo){
			return $this->em->update($vo);
		}

		public function persist($vo){
			return $this->em->save($vo);
		}

		public function delete($vo){
			$this->em->delete($vo);
		}

		public function find($id){
			return $this->em->find('Acessos', $id);
		}

		public function fillEntityByRequest($Request){
			return $this->em->fillEntityByRequest('Acessos', $Request);
		}

		private function buildQuery($consulta, $parametros){

			$q = $this->em->createQuery('Acessos', $consulta);

			foreach($parametros as $indice => $valor){
				$q->setParameter($indice, $valor);
			}

			return $q;

		}

		public function getVO($consulta, $parametros = array()){
			$q = $this->buildQuery($consulta, $parametros);
			return $q->getSingleResult();
		}

		public function getList($consulta, $parametros = array()){
			$q = $this->buildQuery($consulta, $parametros);
			return $q->getList();
		}

		public function getListArray($consulta, $parametros = array()){
			$q = $this->buildQuery($consulta, $parametros);
			return $q->getListArray();
		}

		public function getSql($consulta, $parametros = array()){
			$q = $this->buildQuery($consulta, $parametros);
			return $q->getSql();
		}
		
		public function getRelatorioUnidade($usuario,$dia,$incluir,$periodoInicial,$periodoFinal,$unidade){
			
			$consulta = "SELECT ";
			$consulta .= "A.acessoUnidade AS Unidade,U.UNID_Nome AS UnidadeNome,U.UNID_Sigla AS Sigla"; 
			
			if( $usuario ) $consulta .= ",A.acessoMatricula AS Matricula, E.Empregado"; 
			if( $dia ) $consulta .= ",CONVERT(varchar, MONTH(A.acessoDataHora)) + '/' + CONVERT(varchar, DAY(A.acessoDataHora)) AS Data";
			
			$consulta .= ",COUNT(A.acessoID) AS qtd ";
			$consulta .= "FROM tblAcessos A LEFT OUTER JOIN ";
            $consulta .= "dbSiIAG.dbSiIAG.tbl_Unidades U ON A.acessoUnidade = U.UNID_Codigo ";
			
			if( $usuario ) $consulta .= "LEFT OUTER JOIN [CAIXASQLP239.CORP.CAIXA.GOV.BR\CAIXASQLP239].[PÚBLICO].dbo.vw_EmpregadosFGTS E ON E.Matrícula COLLATE DATABASE_DEFAULT = SUBSTRING(A.acessoMatricula, 2, 6) COLLATE DATABASE_DEFAULT ";
			
			$consulta .= "WHERE acessoDataHora BETWEEN ";						
			$consulta .= "CONVERT(DATETIME, ':periodoInicial 00:00:00', 102) AND ";
			$consulta .= "CONVERT(DATETIME, ':periodoFinal 23:59:59', 102) ";
			
			if( $incluir ) $consulta .= "AND acessoMatricula NOT in (SELECT usuarioMatricula FROM tblUsuariosPEFUG) ";
			
			if( $unidade != 'T' ) $consulta .= "AND acessoUnidade='" . $unidade . "' ";
			
			$consulta .= "GROUP BY A.acessoUnidade,U.UNID_Nome,U.UNID_Sigla ";
			if( $usuario ) $consulta .= ",A.acessoMatricula, E.Empregado ";
			if( $dia ) $consulta .= ",CONVERT(varchar, MONTH(A.acessoDataHora)) + '/' + CONVERT(varchar, DAY(A.acessoDataHora)) ";
			
			$consulta .= "ORDER BY E.Sigla";
			if( $dia ) $consulta .= ",data";
			if( $usuario ) $consulta .= ",Matricula";

			$q = $this->em->createQuery('Acessos', $consulta);
			$q->setParameter(":periodoInicial", $periodoInicial);
			$q->setParameter(":periodoFinal", $periodoFinal);
			
			//echo $q->getSQL();
			exit;
			return $q->getListArray();
			
		}

	}

/*


	const FIND_AcessosPorPivotPeriodo = "
		SELECT
			:pivot as pivot,COUNT(acessoID) AS qtd
		FROM
			tblAcessos A
		WHERE
			acessoDataHora BETWEEN
				CONVERT(DATETIME, ':periodoInicial 00:00:00', 102) AND
				CONVERT(DATETIME, ':periodoFinal 23:59:59', 102)
			:incluir
		GROUP BY
			:pivot
		ORDER BY
			COUNT(acessoID) DESC
	";
	
	const FIND_AcessoPorDiaPeriodo = "
		SELECT
			day(acessoDataHora) as pivot,COUNT(acessoID) AS qtd
		FROM
			tblAcessos A
		WHERE
			acessoDataHora BETWEEN
				CONVERT(DATETIME, ':periodoInicial 00:00:00', 102) AND
				CONVERT(DATETIME, ':periodoFinal 23:59:59', 102)
			:incluir
		GROUP BY
			day(acessoDataHora)
		ORDER BY
			day(acessoDataHora)
	";
	
	const FIND_AcessosPorUsuarioPeriodo = "
		SELECT
			acessoMatricula as pivot,Empregado, SubProcesso as Coordenacao, Sigla, COUNT(acessoID) AS qtd 
		FROM
			tblAcessos A LEFT JOIN 
			[CAIXASQLP425\CAIXASQLP425].[PÚBLICO].dbo.vw_EmpregadosFGTS E ON 
					E.Matrícula COLLATE DATABASE_DEFAULT = SUBSTRING(A.acessoMatricula, 2, 6) COLLATE DATABASE_DEFAULT
		WHERE
			acessoDataHora BETWEEN
				CONVERT(DATETIME, ':periodoInicial 00:00:00', 102) AND
				CONVERT(DATETIME, ':periodoFinal 23:59:59', 102)
			:incluir
		GROUP BY
			acessoMatricula,Empregado,SubProcesso,Sigla
		ORDER BY
			COUNT(acessoID) DESC
	";
	
	
	const FIND_AcessoPorUnidadePeriodo = "
		SELECT
			acessoUnidade as pivot, UNID_Nome as UnidadeNome, UNID_Sigla as Sigla, COUNT(acessoID) AS qtd 
		FROM
			tblAcessos A LEFT JOIN 
			dbSiIAG.dbSiIAG.tbl_Unidades U ON A.acessoUnidade = U.UNID_Codigo
		WHERE
			acessoDataHora BETWEEN
				CONVERT(DATETIME, ':periodoInicial 00:00:00', 102) AND
				CONVERT(DATETIME, ':periodoFinal 23:59:59', 102)
			:incluir
		GROUP BY
			acessoUnidade,UNID_Nome,UNID_Sigla
		ORDER BY
			COUNT(acessoID) DESC
	";
	
	const FIND_AcessosPorUsuarioUnicoPeriodo = "
		SELECT     
			E.[Código Unidade] as pivot,E.[Nome Unidade] AS unidade,E.Sigla as sigla, 
			SUM( CASE WHEN NOT acessoMatricula IS NULL THEN 1 ELSE 0 END ) AS qtd,
			COUNT([Matrícula ]) AS qtdTotal
		FROM	
			[CAIXASQLP425\CAIXASQLP425].PÚBLICO.dbo.vw_EmpregadosFGTS E LEFT OUTER JOIN 
			(
				SELECT DISTINCT 
					acessoMatricula 
				FROM tblAcessos 
				WHERE
					acessoDataHora BETWEEN
						CONVERT(DATETIME, ':periodoInicial 00:00:00', 102) AND
						CONVERT(DATETIME, ':periodoFinal 23:59:59', 102)
					:incluir
			) A ON E.Matrícula COLLATE DATABASE_DEFAULT = SUBSTRING(A.acessoMatricula, 2, 6) COLLATE DATABASE_DEFAULT
		GROUP BY
			E.[Código Unidade],E.[Nome Unidade],E.Sigla
		ORDER BY 
			SUM( CASE WHEN NOT acessoMatricula IS NULL THEN 1 ELSE 0 END ) DESC
	";
	
	const FIND_UnidadesAcesso = "
		SELECT
			A.acessoUnidade, U.UNID_Nome
		FROM
			tblAcessos A INNER JOIN
			dbSiIAG.dbSiIAG.tbl_Unidades U ON A.acessoUnidade = U.UNID_Codigo
		GROUP BY 
			A.acessoUnidade, U.UNID_Nome
		ORDER BY 
			U.UNID_Nome
	";

*/


?>