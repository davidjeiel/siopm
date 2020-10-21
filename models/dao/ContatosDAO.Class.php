<?php 

	class ContatosDAO extends GenericDAO {
   
		public function __construct($em){
			parent::__construct($em, "Contatos");
		}

		public function listAll(){

			$sql = "SELECT * FROM tblContatos";
			$arr = parent::getListArray($sql, array());
			if ($arr === null) $arr = array();
			return $arr;			
		}

		public function findByContatoID($id){

			$sql = "SELECT * FROM tblContatos WHERE CONTATOID = :contatoid";
			$arr = parent::getSingleResultArray($sql, array(":contatoid" => $id));
			if ($arr === null) $arr = array();
			return $arr;			
		}

		public function findByContatoNome($nome){

			$sql = "SELECT * FROM tblContatos WHERE CONTATONOME = :contatonome";
			$arr = parent::getSingleResultArray($sql, array(":contatonome" => $nome));
			if ($arr === null) $arr = array();
			return $arr;			
		}

		public function findByContatoEmail($email){

			$sql = "SELECT * FROM tblContatos WHERE CONTATOEMAIL = :contatoemail";
			$arr = parent::getSingleResultArray($sql, array(":contatonome" => $email));
			if ($arr === null) $arr = array();
			return $arr;			
		}

		public function findByContatoFone1($fone1){

			$sql = "SELECT * FROM tblContatos WHERE CONTATOFONE1 = :contatofone1";
			$arr = parent::getSingleResultArray($sql, array(":contatofone1" => $fone1));
			if ($arr === null) $arr = array();
			return $arr;			
		}

		public function findByContatoFone2($fone2){

			$sql = "SELECT * FROM tblContatos WHERE CONTATOFONE1 = :contatofone2";
			$arr = parent::getSingleResultArray($sql, array(":contatofone1" => $fone2));
			if ($arr === null) $arr = array();
			return $arr;			
		}

		public function findByContatoObs($contatoobs){

			$sql = "SELECT * FROM tblContatos WHERE CONTATOFONE1 = :contatoobs";
			$arr = parent::getSingleResultArray($sql, array(":contatoobs" => $contatoobs));
			if ($arr === null) $arr = array();
			return $arr;			
		}

	}

?>
