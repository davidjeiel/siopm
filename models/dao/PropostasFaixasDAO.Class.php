<?php 

	class PropostasFaixasDAO extends GenericDAO {
   
		public function __construct($em){
			parent::__construct($em, "PropostasFaixas");
		}

		public function listAllVigentes(){

			$sql = "SELECT     pf.PropostaFaixaID, pf.PropostaFaixaTipoID, pf.ValorMinimo, pf.ValorMaximo, 
								pf.TaxaJurosNominal, pf.TaxaJurosEfetiva, pft.PropostaFaixaTipoNome
					FROM         tblPropostasFaixas as pf
					INNER JOIN tblPropostasFaixasTipos as pft ON pf.PropostaFaixaTipoID = pft.PropostaFaixaTipoID
					WHERE     (
								PropostaFaixaID IN
					                          (
					                          	SELECT PropostaFaixaTipoID
					                            FROM (
					                            		SELECT DISTINCT PropostaFaixaTipoID, MAX(PropostaFaixaIniVigencia) AS PropostaFaixaIniVigencia
					                                    FROM tblPropostasFaixas AS tblPropostasFaixas_1
					                                    GROUP BY PropostaFaixaTipoID
					                                 ) AS derivedtbl_Faixas
											   )
								)";

			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
			
		}

	}

?>