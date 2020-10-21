<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/Ativos.Class.php';

	class AtivosDAO extends GenericDAO {

		const PAPEL_EMISSOR = 1;
		const PAPEL_CEDENTE = 3;
		const SQLBASEATIVO = "SELECT  pp.PropostaDetalheID, p.PropostaID, p.PropostaNumero, a.AtivoID, a.AtivoCodigoSIOPM, a.AtivoCodigoCetip, a.AtivoDataEmissao, a.AtivoVolume, a.AtivoDataFinalizacao,
			[Custodiante] =  a.AtivoCodigoBmfBovespa + a.AtivoCodigoCetip,
			[Subscricao] = (SELECT MIN(s.SubscricoesData) FROM tblSubscricoes s WHERE s.AtivoID = a.AtivoID),
			[Status] = (SELECT (st.AtivoSituacaoNome) FROM tblAtivosSituacoes st WHERE st.AtivoSituacaoID = a.AtivoSituacaoID),
			[VolumeSubscrito] = (SELECT SUM(s.SubscricoesVolume) FROM tblSubscricoes s WHERE s.AtivoID = a.AtivoID),
			[Emissor] = (SELECT TOP 1 e.EntidadeNomeFantasia from tblEntidades as e INNER JOIN tblAtivosEntidades as ae on ae.EntidadeID = e.EntidadeID
				WHERE ae.AtivoID = a.AtivoID AND (ae.EntidadePapelID = :emissor)),											[Cedentes] = (SELECT c.Cedentes FROM
					(SELECT t.AtivoID, STUFF(
						(SELECT ';' + CONVERT(varchar, r.EntidadeNomeFantasia) 
						FROM tblEntidades r INNER JOIN tblAtivosEntidades s ON s.EntidadeID = r.EntidadeID
						WHERE s.AtivoID = t.AtivoID AND s.EntidadePapelID = :cedente AND t.AtivoID = a.AtivoID
						FOR XML PATH('')),1,1,'') AS Cedentes
					FROM tblAtivosEntidades AS t
					GROUP BY t.AtivoID HAVING  t.AtivoID = a.AtivoID) AS c)
			FROM tblAtivos as a LEFT JOIN
			tblPropostas as p ON p.PropostaID = a.PropostaID LEFT JOIN
			tblPropostasDetalhes as pp ON p.PropostaID = pp.PropostaID
			WHERE (a.AtivoAtivo = 1) and (pp.PropostaFaseID = 2)";

		public function __construct($em){
			parent::__construct($em, "Ativos");
		}		

		public function listAllAtivasCRIEventos(){
			$sql = "SELECT  a.AtivoID, a.AtivoCodigoSIOPM, a.AtivoCodigoCetip, a.AtivoDataEmissao, a.AtivoVolume, a.AtivoDataFinalizacao,
						[Custodiante] =  a.AtivoCodigoBmfBovespa + a.AtivoCodigoCetip,
						[Subscricao] = (SELECT MIN(s.SubscricoesData) FROM tblSubscricoes s WHERE s.AtivoID = a.AtivoID),
						[Status] = (SELECT (st.AtivoSituacaoNome) FROM tblAtivosSituacoes st WHERE st.AtivoSituacaoID = a.AtivoSituacaoID),
						[SaldoDevedor] = (SELECT top 1 (sd.SaldoDevedor) FROM tblTransacoes sd WHERE sd.AtivoID = a.AtivoID order by TransacaoData desc),
						[VolumeSubscrito] = (SELECT SUM(s.SubscricoesVolume) FROM tblSubscricoes s WHERE s.AtivoID = a.AtivoID),
						[VolumeAmortizado] = ((SELECT SUM(s.SubscricoesVolume) FROM tblSubscricoes s WHERE s.AtivoID = a.AtivoID)-(SELECT top 1 (sd.SaldoDevedor) FROM tblTransacoes sd WHERE sd.AtivoID = a.AtivoID order by TransacaoData desc)),
						[PercentualAmortizado] = (((SELECT SUM(s.SubscricoesVolume) FROM tblSubscricoes s WHERE s.AtivoID = a.AtivoID)-(SELECT top 1 (sd.SaldoDevedor) FROM tblTransacoes sd WHERE sd.AtivoID = a.AtivoID order by TransacaoData desc))/(SELECT SUM(s.SubscricoesVolume) FROM tblSubscricoes s WHERE s.AtivoID = a.AtivoID)*100)
						
					FROM tblAtivos as a
					WHERE (a.AtivoAtivo = 1)"; 
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listAtivosEntidadesByPapel($id){
			$sql = "SELECT DISTINCT e.EntidadeID, ep.EntidadePapelID,  e.EntidadeNomeFantasia, ep.EntidadePapelNome 
					FROM tblAtivosEntidades AS ae 
					INNER JOIN tblEntidades AS e ON ae.EntidadeID = e.EntidadeID 
					INNER JOIN tblEntidadesPapeis ep ON ae.EntidadePapelID = ep.EntidadePapelID 
					INNER JOIN tblAtivos AS a ON ae.AtivoID = a.AtivoID
					WHERE (a.AtivoDataFinalizacao > 0)  AND ae.EntidadePapelID = $id "; 
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listAllAtivasCRIFinalizadas(){
			$sql = self::SQLBASEATIVO . " and  (NOT a.AtivoDataFinalizacao IS NULL )";//Modalidade 1 = CRI Tradicional // Papel 1 = Emissora // Papel 3 = Cedente
			$arr = parent::getListArray($sql, array(":emissor" => self::PAPEL_EMISSOR, ":cedente" => self::PAPEL_CEDENTE));
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listarEntidadesAtivosByPapel($id){
			$EntidadesDAO = new EntidadesDAO(parent::getEm());
			$sql = "SELECT t.Entidades, STUFF(
				(SELECT ',' + CONVERT(varchar, s.AtivoID)
				FROM (
					SELECT t.AtivoID, STUFF(
					(SELECT ',' + CONVERT(varchar, s.EntidadeID)
					FROM tblAtivosEntidades s
					WHERE s.AtivoID = t.AtivoID AND s.EntidadePapelID = $id
					FOR XML PATH('')),1,1,'') AS Entidades
					FROM tblAtivosEntidades AS t INNER JOIN tblAtivos AS a ON t.AtivoID =  a.AtivoID AND a.AtivoAtivo = 1 
					GROUP BY t.AtivoID
				) s
				WHERE s.Entidades = t.Entidades 
				FOR XML PATH('')),1,1,'') AS Ativos
				FROM (
					SELECT t.AtivoID, STUFF(
					(SELECT ',' + CONVERT(varchar, s.EntidadeID)
					FROM tblAtivosEntidades s
					WHERE s.AtivoID = t.AtivoID AND s.EntidadePapelID = $id
					FOR XML PATH('')),1,1,'') AS Entidades
					FROM tblAtivosEntidades AS t INNER JOIN tblAtivos AS a ON t.AtivoID =  a.AtivoID AND a.AtivoAtivo = 1 
					GROUP BY t.AtivoID
				) AS t
				GROUP BY t.Entidades
				HAVING NOT Entidades IS NULL";

			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();

			if (isset($arr)) foreach ($arr as &$value) {
				$entidades = "";
				$entidadeIDs = explode(",", $value["Entidades"]);
				
				foreach ($entidadeIDs as $EntidadeID) {
					$nome = $EntidadesDAO->getEntidadeNomeFantasiaByID($EntidadeID);
					if ($entidades == "") $entidades = $nome;
					else $entidades .= "<br>$nome";
				}			
				$value["EntidadesNomes"] = $entidades;
			}
			
			return $arr;

		}		

		public function listAllFinalizados(){
			$sql = "SELECT * FROM tblAtivos WHERE (AtivoAtivo = 1) AND (NOT AtivoDataFinalizacao IS NULL) ";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listAll(){
			$sql = "SELECT * FROM tblAtivos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function getCountAtivoByModalidadeID($id){
			$sql = "SELECT count(AtivoID) as TOTATIVO FROM tblAtivos WHERE ModalidadeID = $id";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null || !isset($arr["TOTATIVO"])) return 0; else return $arr["TOTATIVO"];
		}

		public function listAllAtivasCRI(){
			$sql = self::SQLBASEATIVO; //Modalidade 1 = CRI Tradicional // Papel 1 = Emissora // Papel 3 = Cedente
			$arr = parent::getListArray($sql, array(":emissor" => self::PAPEL_EMISSOR, ":cedente" => self::PAPEL_CEDENTE));
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listByModadlidade($Modalidade){
			$sql = "SELECT * FROM tblAtivos WHERE ModalidadeID = $Modalidade";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findByID($id){
			$sql = "SELECT pp.PropostaDetalheID, a.*, m.*, sb.*, s.*, ind.*, m.*, r.AtivoRegistroID, r.AtivoRegistroDataCVM, r.AtivoLiquidacaoTipoID, 
						r.AtivoRegistroEsforcoRestrito, r.AtivoRegistroCVM									
					FROM tblAtivos a LEFT JOIN
						    tblModalidades m ON m.ModalidadeID = a.ModalidadeID LEFT JOIN			
						    tblAtivosSubtipos sb ON sb.AtivoSubtipoID = a.AtivoSubtipoID LEFT JOIN
							tblAtivosSituacoes s ON s.AtivoSituacaoID = a.AtivoSituacaoID LEFT JOIN
							tblIndexadores ind ON ind.IndexadorID = a.IndexadorID LEFT JOIN
							tblAtivosRegistros r ON a.AtivoID = r.AtivoID LEFT JOIN
							tblPropostas as p ON p.PropostaID = a.PropostaID LEFT JOIN
							tblPropostasDetalhes as pp ON p.PropostaID = pp.PropostaID
					WHERE a.AtivoID = $id and (pp.PropostaFaseID = 2)";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function procurarPorCodigoCetip($codigoCetip){
			$sql = "SELECT a.AtivoID FROM tblAtivos AS a
					WHERE AtivoCodigoCetip = '$codigoCetip'";
			$vo = parent::getVO($sql, array());
			if ($vo === null) return null;
			return $vo->getAtivoID();
		}

		public function findByCodigoCetip($codigoCetip, $id){
			$sql = "SELECT a.AtivoID, a.AtivoCodigoCetip, a.AtivoCodigoBmfBovespa, a.AtivoCodigoSIOPM, a.AtivoCodigoIsin FROM tblAtivos AS a
					WHERE AtivoCodigoCetip = '$codigoCetip' AND a.AtivoID <> $id";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listarAtivos(){
			$sql = "SELECT DISTINCT AtivoID FROM tblAtivos";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}	


		public function findByCodigoBmfBovespa($CodigoBmfBovespa, $id){
			$sql = "SELECT a.AtivoID, a.AtivoCodigoCetip, a.AtivoCodigoBmfBovespa, a.AtivoCodigoSIOPM, a.AtivoCodigoIsin FROM tblAtivos AS a
					WHERE AtivoCodigoBmfBovespa = '$CodigoBmfBovespa' AND a.AtivoID <> $id";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function findByCodigoIsin($CodigoIsin, $id){
			$sql = "SELECT a.AtivoID, a.AtivoCodigoCetip, a.AtivoCodigoBmfBovespa, a.AtivoCodigoSIOPM, a.AtivoCodigoIsin FROM tblAtivos AS a
					WHERE AtivoCodigoIsin = '$CodigoIsin' AND a.AtivoID <> $id";
			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listOrcamentoPorCRI($anoInicial,$anoFinal){
			// $sql = "SELECT  O.OrcamentoAno, O.OrcamentoSaldoInicial, A.AtivoCodigoSIOPM,
			// 	             [Custodiante] =  a.AtivoCodigoBmfBovespa + a.AtivoCodigoCetip, --P.ValorAprovadoGEFOM, 
			// 	             P_Orcamento = P.ValorAprovadoGEFOM/O.OrcamentoSaldoInicial*100, 
			// 	             [Aplicado] = (SELECT SUM(s.SubscricoesVolume) FROM tblSubscricoes s WHERE s.AtivoID = a.AtivoID),
			// 	             P_Aplicado = (SELECT SUM(s.SubscricoesVolume) FROM tblSubscricoes s WHERE s.AtivoID = a.AtivoID)/P.ValorAprovadoGEFOM*100,
			// 	             Saldo = O.OrcamentoSaldoInicial-(SELECT SUM(s.SubscricoesVolume) FROM tblSubscricoes s WHERE s.AtivoID = a.AtivoID)
			// 	       FROM tblAtivos AS A
			// 	       INNER JOIN tblPropostas P ON P.PropostaID = A.PropostaID
			// 	       INNER JOIN tblOrcamentos AS O ON O.OrcamentoID = P.OrcamentoID
			// 	       INNER JOIN tblSubscricoes as S ON s.AtivoID = A.AtivoID
			// 		WHERE O.OrcamentoAno BETWEEN $anoInicial AND $anoFinal 
			// 		ORDER BY O.OrcamentoAno, A.AtivoCodigoSIOPM";


			$sql= "SELECT	O.OrcamentoAno, O.OrcamentoSaldoInicial, A.AtivoCodigoSIOPM,
					[Custodiante] =  a.AtivoCodigoBmfBovespa + a.AtivoCodigoCetip,-- P.ValorAprovadoGEFOM, 
					[Volume] =  (SELECT SUM(I.IntegralizacaoVolume) FROM tblIntegralizacoes I WHERE S.SubscricoesID = I.SubscricoesID)
					--,[Aplicado] = (SELECT SUM(s.SubscricoesVolume) FROM tblSubscricoes s WHERE s.AtivoID = a.AtivoID)
					FROM tblAtivos AS A
					INNER JOIN tblPropostas P ON P.PropostaID = A.PropostaID
					INNER JOIN tblOrcamentos AS O ON O.OrcamentoID = P.OrcamentoID
					INNER JOIN tblSubscricoes AS S ON s.AtivoID = A.AtivoID 
					WHERE O.OrcamentoAno BETWEEN $anoInicial AND $anoFinal 
			 		ORDER BY O.OrcamentoAno, A.AtivoCodigoSIOPM ";

			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listOrcamentoPorTipo($entidadePapelID, $anoInicial,$anoFinal){


			// $sql = "SELECT  O.OrcamentoAno, O.OrcamentoSaldoInicial, E.EntidadeNomeFantasia, --P.ValorAprovadoGEFOM,
			// 		             P_Orcamento = P.ValorAprovadoGEFOM/O.OrcamentoSaldoInicial*100, 
			// 		             [Aplicado] = (SELECT SUM(s.SubscricoesVolume) FROM tblSubscricoes s WHERE s.AtivoID = a.AtivoID),
			// 		             P_Aplicado = (SELECT SUM(s.SubscricoesVolume) FROM tblSubscricoes s WHERE s.AtivoID = a.AtivoID)/P.ValorAprovadoGEFOM*100,
			// 		             Saldo = O.OrcamentoSaldoInicial-(SELECT SUM(s.SubscricoesVolume) FROM tblSubscricoes s WHERE s.AtivoID = a.AtivoID)
			// 		       FROM tblAtivos AS A 
			// 		       INNER JOIN tblPropostas P ON P.PropostaID = A.PropostaID
			// 		       INNER JOIN tblOrcamentos AS O ON O.OrcamentoID = P.OrcamentoID
			// 		       INNER JOIN tblSubscricoes AS S ON s.AtivoID = A.AtivoID 
			// 		       INNER JOIN tblAtivosEntidades AS AE ON AE.AtivoID = A.AtivoID
			// 		       INNER JOIN tblEntidades AS E ON AE.EntidadeID = E.EntidadeID
			// 		WHERE AE.EntidadePapelID = $entidadePapelID AND O.OrcamentoAno BETWEEN $anoInicial AND $anoFinal
			// 		ORDER BY O.OrcamentoAno"; 

				// $sql = "SELECT  O.OrcamentoAno, O.OrcamentoSaldoInicial, E.EntidadeNomeFantasia, --P.ValorAprovadoGEFOM, 
				// 	[Volume] =  (SELECT SUM(I.IntegralizacaoVolume) FROM tblIntegralizacoes I WHERE S.SubscricoesID = I.SubscricoesID) 
				// 	--,[Aplicado] = (SELECT SUM(s.SubscricoesVolume) FROM tblSubscricoes s WHERE s.AtivoID = a.AtivoID)
				// 	       FROM tblAtivos AS A 
				// 	       INNER JOIN tblPropostas P ON P.PropostaID = A.PropostaID
				// 	       INNER JOIN tblOrcamentos AS O ON O.OrcamentoID = P.OrcamentoID
				// 	       INNER JOIN tblSubscricoes AS S ON s.AtivoID = A.AtivoID 
				// 	       INNER JOIN tblAtivosEntidades AS AE ON AE.AtivoID = A.AtivoID
				// 	       INNER JOIN tblEntidades AS E ON AE.EntidadeID = E.EntidadeID
				// 	WHERE AE.EntidadePapelID = $entidadePapelID AND O.OrcamentoAno BETWEEN $anoInicial AND $anoFinal
				// 	ORDER BY O.OrcamentoAno";

				$sql = "SELECT extern.OrcamentoAno, Sub.SubscricoesID, extern.OrcamentoSaldoInicial
					, [Volume] = (SELECT SUM(I.IntegralizacaoVolume) FROM tblIntegralizacoes I WHERE Sub.SubscricoesID = I.SubscricoesID) 
					, LEFT(EntidadeNomeFantasia , LEN(EntidadeNomeFantasia )-1) AS EntidadeNomeFantasia
					FROM (SELECT O.OrcamentoAno, A.AtivoID, O.OrcamentoSaldoInicial
							FROM tblOrcamentos as O INNER JOIN
							tblPropostas as P ON O.OrcamentoID = P.OrcamentoID INNER JOIN
							tblAtivos as A ON P.PropostaID = A.PropostaID INNER JOIN
							tblAtivosEntidades as AE ON A.AtivoID = AE.AtivoID INNER JOIN
							tblEntidades as E ON AE.EntidadeID = E.EntidadeID
							WHERE AE.EntidadePapelID = $entidadePapelID AND O.OrcamentoAno BETWEEN $anoInicial AND $anoFinal) AS extern
					CROSS APPLY
					(
					    SELECT EntidadeNomeFantasia + ' + ' 
					    FROM 
							(SELECT A.AtivoID, E.EntidadeNomeFantasia
							FROM tblOrcamentos as O INNER JOIN
							tblPropostas as P ON O.OrcamentoID = P.OrcamentoID INNER JOIN
							tblAtivos as A ON P.PropostaID = A.PropostaID INNER JOIN
							tblAtivosEntidades as AE ON A.AtivoID = AE.AtivoID INNER JOIN
							tblEntidades as E ON AE.EntidadeID = E.EntidadeID
							WHERE AE.EntidadePapelID = $entidadePapelID AND O.OrcamentoAno BETWEEN $anoInicial AND $anoFinal) AS intern
					    WHERE extern.AtivoID = intern.AtivoID
					    FOR XML PATH('')
					) pre_trimmed (EntidadeNomeFantasia)
					INNER JOIN tblSubscricoes AS Sub ON Sub.AtivoID = extern.AtivoID 
					GROUP BY extern.OrcamentoAno, Sub.SubscricoesID, extern.OrcamentoSaldoInicial, EntidadeNomeFantasia";	

			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;

		}

	}

?>