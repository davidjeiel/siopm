<?php 

	class InstrumentosDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "Instrumentos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblInstrumentos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listAllAtivas(){

			$sql ="SELECT h.InstrumentoID, h.InstrumentoCodigoSIOPM, h.InstrumentoCodigoCetip, h.InstrumentoDataSubscricao, h.InstrumentoValorSubscricao,
	   				ie.EntidadeID, ie2.EntidadeID, e.EntidadeNomeFantasia as Emissora, e2.EntidadeNomeFantasia as Cedente 
					FROM tblInstrumentos h INNER JOIN			
				    tblInstrumentosEntidades ie ON ie.InstrumentoID = h.InstrumentoID INNER JOIN			
				    tblInstrumentosEntidades ie2 ON ie2.InstrumentoID = h.InstrumentoID INNER JOIN
					tblEntidades e on ie.EntidadeID = e.EntidadeID INNER JOIN
					tblEntidades e2 on ie2.EntidadeID = e2.EntidadeID

				WHERE (h.InstrumentoAtivo = 1) and ie.EntidadePapelID = 1 and ie2.EntidadePapelID = 3";

			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
			
		}

		public function findByID($id){

			$sql ="SELECT i.*, m.ModalidadeNome, m.ModalidadeSetor, sb.InstrumentoSubtipoNome,
						s.InstrumentoSituacaoNome, ind.IndexadorNome, m.ModalidadeNome, r.InstrumentoRegistroDataCVM, r.InstrumentosLiquidacaoTipoID,
						r.InstrumentoRegistroEsforcoRestrito, r.InstrumentoRegistroCVM, r.InstrumentoRegistroID
									
					FROM tblInstrumentos i INNER JOIN			
						    tblModalidades m ON m.ModalidadeID = i.ModalidadeID LEFT JOIN			
						    tblInstrumentosSubtipos sb ON sb.InstrumentoSubtipoID = i.InstrumentoSubtipoID LEFT JOIN
							tblInstrumentosSituacoes s ON s.InstrumentoSituacaoID = i.InstrumentoSituacaoID LEFT JOIN
							tblIndexadores ind ON ind.IndexadorID = i.IndexadorID LEFT JOIN
							tblInstrumentosRegistros r ON i.InstrumentoID =r.InstrumentoID
					WHERE (i.InstrumentoAtivo = 1) and i.InstrumentoID = $id";

			$arr = parent::getSingleResultArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
			
		}
		
	}

?>