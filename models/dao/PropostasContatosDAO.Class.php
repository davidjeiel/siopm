<?php 

	//include_once $_SERVER['DOCUMENT_ROOT'] . '/<site>/model/vo/PropostasContatos.Class.php';

	class PropostasContatosDAO extends GenericDAO {

		public function __construct($em){
			parent::__construct($em, "PropostasContatos");
		}

		public function listAll(){
			$sql = "SELECT * FROM tblPropostasContatos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

		public function listAllContatosByPropostaID($id){
			$sql = "SELECT PC.PropostaContatoID, PC.PropostaID, C.* FROM tblPropostasContatos As PC 
					INNER JOIN tblContatos As C ON PC.ContatoID = C.ContatoID 
					WHERE PC.PropostaID = $id";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;
		}

	}

?>