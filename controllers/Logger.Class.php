<?php

class Logger {

	const INCLUSAO = 1;
	const ALTERACAO = 2;
	const EXCLUSAO = 3;

	private $em = null;
	private $user = null;
	private $logDAO = null;
	private $logModuloDAO = null;
	private $tabelasModulosDAO = null;
	
	private $tipoLog = null;
	private $agrupar = true;
	private $lastGroupID = 0;
	private $entidadeAnterior = null;

	public function __construct($em, $user){
		$this->em = $em;
		$this->user = $user;
		$this->logDAO = new LogDAO($em);
		$this->logModuloDAO = new LogModuloDAO($em);
		$this->tabelasModulosDAO = new LogTabelasModulosDAO($em);			
	}

	public function novoGrupo(){
		$this->lastGroupID = 0;
	}

	public function agrupar(){
		$this->agrupar = true;
	}

	public function desagrupar(){
		$this->agrupar = false;
		$this->lastGroupID = 0;
	}

	public function prepararLog($entidade){
		$this->tipoLog = null;
		$class = get_class($entidade);
		$id = ($entidade->{'get'.$class::COLUMN_KEY}()>0) ? $entidade->{'get'.$class::COLUMN_KEY}() : 0; 
		if ($id > 0) {
			$this->entidadeAnterior = $this->em->find($class, $id);
			$this->tipoLog = self::ALTERACAO; 
		}else{
			$this->entidadeAnterior = new $class;
			$this->tipoLog = self::INCLUSAO; 
		}
	}

	public function logar($entidade){
		if ($this->entidadeAnterior == null || $this->tipoLog == null){
			throw new Exception("O Log não foi preparado adequadamente! Prepare o log, informando a entidade antes de salvar as aletrações.");	
		}
		$this->log($entidade);
	}

	public function logarExclusao($entidade){
		$this->tipoLog = self::EXCLUSAO;
		$this->log($entidade);
	}

	private function montarJSON($entidade){
		$logArray = array();
		$classe = get_class($entidade);
		$metodos = get_class_methods($classe);
		foreach ($metodos as $metodo) {
			if (substr($metodo,0,3) == 'get'){
				if ($this->tipoLog == self::ALTERACAO){
					$de 	= $this->entidadeAnterior->{$metodo}();
					$para 	= $entidade->{$metodo}();
					if ($this->entidadeAnterior->{$metodo}() != $entidade->{$metodo}() || 'get'.$classe::COLUMN_KEY == $metodo){
						$logArray["DE"][$classe][substr($metodo,3,strlen($metodo))] = $this->entidadeAnterior->{$metodo}();
						$logArray["PARA"][$classe][substr($metodo,3,strlen($metodo))] = $entidade->{$metodo}();
					}
				}
				if ($this->tipoLog == self::INCLUSAO){
					$logArray["NOVO"][$classe][substr($metodo,3,strlen($metodo))] = $entidade->{$metodo}();
				}
				if ($this->tipoLog == self::EXCLUSAO){
					$logArray["EXCLUSAO"][$classe][substr($metodo,3,strlen($metodo))] = $entidade->{$metodo}();
				}
			}
		}
		return json_encode($logArray);
	}

	private function log($entidade){
		if ($this->tipoLog == null) throw new Exception("Não foi indicado o tipo de LOG");
		$tabelaModulo = $this->tabelasModulosDAO->find($entidade::TABLE_NAME);
		$modulo = $this->logModuloDAO->find($tabelaModulo->getModulo());
		$fkValue = (method_exists ($entidade , 'get'.$modulo->getChavePrimaria())) ? $entidade->{'get'.$modulo->getChavePrimaria()}() : 0;
		$log = new Log();
		$log->setGrupo(0);
		$log->setTipo($this->tipoLog);
		$log->setModulo($modulo->getID());
		$log->setMatricula( $this->user->getUsuarioMatricula() );
		$log->setDataHora( date('Y-m-d H:i:s') );
		$log->setFKValue($fkValue);
		$log->setConteudo($this->montarJSON($entidade));
		$log->setID((int)$this->logDAO->insert($log));
		if ($this->agrupar && $this->lastGroupID > 0){
			$log->setGrupo($this->lastGroupID);
		}else{
			$log->setGrupo($log->getID());
			$this->lastGroupID = $log->getID();
		}
		$this->logDAO->update($log);	
	}
	
}
	
?>