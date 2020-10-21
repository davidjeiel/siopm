<?php 

	class HabilitacoesContatosDAO extends GenericDAO {
   
		public function __construct($em){
			parent::__construct($em, "HabilitacoesContatos");
		}

		public function listAll(){

			$sql = "SELECT * FROM tblHabilitacoesContatos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;			
		}

		public function findByHabContatoID($id){

			$sql = "SELECT * FROM tblHabilitacoesContatos WHERE HABCONTATOID = :habcontatoid";
			$arr = parent::getSingleResultArray($sql, array(":habcontatoid" => $id));
			if ($arr === null) $arr = array();
			return $arr;			
		}

		public function findByHabilitacaoID($id){

			$sql = "SELECT * FROM tblHabilitacoesContatos WHERE HABILITACAOID = :habilitacaoid";
			$arr = parent::getSingleResultArray($sql, array(":habilitacaoid" => $id));
			if ($arr === null) $arr = array();
			return $arr;			
		}

		public function findByContatoID($id){

			$sql = "SELECT * FROM tblHabilitacoesContatos WHERE CONTATOID = :contatoid";
			$arr = parent::getSingleResultArray($sql, array(":contatoid" => $id));
			if ($arr === null) $arr = array();
			return $arr;			
		}


	}

?>