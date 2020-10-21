<?php

	class GenericDAO {

		private $em;
		private $class = "";

		public function __construct($em, $class = ""){
			$this->em = $em;
			$this->class = $class;
		}

		public function getEm(){
			return $this->em;
		}
		
		public function insert($vo, $candidateKeys = null, $saveOnlyNotNull = false, $viewSql = false){
			
			return $this->em->insert($vo, $candidateKeys, $saveOnlyNotNull, $viewSql);
		}

		public function update($vo, $candidateKeys = null, $saveOnlyNotNull = false, $viewSql = false){
			return $this->em->update($vo, $candidateKeys, $saveOnlyNotNull, $viewSql);
		}

		public function persist($vo, $candidateKeys = null, $saveOnlyNotNull = false, $viewSql = false){
			return $this->em->save($vo, $candidateKeys, $saveOnlyNotNull, $viewSql);
		}

		public function delete($vo, $viewSql = false){
			$this->em->delete($vo, $viewSql);
		}

		public function deleteByID($id){
			$this->em->delete($this->find($id));
		}

		public function find($id, $class = ""){
			if ($class == "") $class = $this->class;
			return $this->em->find($class, $id);
		}

		public function fillEntityByRequest($request, $class = ""){
			if ($class == "") $class = $this->class;
			return $this->em->fillEntityByRequest($class, $request);
		}

		public function getVO($consulta, $parametros = array(), $class = ""){
			if ($class == "") $class = $this->class;
			$q = $this->buildQuery($consulta, $parametros, $class);
			return $q->getSingleResult();
		}

		public function getList($consulta, $parametros = array(), $class = ""){
			if ($class == "") $class = $this->class;
			$q = $this->buildQuery($consulta, $parametros, $class);
			return $q->getList();
		}

		public function getListArray($consulta, $parametros = array(), $class = ""){
			if ($class == "") $class = $this->class;
			$q = $this->buildQuery($consulta, $parametros, $class);
			return $q->getListArray();
		}

		public function getSingleResultArray($consulta, $parametros = array(), $class = ""){
			if ($class == "") $class = $this->class;
			$q = $this->buildQuery($consulta, $parametros, $class);
			return $q->getSingleResultArray();
		}

		public function getListArrayPagination($consulta, $parametros = array(), array $ordenacao, $pag_atual = 1, $itens_por_pagina = 10, &$total_registros = null){
			$q = new PPOQuery($this->em->getConnection());
			return $q->getListArrayPagination($consulta, $parametros, $ordenacao, $pag_atual, $itens_por_pagina, $total_registros);
		}

		public function execute($consulta, $paramentros = array()){
			$sql = $this->getSQL($consulta, $paramentros);
    		return $this->em->execute($sql);
    	}

		public function getSql($consulta, $parametros = array(), $class = ""){
			if ($class == "") $class = $this->class;
			$q = $this->buildQuery($consulta, $parametros, $class);
			return $q->getSql();
		}

		private function buildQuery($consulta, $parametros, $class){
			if ($class == "") $class = $this->class;
			$q = $this->em->createQuery($class, $consulta);
			foreach($parametros as $indice => $valor){
				$q->setParameter($indice, $valor);
			}
			return $q;
		}
	}

?>