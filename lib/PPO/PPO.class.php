<?php

/**
 * Provê o acesso a um banco de dados SQL Server através do mapeamento Objeto Realacional.
 * Esse método torna cada tupla de uma tabela em um objeto que pode ser manipulado. 
 * PPO - PHP Persistent Objects
 * @author Alan Ferreira de Lima Filho
 * @author C066868
 * @author alanflima@hotmail.com
 */

 error_reporting(E_ALL);
 ini_set('display_errors', 1);

interface PPO{
	const FETCH_NAMED = 11;
	const FETCH_NUM = 3;
	const FETCH_BOTH = 4;
	const FETCH_ASSOC = PDO::FETCH_ASSOC;
	public function toString();
	public function toHash();
}
abstract class PPOEntity implements PPO{

	public static function toTime($date, $mask='H:i:s'){
		return self::toDateFmt($date, $mask);
	}

	public static function toDateBr($date, $mask='d/m/Y H:i:s'){
		return self::toDateFmt($date, $mask);
	}
	
	public static function toDateUnicode($date, $mask = 'Y-m-d H:i:s'){
		return self::toDateFmt($date, $mask);
	}
	
	private static function toDateFmt($date, $mask) {
		if ($date == "") return $date;
		if ( !is_null($date) ){
			// Dates in the m/d/y or d-m-y formats are disambiguated by looking at the separator 
			// between the various components: if the separator is a slash (/), then the 
			// American m/d/y is assumed; whereas if the separator is a dash (-) or a dot (.), 
			// then the European d-m-y format is assumed.
			return Date($mask, strtotime(str_replace('/','-',$date)));
		}else{
			new Exception("Deve-se informar uma data/horário válido para a conversão!");
		}
	}

	public static function toMoneyBr($value, $casas = 2){
		if ($value == null or $value == "0,00" or  $value == "0.00") $value = 0; 
		$value = floatval ($value);
		return number_format($value, $casas, ',', '.'); 
	}

	public static function toMoneyOitoCasasDecimais($valor) {
		$div = explode(".", $valor);
		return number_format($div[0]+0, 0, ",", ".") . "," . $div[1];
	}

	public static function toMoneyUnicode($value, $casas = 2){
		if ($value == null or $value == "0,00" or  $value == "0.00") $value = 0; 		
		return number_format($value, $casas, '.', ',');   
	}

	public static function toFloatBr($value, $casas = 9){
		if ($value == null or $value == "0,00" or  $value == "0.00") $value = 0; 
		return number_format($value, $casas, ',', '.'); 
	}

	public static function toFloatUnicode($value, $casas = 9){
		if ($value == null or $value == "0,00" or  $value == "0.00") $value = 0;
		return number_format($value, $casas, '.', ','); 
	}
		
}
/**
 * 
 * Prove conexão com o banco de dados ...
 * @author Alan Ferreira de Lima Filho
 *
 */
class PPOConnection{

	const _ADO_MSSQL 				= "ado_mssql";
	const _ADO_EXCEL 				= "ado_excel";
	const _ADO_MDB   				= "ado_mdb";
	const _ADO_ACCESS   			= "ado_access";
	const _PDO_MSSQL 				= "mssql";
	const _PDO_MSSQLSRV 			= "pdo_sqlsrv";
	const _PDO_MYSQL 				= "mysql";
	const _PDO_PGSQL 				= "pgsql";
	const _PDO_MSSQL_ODBC 			= "pdo_mssql_odbc";
	const _ADO_MSSQL_EXPRESS_2012 	= "ado_mssql_express_2012";

	private $con;
	private $driver = '';
	private $host = '';
	private $port = '';
	private $database = '';
	private $username = '';
	private $password = '';	
	private $dsn = '';
	private $persistent  = false;


	/**
	 * Contrutor padrao
	 * Enter description here ...
	 * @param string $driver
	 * @param string $host
	 * @param string $database
	 * @param string $username
	 * @param string $password
	 * @param string $port
	 * @param string $persistent
	 */
	public function __construct($driver, $host, $database, $username, $password, $port = "", $persistent = false){

		$this->driver 	= $driver;
		$this->host 	= $host;
		$this->port 	= $port;
		$this->database = $database;
		$this->username = $username;
		$this->password = $password;
		$this->persistent  = $persistent;

		if( $persistent != false){ $this->persistent = true; }

		switch ($this->driver) {
		
			case self::_ADO_EXCEL:
				$this->dsn = "Driver={Microsoft Excel Driver (*.xls)};DriverId=790;Dbq=$host$database;";
				//$this->dsn = "Provider='Microsoft.Jet.OLEDB.4.0';Data Source='$host$database';Extended Properties=Excel 8.0;";
				break;
			case self::_ADO_ACCESS:
				$this->dsn = "Provider=Microsoft.Jet.OLEDB.4.0;Data Source=$host$database;User Id=$username;Password=$password;";
				break;
			case self::_ADO_MDB:
		        $this->dsn = "Driver={Microsoft Access Driver (*.mdb)};Dbq=$host$database;Uid=$username;Pwd=$password";
		        break;
			case self::_ADO_MSSQL:
		        $this->dsn = "Provider=SQLOLEDB.1;Persist Security Info=True;Password=$password;User ID=$username;Initial Catalog=$database;Data Source=$host";
		        break;
	        case self::_ADO_MSSQL_EXPRESS_2012:
	        	$this->dsn = "Provider=SQLNCLI11;Password=$password;User ID=$username; Database=$database;Server=$host";
	        	//$this->dsn = "Driver={SQL Server Native Client 11.0}; Server=$host;DataBase=$database;Uid=$username;Pwd=$password";
	        	//$this->dsn = "Provider=SQLNCLI11;Persist Security Info=True;Password=$password;User ID=$username;Initial Catalog=$database;Data Source=$host";
	        	//$this->dsn = "Data Source=$host; Initial Catalog=$database; Integrated Security=True; providerName=System.Data.SqlClient; MultipleActiveResultSets=True";
	        	break;
		    case self::_PDO_MSSQL:
		    	if($port!="")$port=",".$port;
				$this->dsn = "mssql:host=$host$port;dbname=$database";
		    	break;
		    case self::_PDO_MSSQLSRV:
		    	if($port!="")$port=",".$port;
				$this->dsn = "sqlsrv:Server=$host$port;Database=$database;";
		    	break;
		    case self::_PDO_MSSQL_ODBC:
		    	if($port!="")$port=",".$port;
				$this->dsn = "odbc:Driver={SQL Server};Server=$host$port;Database=$database;";
		    	break;
		    case self::_PDO_MYSQL:
		       	$this->dsn = "mysql:host=$host;dbname=$database";
		        break;
		    default:
		    	print " OPCAO " . $this->driver . " NAO IMPLEMENTADA. ERRO: " . __FILE__ . " CLASSE: " . __CLASS__;
		}
	}	

	/**
	 * Retorna a conexao PDO ativa
	 * Enter description here ...
	 */
	public function getConnection(){
        return $this->con;
    }

    /**
     * Seta um driver
     * @param string $driver
     */
	public function setDriver($driver){
        $this->driver = $driver;
    }

    /**
     * Retorna o drive utilizado na conexao
     */
    public function getDriver(){
        return $this->driver;
    }

    /**
     * Seta o host
     * @param string $host
     */
    public function setHost($host){
        $this->host = $host;
    }
    
    /**
     * Retorna o host
     */
	public function getHost(){
        return $this->host;
    }

    /**
     * Seta a porta a utilizar
     * @param string $port
     */
	public function setPort($port){
        $this->host = $port;
    }
    
    /**
     * Retora a porta utilizada
     */
	public function getPort(){
        return $this->host;
    }
    
    /**
     * Define o nome do banco de dados
     * @param string $database
     */
	public function setDatabase($database){
        $this->database = $database;
    }
    
    /**
     * Retorna o nome do banco de dados
     */
	public function getDatabase(){
        return $this->database;
    }

    /**
     * Seta a senha utilizada na conex�o
     * @param string $password
     */
    public function setPassword($password){
        $this->password = $password;
    }
    
    /**
     * Seta o usuario do banco de dados
     * @param string $username
     */
    public function setUsername($username){
        $this->username = $username;
    }   
    
    /**
     * Retorna o usuario utilizado na conex�o
     */
    public function getUsername(){
        return $this->username;
    } 

    /**
     * Abre a conexao
     */
	public function open(){	
		$sql = "SET NAMES 'utf8'";
		try {
			switch ($this->driver) {
				case self::_ADO_EXCEL:
			    case self::_ADO_MSSQL:
				case self::_ADO_ACCESS:
				case self::_ADO_MDB:
				case self::_ADO_MSSQL_EXPRESS_2012:
			        $this->con = new COM("ADODB.Connection");
			        $this->con->Open( $this->dsn );
			        return $this->con;
			        break;
			    case self::_PDO_MSSQLSRV:
			    case self::_PDO_MSSQL:
			    case self::_PDO_MSSQL_ODBC:
			    	$this->con = new PDO($this->dsn, $this->username, $this->password);
			    	//$this->con->exec($sql);
			    	return $this->con;
			    	break;
			    case  self::_PDO_MYSQL:
			       	$this->con = new PDO($this->dsn, $this->username, $this->password, array( PDO::ATTR_PERSISTENT => $this->persistent ));
			        $this->con->exec($sql);
			        return $this->con;
			       	break;

			}
		}catch ( Exception $ex ){
			echo "Erro Em: ". __FILE__ . " Classe: " . __CLASS__ . " Msg.:" . $ex->getMessage(); 
		}
	}

	/**
	 * Fecha a conexao ativa
	 */
	public function close(){
		switch ($this->driver) {
			case self::_ADO_EXCEL:
			case self::_ADO_MSSQL:
			case self::_ADO_ACCESS:
			case self::_ADO_MDB:
			case self::_ADO_MSSQL_EXPRESS_2012:
				return $this->con->Close(); 
				break;
			default://ANY PDO DRIVER
				if( !is_null($this->con) ) { $this->con = null; }
		}	
	}

	/**
	 * Executa uma instrucao sql
	 * @param string $sql
	 */
	public function execute($sql){
		switch ($this->driver) {
			case self::_ADO_EXCEL:
			case self::_ADO_MSSQL:
			case self::_ADO_ACCESS:
			case self::_ADO_MDB:
			case self::_ADO_MSSQL_EXPRESS_2012:
				return $this->con->Execute($sql); 
				break;
			
			default://ANY PDO DRIVER
				return $this->con->exec($sql); 
		}
	}
	
	/**
	 * Inicia uma transacao com o banco de dados
	 */
	public function beginTransaction(){
		switch ($this->driver) {
			case self::_ADO_EXCEL:
			case self::_ADO_MSSQL:
			case self::_ADO_ACCESS:
			case self::_ADO_MDB:
			case self::_ADO_MSSQL_EXPRESS_2012:
				$this->con->BeginTrans();
				break;
			default://ANY PDO DRIVER
				$this->con->beginTransaction();
		}
	}
	
	/**
	 * Confirma uma transacao com o banco de dados
	 */
	public function commit(){
		switch ($this->driver) {
			case self::_ADO_EXCEL:
			case self::_ADO_MSSQL:
			case self::_ADO_ACCESS:
			case self::_ADO_MDB:
			case self::_ADO_MSSQL_EXPRESS_2012:
				$this->con->CommitTrans();
				break;
			default://ANY PDO DRIVER
				$this->con->commit();
		}
	}

	/**
	 * Cancela uma transaçcao com o banco de dados
	 */
	public function rollBack(){
		switch ($this->driver) {
			case self::_ADO_EXCEL:
			case self::_ADO_MSSQL:
			case self::_ADO_ACCESS:
			case self::_ADO_MDB:
			case self::_ADO_MSSQL_EXPRESS_2012:
				$this->con->RollBackTrans();
				break;
			default://ANY PDO DRIVER
				$this->con->rollback();
		}
	}
	
	/**
	 * Prepara uma instrucao sql. Apenas para os drives de PDO
	 * @param string $sql
	 */
    public function prepare($sql){
    	switch ($this->driver) {
    		case self::_ADO_EXCEL:
			case self::_ADO_MSSQL:
			case self::_ADO_ACCESS:
			case self::_ADO_MDB:
			case self::_ADO_MSSQL_EXPRESS_2012:
				new Exception("Metodo valido apenas para drives de tecnologia PDO! Em: " . __FILE__ . " Classe: " . __CLASS__);
				break;
			default://ANY PDO DRIVER
				return $this->con->prepare($sql);
		}
    }

    /**
     * Cria uma query a partir de uma instrucao sql. Apenas para drives do PDO.
     * @param string $string
     */
    public function query($string){
    	switch ($this->driver) {
    		case self::_ADO_EXCEL:
			case self::_ADO_MSSQL:
			case self::_ADO_ACCESS:
			case self::_ADO_MDB:
			case self::_ADO_MSSQL_EXPRESS_2012:
				new Exception("Metodo valido apenas para drives de tecnologia PDO! Em: " . __FILE__ . " Classe: " . __CLASS__);
				break;
			default://ANY PDO DRIVER
				return $this->con->query($string);
		}
    }

}

/**
 * Provê um DAO genérico para usar com o banco de dados ...
 * @author Alan Ferreira de Lima Filho
 * @author c066868
 */
class PPOGenericDAO {

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
		$q = new PPOQuery($this->em->getConnection(),"",array(),"","",$this->em->getEncode());
		return $q->getListArrayPagination($consulta, $parametros, $ordenacao, $pag_atual, $itens_por_pagina, $total_registros);
	}

	public function execute($consulta, $parametros = array()){
		$sql = $this->getSQL($consulta, $parametros);
		return $this->em->execute($sql);
	}

	public function getSql($consulta, $parametros = array(), $class = ""){
		if ($class == "") $class = $this->class;
		$q = $this->buildQuery($consulta, $parametros, $class);
		return $q->getSql();
	}

	protected function buildQuery($consulta, $parametros, $class = ""){
		if ($class == "") $class = $this->class;
		$q = $this->em->createQuery($class, $consulta);
		foreach($parametros as $indice => $valor){
			$q->setParameter($indice, $valor);
		}
		return $q;
	}
}


/**
 * Gerenciador de entidade
 * @author c066868
 *
 */
class PPOEntityManager{
	
	const UTF_8_ENCODE = 1;
	const ISO_8859_1_ENCODE = 2;
	private $_con;
	private $_encode;
	
	/**
	 * Contrutor padrao. Recebe um objeto PPOConnection como parametro.
	 * @param PPOconexao $con
	 */
	public function __construct($con, $encode = self::ISO_8859_1_ENCODE){
	   $this->_con = $con;	
	   $this->_encode = $encode;
	}
	
	public function beginTransaction(){
		$this->_con->beginTransaction();
	}
	
	public function commit(){
		$this->_con->commit();
	}
	
	public function rollBack(){
		$this->_con->rollBack();
	}
	
	public function getConnection(){
		return $this->_con;
	}
	
	public function execute($sql){
		return $this->_con->execute($sql);
	}
	
	/**
	 * Retorna o valor do parametro da chave primaria, pela classe da entidade,
	 * ou pelo nome do parametro.
	 * @param $entity
	 * @param Optional string $parameterNameKey
	 * @return variant;
	 */
	private function getParameterValueKey($entity){
		$class = get_class($entity);
		$value = 0; 
		$name = "";
		eval("\$name = $class::COLUMN_KEY;");
		eval("\$value = $" . "entity->get" . $name . "();");
		return $value;
	}
	
	/**
	 * Retorna um array de colunas que compoe uma classe...
	 * @param string $class
	 * @return array $columns
	 */
	private function listColumns($class){
		
		$columns = array();
		$ref = new ReflectionClass ($class);
		$it = new ArrayIterator ($ref->getDefaultProperties());
		
		while($it->valid()){
			if (!is_array($it->current())){
				$prop = $ref->getProperty($it->key());	
				$doc =  $prop->getDocComment();
				$vars =	$this->getVarAnnotation($doc);	
				if ($vars["TYPE"] != 'transient') $columns[$it->key()] = $vars;	
			}
			$it->next ();
		}

		return $columns;
		
	}

	/**
	 * retorna um array de dados encontrados na annotation @var de um atributo da classe PPOEntity 
	 * @param string $doc
	 * @return array $parametersArray
	 */
	private function getVarAnnotation($doc){
		$parametersArray = array();
		if (!empty($doc)){
			$doc = strstr($doc, "@var");
			if (!empty($doc)){
				$doc = str_replace( "/", "", $doc);
				$doc = str_replace( "*", "", $doc);
				$doc = str_replace( "@var", "", $doc);
				$doc = trim ($doc);
				eval("\$parametersArray = array(" . $doc . ");");
			}
		} else { 
			$this->raiseEntityManagerError("getVarAnnotation(\$doc)", "Nao foi possivel localizar o annotation do parametro.");
		}
		return $parametersArray;
	}

	/**
	 * Retorna uma entidade preenchida com os dados da array $array.
	 * @param array $array
	 * @param string $class
	 * @return PPOEntity $entity
	 */
	private function fillEntity($array, $class){
		
		if (count($array) < 0 ) {
			$this->raiseEntityManagerError("fillEntity(\$array, \$class)","Nao foram encontrados valores para preencher a Entidade.");;
			return null;
		}
		
		$entity = new $class;
		$columns = $this->listColumns($class);
		
		foreach ($array as $idFiled => $field){
			if( array_key_exists($idFiled,$columns) == 1 ){
				//$idFiled = strtoupper($idFiled);
				$col = $columns[$idFiled];
				$value = $field;
				if( getType($value) == 'string' ) $value = trim($value);
				if ($col["TYPE"] == 'string' || $col["TYPE"] == 'date') $value = "'" . str_replace("'", "\\'", $value) . "'";
				if( $value != NULL && $idFiled != NULL ) eval ("\$entity->set" . $idFiled . "(". $value . ");");
			}
		}
		
		return $entity;
		
	}
	
	/**
	 * Constroi uma sql de acordo com a classe $class e por id.
	 * @param string $class
	 * @param variat $id
	 * @return string $sql
	 */
    private function buildWhereById($class, $id){
  
    	$fieldKey = "";
    	eval("\$fieldKey = $class::COLUMN_KEY;");

		$columns = $this->listColumns($class);

		if ($columns[$fieldKey]["TYPE"] == 'string' or $columns[$fieldKey]["TYPE"] == 'date') $id = "'" . $id . "'";

    	$sql = " WHERE " . $fieldKey . " = $id ";

        return $sql;
    }
    
    /**
     * Constroi uma sql a partir da Entidade e das chaves candidatas.
     * $candidateKeys e uma string do tipo: "nomePamatro1;nomeParametro2;nomeParametro3";
     * @param PPOEntity $entity
     * @param string $candidateKeys
     * @return string
     */
    private function buidWhereSql($entity, $candidateKeys){
        
		$sql 		= "";
    	$where 		= "";
    	$comparator = "";
		
    	$class = get_class($entity);

    	eval("\$fieldKey = $class::COLUMN_KEY;");

    	$keys  = explode( ";", $candidateKeys );
    	
    	if (count($keys)>0) {
    		$operator 	= " AND ";
    		for($i=0; $i < count($keys); $i++){
				if ($i == count($keys) - 1){$operator = "";}
				eval("\$value = \$entity->get" . $keys[$i] . "();");
				if ( is_null($value) ) {
					$value = " IS null";
					$comparator = "";
				} else {
					$value = "'" . str_replace("'", "''", $value) . "'";
					$comparator = " = ";
				}
				$where .= $keys[$i] . $comparator . $value . $operator;
			}
    	}else{
    		eval("\$value = \$entity->get" . $fieldKey . "();");
    		$where = $fieldKey . " = " . $value;
    	}
    	
		$sql = " WHERE " . $where;
		
		return $sql;
		
    }
    
    /**
     * Retorna verdadeiro, caso exista uma tupla correspondente a
     * entidade no banco de dados
     * @param PPOEntity $entity
     * @param string $candidateKeys
     */
    public function entityExists($entity, $candidateKeys){
		
		$ent = $this->findByCandidateKeys($entity, $candidateKeys);

		if ( !isset($ent) ){
			return false;
		}else{
			return $this->getParameterValueKey($ent); 	
		}
    }
    
    /**
     * Converte um objeto do tipo ADODB.RecordSet em Array
     * @param ADODB.RecordSet $rs
     * @return Array $result
     */
    private function ADORecordSetToArray($rs){
    	$index = 0;
		$result = null;
    	while (!$rs->EOF) {
		    for( $x = 0; $x < $rs->Fields->Count; $x++ ){
		    	if ($this->_encode == self::UTF_8_ENCODE && is_string($rs->Fields[$x]->Value)) $result[$index][$rs->Fields[$x]->Name ] = utf8_encode($rs->Fields[$x]->Value); else
				$result[$index][$rs->Fields[$x]->Name ] = $rs->Fields[$x]->Value;
		    }
		    $rs->MoveNext();    
		    $index++;
		}
		return $result;
    }

    public static function utf8EncodeArray($data){

    	// echo "<pre>";
    	// print_r($data);
    	// echo "</pre>";
    	foreach ($data as &$value) {
			
			if (is_array($value)) {
				$value = self::utf8EncodeArray($value);
			}else{
				if (is_string($value)) $value = utf8_encode($value);
			}

		}
		unset($value);

		return $data;
    }

    /**
     * Busca Entidade por id.
     * @param string $class
     * @param variant $id
     * @return PPOEntity $entity
     */
	public function find($class, $id, $viewSql = false){
		$entity = new $class;
    	eval("\$tableName = $class::TABLE_NAME;");
		$list = array();
        $sql =  "SELECT * FROM " . $tableName . $this->buildWhereById($class, $id);

		switch ($this->_con->getDriver()) {
			case PPOConnection::_ADO_EXCEL:
			case PPOConnection::_ADO_MSSQL:
			case PPOConnection::_ADO_ACCESS:
			case PPOConnection::_ADO_MDB:
			case PPOConnection::_ADO_MSSQL_EXPRESS_2012:
				$rs = new COM('ADODB.RecordSet');
				$rs->CursorLocation = 3;
		        $rs->Open($sql, $this->_con->getConnection() , 1, 3);
				$result = $this->ADORecordSetToArray($rs);
				break;

			default://ANY PDO DRIVER

				$sth = $this->_con->prepare($sql);
				$sth->execute();
				$result = $sth->fetchAll(PPO::FETCH_ASSOC);

				if ($this->_encode == self::UTF_8_ENCODE) $result = self::utf8EncodeArray($result);

		}

		if ($viewSql) $this->pr($sql);

		if (isset($result[0])) {
			$entity = $this->fillEntity($result[0], $class);
		}

		return $entity;	
		
	}

	/**
	 * Retorna uma entidade pelos nomes dos parametros correspondesntes as 
	 * chaves candidatas de uma tabela.
	 * @param PPOentity $entity
	 * @param string $candidateKeys
	 */
    public function findByCandidateKeys($entity, $candidateKeys){

		$id 		= 0;
		$sql 		= "";
		$tableName 	= "";
    	$fieldKey 	= "";
    	$result 	= null;
    	$class 		= get_class($entity);

    	// eval("\$tableName = $class::TABLE_NAME;");
    	// eval("\$fieldKey = $class::COLUMN_KEY;");
    	// eval("\$id = \$entity->get$fieldKey();");

    	$tableName 	= $class::TABLE_NAME;
    	$fieldKey 	= $class::COLUMN_KEY;
    	eval("\$id = \$entity->get$fieldKey();");
    	
    	if ($candidateKeys != "" && !is_null($candidateKeys) ){
			$sql = $this->buidWhereSql($entity, $candidateKeys);
		}else{
			if ($id=="" || is_null($id) )$id = 0;
			$sql = $this->buildWhereById($class, $id);
		}

		$sql = "SELECT * FROM " . $tableName . $sql;

	    $index = 0;

	    //tem que ser null...
	    $entity = null;

		switch ($this->_con->getDriver()) {
			case PPOConnection::_ADO_EXCEL:
			case PPOConnection::_ADO_MSSQL:
			case PPOConnection::_ADO_ACCESS:
			case PPOConnection::_ADO_MDB:
			case PPOConnection::_ADO_MSSQL_EXPRESS_2012:
				$rs = new COM('ADODB.RecordSet');
				$rs->CursorLocation = 3;
		        $rs->Open($sql, $this->_con->getConnection() , 1, 2);
				while (!$rs->EOF) {
				    for( $x = 0; $x < $rs->Fields->Count; $x++ ){
						$result[$index][$rs->Fields[$x]->Name ] = $rs->Fields[$x]->Value;
				    }
				    $rs->MoveNext();    
				    $index++;
				}

				if (isset($result)) {
					$entity = $this->fillEntity($result[0], $class);
				}
				break;

			default://ANY PDO DRIVER

				$sth = $this->_con->prepare($sql);
				$sth->execute();
				$result = $sth->fetchAll(PPO::FETCH_ASSOC);
	
				if ($this->_encode == self::UTF_8_ENCODE) $result = self::utf8EncodeArray($result);
				
				if (count($result) > 0 ) {
					$entity = $this->fillEntity($result[0], $class);
				}

		}

		return $entity;	
	}
	
	/**
	* O argumento $candidateKeys é uma STRING que contem um ou mais parametros da classe, delimitados por <;>.
	* O metodo utilizara este argumento para verificar se o registro ja existe no banco de dados.
	* Nao sera utilizada a chave primaria, exceto incluso como parte do argumento $candidateKeys.
	* O metodo resgatara baseando-se no argumento $entity.
	* 
	* A String $candidateKeys deve seguir a seguinte sintaxe:
	* "Campo1;Campo2"
	*
	* Exemplo de chamada do metodo grava:
	* $ge->grava($entity, "Campo1;Campo2");
	*
	*/
	public function save($entity,  $candidateKeys = null, $saveOnlyNotNull = false, $viewSql = false){
 
		//$fieldKey 	= "";
		//$class 		= get_class($entity);
		// $columns 	= $this->listColumns($class);
		// $fieldKey 	= $class::COLUMN_KEY;//eval("\$fieldKey = $class::COLUMN_KEY;");

		// $id = eval("\$vo->get" . $fieldKey . "();");
		// if ($columns[$fieldKey]["TYPE"] == 'string' || $columns[$fieldKey]["TYPE"] == 'date') $id = "'" . $id . "'";
		
		$existe = $this->entityExists($entity, $candidateKeys);

		if ($existe === false){
			return $this->insert($entity, $candidateKeys, $saveOnlyNotNull, $viewSql);
		}else{			
			return $this->update($entity, $candidateKeys, $saveOnlyNotNull, $viewSql);
		}	
   		
	}

	/**
	 * @return 
	 * @param object $entity
	 */
	public function delete($entity, $viewSql = false){
		$sql = $this->buildDeleteSql($entity);
		if ($viewSql) $this->pr($sql);
		switch ($this->_con->getDriver()) {
			case PPOConnection::_ADO_EXCEL:
			case PPOConnection::_ADO_MSSQL:
			case PPOConnection::_ADO_ACCESS:
			case PPOConnection::_ADO_MDB:
			case PPOConnection::_ADO_MSSQL_EXPRESS_2012:
					$this->_con->getConnection()->Execute($sql);
					break;	
				break;
			
			default://ANY PDO DRIVER
				$sth = $this->_con->prepare($sql);
				$sth->execute();
				//$result = $sth->fetchAll();
		}
	}

	/**
	 * Insere uma entidade no banco de dados
	 * @param PPOEntity $entity
	 * @param string $candidateKeys
	 * @param boolean $saveOnlyNotNull
	 * @return integer
	 */
	public function insert($entity, $candidateKeys = null, $saveOnlyNotNull = false, $viewSql = false){

		$id = 0;

		$sql = $this->buildInsertSql($entity, $candidateKeys, $saveOnlyNotNull);

		$class = get_class($entity);

		eval("\$tableName = $class::TABLE_NAME;");
		eval("\$fieldKey = $class::COLUMN_KEY;");


		if ($viewSql) $this->pr($sql);

		try {

			$index = 0;
			switch ($this->_con->getDriver()) {

				case PPOConnection::_ADO_EXCEL:
				case PPOConnection::_ADO_MSSQL:
				case PPOConnection::_ADO_ACCESS:
				case PPOConnection::_ADO_MDB:
				case PPOConnection::_ADO_MSSQL_EXPRESS_2012:
					$this->_con->getConnection()->Execute("Set Nocount on ");
					$this->_con->getConnection()->Execute($sql);
					$rs = $this->_con->getConnection()->Execute(" select @@identity AS IdentityInsert ");
					$id = (int) $rs->Fields[0]->Value;
          			$this->_con->getConnection()->Execute("Set nocount off");
					break;

				default://ANY PDO DRIVER

			       	$stmt = $this->_con->prepare($sql);

					$stmt->execute();
					$sqlId = "SELECT MAX(" . $fieldKey . ") FROM " . $tableName;
					$q = $this->_con->query($sqlId);
					$rowTd = $q->fetch(PDO::FETCH_NUM);
					if (!is_array($rowTd)) {
					    doLog(__FILE__, __LINE__,
					        'insertRecord: $objSth->fetch() returns %s', gettype($rowTd));
					    return false;
					}
					$q->closeCursor();
					$id = trim($rowTd[0]);
				
			}

		} catch (Exception $e) {
			$id = 0;
			throw $e;
		}
		
		return $id;

	}

	/**
	 * Atualiza uma entidade no banco de dados
	 * @param PPOEntity $entity
	 * @param string $candidateKeys
	 * @param boolean $saveOnlyNotNull
	 * @return integer
	 */
	public function update($entity, $candidateKeys = null, $saveOnlyNotNull = false, $viewSql = false){
			
		$sql = $this->buildUpdateSql($entity, $candidateKeys, $saveOnlyNotNull);



		if ($viewSql) {
			$this->pr($sql);
		}

		try {

			switch ($this->_con->getDriver()) {

				case PPOConnection::_ADO_EXCEL:
				case PPOConnection::_ADO_MSSQL:
				case PPOConnection::_ADO_ACCESS:
				case PPOConnection::_ADO_MDB:
				case PPOConnection::_ADO_MSSQL_EXPRESS_2012:
					$this->_con->getConnection()->Execute($sql);
					break;	

				default://ANY PDO DRIVER
			
					$stmt = $this->_con->prepare($sql);
					$stmt->execute();
					
			}
			
		} catch (Exception $e) {
			$id = 0;
			throw $e;
		}
		
		$id = $this->getParameterValueKey($entity);
		
        return $id;
        
	}
	
	
	/**
	 * Constroi uma array de valores o tipo $valores(nome_parametro => valor),
	 * a partir da entidade a fim de ser utilizado na rotina de insercao ou update
	 * @param PPOEntity $entity
	 * @return array;
	 */
	private function buildArrayValues($entity, $saveOnlyNotNull){
		
		$class = get_class($entity);
		
		$column = new ArrayIterator($this->listColumns($class));

		while ( $column->valid () ) {
			
			$col = $column->current();
			
			//ALAN if($col["IS_AUTO"] == false && $col["IS_PRIMARY"] == false && ($col["TYPE"] != 'transient' || $col["TYPE"] != 'default')){	
			if($col["IS_AUTO"] == false && $col["IS_PRIMARY"] == false && $col["TYPE"] != 'transient' ){
				
				eval ("\$value = \$entity->get" . $column->key() . "();");

				if ($value !== NULL ){

					if ($col["TYPE"] == 'date'){

						if ($value != "" && $value != null) $value = "'" .  PPOEntity::toDateUnicode($value) . "'"; else $value = "NULL";
						if ($this->_con->getDriver() == PPOConnection::_ADO_MSSQL && $value != "NULL")  {
							$value = "CONVERT(DATETIME, " . $value . ",102)";
						}

					}

					if ($col["TYPE"] == 'string'){
						
						if($this->_encode == self::UTF_8_ENCODE && mb_detect_encoding($value, 'UTF-8', true)) {
							$value = utf8_decode($value);
						} 

						$value = str_replace("'", "''", $value);
						$value = "'" . $value . "'";
					}

				}else {
					
					$value = "NULL";
					
				}

				if ($saveOnlyNotNull){
					if ($value != "NULL" || $value == '0')	{
						$values[$column->key()] = $value;
					}
				}else{ 
					$values[$column->key()] = $value;
				}

			}
			
			$column->next();
		}
		
		

		return $values;
	}

	/**
	 * Constroi um comando sql de atualizacao a partir da entidade.
	 * @param PPOEntity $entity
	 * @param string $candidateKeys
	 * @param boolean $saveOnlyNotNull
	 * @return string
	 */
	private function buildUpdateSql($entity, $candidateKeys, $saveOnlyNotNull){
		$stValues = "";
		$class = get_class($entity);
		eval("\$tableName = $class::TABLE_NAME;");
		eval("\$fieldKey = $class::COLUMN_KEY;");
		eval("\$id = \$entity" . "->get" . $fieldKey . "();");
		
		$values = $this->buildArrayValues($entity, $saveOnlyNotNull);
		
		$value = new ArrayIterator($values);

		while ( $value->valid () ) {
			$stValues .= $value->key() . " = " . $value->current() . ", ";
			$value->next();
		}

		$stValues = substr($stValues, 0, sizeof($stValues)-3);
		
		if ($candidateKeys != "" || !is_null($candidateKeys) ){
			$where = $this->buidWhereSql($entity, $candidateKeys);
		}else{
			$where = $this->buildWhereById($class, $id);
		}

		return "UPDATE " . $tableName . " SET " . $stValues . " " . $where;

	}
	
	/**
	 * Constroi um comando sql de insercao a partir da entidade.
	 * @param PPOEntity $entity
	 * @param string $candidateKeys
	 * @param boolean $saveOnlyNotNull
	 * @return string
	 */
	private function buildInsertSql($entity, $candidateKeys, $saveOnlyNotNull){
		$stValues = "";
		$stFields = "";
		$where = "";
		$class = get_class($entity);
		eval("\$tableName = $class::TABLE_NAME;");
		eval("\$fieldKey = $class::COLUMN_KEY;");

		$values = $this->buildArrayValues($entity, $saveOnlyNotNull);
		
		$value = new ArrayIterator($values);

		while ( $value->valid () ) {
			
				$stValues .= $value->current() . ", ";
				$stFields .= $value->key() . ", ";

			$value->next();
		}

		$columns = $this->listColumns($class);
		
		if( $columns[$fieldKey]['IS_AUTO'] == false ){
			$stFields = $fieldKey . "," . $stFields;
			eval("\$vl = \$entity->get" . $fieldKey . "();" );
			if ($columns[$fieldKey]["TYPE"] == 'string' || $columns[$fieldKey]["TYPE"] == 'date') $vl = "'" . $vl . "'";
			$stValues = $vl . ',' .  $stValues;
		}

		$stValues = substr($stValues, 0, sizeof($stValues)-3);
		$stFields = substr($stFields, 0, sizeof($stFields)-3);

		if ($candidateKeys != "" || !is_null($candidateKeys) ){
			$where = $this->buidWhereSql($entity, $candidateKeys);
		}else{
			$where = "";
		}

		return "INSERT INTO " . $tableName . " (" . $stFields . ") VALUES (" . $stValues . ")" . $where;

	}
	
	/**
	 * Constroi um comando sql de exclusao a partir da entidade.
	 * @param PPOEntity $entity
	 * @return string
	 */
	private function buildDeleteSql($entity){
		$class = get_class($entity);
		eval("\$tableName = $class::TABLE_NAME;");
		eval("\$fieldKey = $class::COLUMN_KEY;");
		eval("\$id = \$entity" . "->get" . $fieldKey . "();");

		if ($id=="" || is_null($id) ){ 
			$id = -999999;
			//echo ("Deve-se informar um valor valido para o ID antes de excluir!");
		}
		
		$where = $this->buildWhereById($class, $id);
		return "DELETE FROM " . $tableName . $where; 
	}
	
	
	/**
	 * Devolve o valor do campo no array 
	 * @param string $campo
	 * @param array $arrayPost
	 * @param string $valorPadrao
	 */
	public function getValueFromRequest($fieldName, $arrayRequest, $defaultValue = null){

		if(array_key_exists($fieldName, $arrayRequest)){
			if ( is_null($arrayRequest[$fieldName]) ) {
				return $defaultValue;
			} else {
				return $arrayRequest[$fieldName];
			}
		}else return $defaultValue;

	}
	
	/**
	 * Devolve o valor do campo no array testando isset
	 * @param string $campo
	 * @param array $arrayPost
	 * @param string $valorPadrao
	 */
	public function getFromRequest($fieldName, $arrayRequest, $defaultValue = null){
	
		if (isset($arrayRequest[$fieldName]) || is_null($arrayRequest[$fieldName])){
			if (is_integer($defaultValue) && $arrayRequest[$fieldName] == '') return $defaultValue; else return $arrayRequest[$fieldName];
		}else{
			return $defaultValue;
		}
	}
	
    /**
     * Cria um objeto do tipo PPOQuery 
     * @param string $class
     * @param string $namedQuery
     * @param string $orderBy
     */
	public function createQuery($class, $namedQuery, $orderBy="", $encode = null){
		$encodeUsado = 0;
		if ($encode === null) $encodeUsado = $this->_encode; else $encodeUsado = $encode;
		$sql = $namedQuery;
		$q = new PPOQuery($this->_con, $class, $this->listColumns($class), $sql, $orderBy, $encodeUsado);
		return $q;
	}
	
	/** 
	 * Preenche uma entidade a partir do objeto request. Para tanto é necessário
	 * que os nomes das chaves no vetor $_REQUEST seja igual aos dos atributos da
	 * classe Entidade a ser preenchida.
	 * @param string $classe
	 * @param array $REQUEST
	 */
	public function fillEntityByRequest($class, $REQUEST){
		return $this->fillEntity($REQUEST, $class);
	}
    
	/**
	*	Retorna um codigo hash no formato MD5 da sessão corrente
	*/
	public function toHash(){
		 return md5(session_id());
	}

	/**
	*	Descrição do Objeto em formato string
	*/
	public function toString(){
		$aux = "PPOEntityManager - Gerenciador de Entidades para PPO(PHP Persistent Objects)";
		return $aux;
	}
	
	/**
	 * 
	 * Metoto auxiliar para debug.
	 * @param string $msg
	 */
	public function p($msg){
		/*echo "<pre><br>";
		print $msg;
		echo "</pre></br>";*/
	}
	
	/**
	 * 
	 * Metoto auxiliar para debug.
	 * @param array $array
	 */
	public function pr($array){
		echo "<pre><br>";
		print_r($array);
		echo "</pre><br>";
	}
	
	/**
	 * Cria uma excecao para EntityManager
	 * @param string $functionName
	 * @param string $message
	 * @param $code
	 */
 	private function raiseEntityManagerError($functionName, $message = "Erro", $code = "9999"){
 		$message = $message . " " . $functionName . " in " . $this->toString();
 		new Exception($message, $code);
 	}
	
 	// //ALAN
 	// private function utf8_encode_all($dat) // -- It returns $dat encoded to UTF8
 	// {
 	// 	if (is_string($dat)) return utf8_encode($dat);
 	// 	if (!is_array($dat)) return $dat;
 	// 	$ret = array();
 	// 	foreach($dat as $i=>$d) $ret[$i] = utf8_encode_all($d);
 	// 	return $ret;
 	// }
 	
 	
 	// private function is_utf8($string) {
 	// 	// From http://w3.org/International/questions/qa-forms-utf-8.html
 	// 	return preg_match('%^(?:
  //         [\x09\x0A\x0D\x20-\x7E]            # ASCII
  //       | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
  //       |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
  //       | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
  //       |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
  //       |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
  //       | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
  //       |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
  //   	)*$%xs', $string);
 	// }
 	
 	// private function getCodificacao($string) {
 	// 	return mb_detect_encoding($string.'x', 'UTF-8, ISO-8859-1');
 	// }
 	
	private static function isUTF8($string) {
		return mb_detect_encoding($string.'x', 'UTF-8', true);
	}
	
 	// private function isISO88591($string) {
 	// 	return mb_detect_encoding($string.'x', 'ISO-8859-1', true);
 	// }
 
}

/**
*	Fábrica de gerenciador de entidades
*	Thiago Albuquerque Rosa / Alan Ferreira de Lima Filho
*/
class PPOEntityManagerFactory {

	public function getEntityManager($driver, $host, $database, $port, $user, $password, $encode) {

		$ppoCon = new PPOConnection(
			$driver, 
			$host, 
			$database,
			$user,
			$password,
			$port, 
			true
		);

		$ppoCon->open();

		$em = new PPOEntityManager($ppoCon, $encode);
		
		unset($ppoCon);
		
		return $em;
	}
	
}

/**
 * 
 * Query para utilizacao com o entity manager...
 * @author c066868
 *
 */
class PPOQuery{

	const UTF_8_ENCODE = 1;
	const ISO_8859_1_ENCODE = 2;
	
	private $_con;
	private $_class;
	private $_sql;
	private $_maxLines;
	private $_startPage;
	private $_parameters;
	private $_columns;
	private $_encode;
	
	/**
	 * Contrutor padrao
	 * @param PPOConnection $con
	 * @param string $class
	 * @param string $query
	 * @param string $orderBy
	 */
	public function __construct($con, $class = "", $columns = array(), $query="", $orderBy="", $encode = 2, $_parameters =  array()){
	
		$this->_con = $con;
		$this->_class = $class;
		$this->_columns = $columns;
		$this->_encode = $encode;
		$pos = 0;

		if ( $orderBy != "" ) {
			$pos = stripos($orderBy, "ORDER BY");
			if ( !is_int($pos) ) {
				$orderBy = "ORDER BY " . $orderBy;
			}
			$pos = stripos($query,"ORDER BY");
			if ( is_int($pos) ) {
				$query = substr($query, 0, $pos);
			}
			$query .= " " . $orderBy;
		}		

		$this->_sql = $query;
		$this->_maxLines = 0;
		$this->_startPage = 0;	
		$this->_parameters = $_parameters;			
	}


	public function setSql($query, $orderBy = ""){
		if ( $orderBy != "" ) {
			$pos = stripos($orderBy, "ORDER BY");
			if ( !is_int($pos) ) {
				$orderBy = "ORDER BY " . $orderBy;
			}
			$pos = stripos($query,"ORDER BY");
			if ( is_int($pos) ) {
				$query = substr($query, 0, $pos);
			}
			$query .= " " . $orderBy;
		}		

		$this->_sql = $query;
	}
	
	/**
	 * Guarda os valores para substituir na sql ...
	 * @param string $alias
	 * @param unknown_type $valor
	 */
	public function setParameter($alias, $valor){
		if ( is_null($valor) ) $valor = ' null ';
		$this->_parameters[$alias] = $valor;
	}

	/**
	 * Retorna um array contendo o resultado da consulta.
	 */
	public function getListArray($fetch = PPO::FETCH_ASSOC){
		$list = array();
		$result = array();
		$sql = $this->buildSql();

		switch ($this->_con->getDriver()) {
			case PPOConnection::_ADO_EXCEL:
			case PPOConnection::_ADO_MSSQL:
			case PPOConnection::_ADO_ACCESS:
			case PPOConnection::_ADO_MDB:
			case PPOConnection::_ADO_MSSQL_EXPRESS_2012:
				$rs = new COM('ADODB.RecordSet');
		        $rs->CursorLocation = 3;
		        $rs->Open ($sql, $this->_con->getConnection(), 1, 3);

				$result = $this->ADODBRecordSetToArray($rs, $fetch);
				$rs->Close();
        		$rs = Null;

		        break;	

			default://ANY PDO DRIVER

				// $q = $this->_con->query($sql);
				// $result =  $q->fetchAll($fetch);
				$sth = $this->_con->prepare($sql);
				$sth->execute();
				$result = $sth->fetchAll($fetch);

				if ($this->_encode == self::UTF_8_ENCODE) $result = PPOEntityManager::utf8EncodeArray($result);

		}
		return $result;
	}


	/**
	* Função getListArrayPagination()
	* Por Marcos Dimitrio Silva, c059930, www.dimitrio.com
	* Em 14/05/2013
	*
	*	Baseado na idéia de "splattne":
	*	http://stackoverflow.com/questions/284784/is-there-a-start-at-equivalent-in-ms-sql
	*
	*	Exemplo da variável ordenação:	$ordenacao = array("campo1"=>"asc", "campo2"=>"desc");
    * A ordenação é obrigatória por conta da forma que a função extrai os dados do SQL Server 2000
    *
	*	@param string $consulta
	*	@param array() $param
	*	@param array() $ordenacao
	*	@param int $pag_atual
	*	@param inr $itens_por_pagina
	*	@return array()
	*
	*	Exemplo para colocar no DAO...
	*	public function getListArrayPagination($consulta, $parametros = array(), array $ordenacao, $pag_atual = 1, $itens_por_pagina = 10, &$total_registros = null) {
	*		$q = new PPOQuery($this->em->getConnection());
	*		return $q->getListArrayPagination($consulta, $parametros, $ordenacao, $pag_atual, $itens_por_pagina, $total_registros);
	*	}
	*
	*/
	public function getListArrayPagination($consulta, $parametros = array(), array $ordenacao, $pag_atual = 1, $itens_por_pagina = 10, &$total_registros = null) {
		if (count($ordenacao) == 0) {
			throw new Exception('getListArrayPagination: campo ordenação não pode ser vazio.');
		}

		// Geramos os dois campos orderby que precisaremos nas consultas
		$orderby_normal = array();
		$orderby_invert = array();
		foreach ($ordenacao as $campo => $ordem) {
			if (strtolower($ordem) == "asc") {
				$invert = "desc";
			} elseif (strtolower($ordem) == "desc") {
				$invert = "asc";
			} else {
				throw new Exception('getListArrayPagination: ordem da ordenação era esperada como "asc" ou "desc" (campo '.$campo.').');
			}
			$orderby_normal[] = "$campo $ordem";
			$orderby_invert[] = "$campo $invert";
		}

		// Incluímos o comando TOP no primeiro select, para permitir o 
		// ORDER BY e COUNT no SQL Server 2000.
		/* once-only subpatterns = (?>) */
		/* look ahead negative assertions = (?!) */
		$consulta = preg_replace(
			"/^\s*SELECT((?>\s+)ALL(?>\s+)|(?>\s+)DISTINCT(?>\s+)|(?>\s+)(?!ALL|DISTINCT))(?!TOP\s)/im", 
			"SELECT $1 TOP 100 PERCENT ", 
			$consulta, 
			1
		);

		// pegamos o total de registros
		$contagem_sql = "SELECT Count(*) AS qtd FROM ($consulta) AS t ";

		$q = new PPOQuery($this->_con, "", array(), $contagem_sql, "",2 , $parametros);
		//$q = new PPOQuery($this->_con,,, $contagem_sql,,,$parametros);

		$arr_contagem = $q->getListArray();

		$total_registros = $arr_contagem[0]["qtd"];

		// Fazemos o cálculo para a última página.
		// Se houver menos que "itens_por_pagina" para exibir, calculamos
		// e exibimos apenas os registros necessários.
		$ultimo_reg_a_exibir = $pag_atual * $itens_por_pagina;
		$registros_a_exibir = $itens_por_pagina;

		if ($ultimo_reg_a_exibir > $total_registros) {
			$diferenca = $ultimo_reg_a_exibir - $total_registros;
			$registros_a_exibir = $itens_por_pagina - $diferenca;

			// Se a diferença for maior que "itens_por_pagina", quer dizer que ultrapassou
			// o limite de dados, não há mais páginas com dados. Retornamos um array vazio.
			if ($diferenca > $itens_por_pagina) {
				return array();
			}
		}

		$sql  = "";
		$sql .= "SELECT * FROM ( \r\n";
		$sql .= "  SELECT TOP $registros_a_exibir * FROM ( \r\n";
		$sql .= "    SELECT TOP " . ($pag_atual * $itens_por_pagina) . " * FROM ( \r\n";
		$sql .= $consulta . "\r\n";
		$sql .= "    ) as t ORDER BY " . implode(", ", $orderby_normal) . " \r\n";
		$sql .= "  ) AS t1 ORDER BY " . implode(", ", $orderby_invert) . " \r\n";
		$sql .= ") AS t2 ORDER BY " . implode(", ", $orderby_normal) . " \r\n";

		
		$this->_sql = $sql;
		$this->_parameters = $parametros;

		$this->_sql = $this->buildSql();
		return $this->getListArray();

	}
 
	/**
	* Teste de hash do Gusttavo.. Gusttavo Gavazza!.. aquele lá do banco!!.. 
	**/
	public function getHash($indiceNum) {
		
		$list = array();
		$res = array();
		$sql = $this->buildSql();
		
		switch ($this->_con->getDriver()) {
			case PPOConnection::_ADO_EXCEL:
			case PPOConnection::_ADO_MSSQL:			
			case PPOConnection::_ADO_ACCESS:
			case PPOConnection::_ADO_MDB:
			case PPOConnection::_ADO_MSSQL_EXPRESS_2012:
				$rs = new COM('ADODB.RecordSet');
		        $rs->CursorLocation = 3;
		        $rs->Open ($sql, $this->_con->getConnection(), 1, 3);
				
				$res = $this->ADODBRecordSetToHash($rs, $indiceNum);
				$rs->Close();
        		$rs = Null;
				
		        break;	
				
			default:
				
				// $q = $this->_con->query($sql);
				// $res =  $q->fetchAll($fetch);
				$sth = $this->_con->prepare($sql);
				$sth->execute();
				$result = $sth->fetchAll();
			
		}
		
		return $res;
		
	}

	private function ADODBRecordSetToHash($rs, $indiceNum = -1) {
		
		$result = null;
    	
		$rc = 0;
		
    	If ($this->_maxLines <> 0 && $this->_startPage <> 0) {
			
            $rs->PageSize($this->_maxLines);
            
			$rs->AbsolutePage($this->_startPage);
            
			$rc = 0;
            
			while ((!$rs->eof()) && ($rc < $rs->PageSize())) {
				
				$indiceFinal = $rs->Fields[$indiceNum]->Value;
		    	
             	for( $x = 0; $x < $rs->Fields->Count; $x++ ) {
					
					if ($this->_encode == self::UTF_8_ENCODE) $result[$indiceFinal][$rs->Fields[$x]->Name ] = utf8_encode($rs->Fields[$x]->Value); 
					else $result[$indiceFinal][$rs->Fields[$x]->Name ] = $rs->Fields[$x]->Value;
					
		    	}
				
		    	$rs->MoveNext();
				
				$rc++;
				
            }
			
    	} else {
			
	    	while (!$rs->EOF) {
				
				$indiceFinal = $rs->Fields[$indiceNum]->Value;
		    	
			    for ($x = 0; $x < $rs->Fields->Count; $x++ ) {
			    	
					if ($this->_encode == self::UTF_8_ENCODE) $result[$indiceFinal][$rs->Fields[$x]->Name ] = utf8_encode($rs->Fields[$x]->Value); 
					else $result[$indiceFinal][$rs->Fields[$x]->Name ] = $rs->Fields[$x]->Value;
					
			    }
			    
				$rs->MoveNext();
			    
			}
			
        }
		
        return $result;
		
    }
    
    /**
     * Retoran um Array de Objetos do tipo Entity com o resultado da consulta
     */
	public function getList(){
		return $this->fillList($this->getListArray(), $this->_class);
	}
	
	/**
	 * Retorna um array com um unico registro (primeiro) da consulta
	 */
	public function getSingleResultArray(){		
		$list = array();
		$list = $this->getListArray();
		if (sizeof($list) > 0){
			return array_shift($list);
		}else{
			return array();
		}
	}
	
	/**
	 * Retorna um array com um unico objeto (primeiro) da consulta
	 */
	public function getSingleResult(){
		$list = array();
		$list = $this->getList();
		if (sizeof($list) > 0){
			return array_shift($list);
		}else{
			return new $this->_class;
		}
	}
	
	/**
	 * Converte o recordset em um array ...
	 * @param ADODBRecorSet $rs
	 * @return array
	 */
	private function ADODBRecordSetToArray($rs, $fetch){
		$result = null;
    	$index = 0;
    	$rc = 0;

    	If ($this->_maxLines <> 0 && $this->_startPage <> 0){

             $rs->PageSize($this->_maxLines);
             $rs->AbsolutePage($this->_startPage);
             $rc = 0;
             while ((!$rs->eof()) && ($rc < $rs->PageSize())){
             	for( $x = 0; $x < $rs->Fields->Count; $x++ ){
             		if ($fetch == PPO::FETCH_BOTH ||$fetch == PPO::FETCH_NAMED ){
             			
             			if ($this->_encode == self::UTF_8_ENCODE  && is_string($rs->Fields[$x]->Value) ) $result[$index][$rs->Fields[$x]->Name ] = utf8_encode($rs->Fields[$x]->Value); else
						$result[$index][$rs->Fields[$x]->Name ] = $rs->Fields[$x]->Value;
             		
             		}
             		if ($fetch == PPO::FETCH_NUM || $fetch == PPO::FETCH_BOTH){
             			
             			if ($this->_encode == self::UTF_8_ENCODE  && is_string($rs->Fields[$x]->Value)) $result[$index][$rs->Fields[$x]->Name ] = utf8_encode($rs->Fields[$x]->Value); else
             			$result[$index][$x] = $rs->Fields[$x]->Value;
             			
					}
		    	}
		    	$rs->MoveNext();
		    	$index++;
             	$rc++;
             }
    	}else{
    	
	    	while (!$rs->EOF) {
			    for( $x = 0; $x < $rs->Fields->Count; $x++ ){
			    	
			    	if ($fetch == PPO::FETCH_BOTH || $fetch == PPO::FETCH_NAMED){
			    		
			    		if ($this->_encode == self::UTF_8_ENCODE && is_string($rs->Fields[$x]->Value)) $result[$index][$rs->Fields[$x]->Name ] = utf8_encode($rs->Fields[$x]->Value); else
						$result[$index][$rs->Fields[$x]->Name ] = $rs->Fields[$x]->Value;
						
             		} 
        
             		if ($fetch == PPO::FETCH_NUM || $fetch == PPO::FETCH_BOTH){
             			
             			if ($this->_encode == self::UTF_8_ENCODE  && is_string($rs->Fields[$x]->Value)) $result[$index][$rs->Fields[$x]->Name ] = utf8_encode($rs->Fields[$x]->Value); else
						$result[$index][$x] = $rs->Fields[$x]->Value;
						
					}
			    }
			    $rs->MoveNext();
			    $index++;

			}

        }

        return $result;
    }
    
	/**
	 * Monta a query, mesclando os parametros com a sql
	 * @return string $sql
	 */
	 private function buildSql(){
		$sql = $this->_sql;
		
		if ($this->_parameters > 0){
			$ai = new ArrayIterator ($this->_parameters);
			while ( $ai->valid () ) {
				$sql = str_replace($ai->key(), $this->_parameters[$ai->key()], $sql);			
				$ai->next ();
			}
		}
		if (strpos($sql, ':')){
			new Exception("Existem parâmetros não preenchidos na consulta!");
		}
		//echo $sql."<br>";
		return $sql;
    }
    
    /**
     * Retorn a SQL de Consulta...
     */
    public function getSql(){
    	return $this->buildSql();
    }
    
	/**
	 * Preenche uma lista com os obejetos a partir de uma array
	 * @param array $array
	 * @param string $class
	 * @return array $list
	 */
	private function fillList($array, $class){
		$list = array();
		if( count($array) < 1 ) return $list;
		eval("\$fieldKey = $class::COLUMN_KEY;");
		foreach ($array as $row) {
			$entity = $this->fillEntity($row, $class);
			if( !is_null($entity) ) {
				eval("\$value = \$entity->get" . $fieldKey . "();");
				$list[$value] = $entity;
				//echo "<pre>"; print_r($entity); echo "</pre>"; 
			}
		}
		return $list;
    }
	
	/**
     * Preenche uma entidade(objeto) a partir de uma array de valores
     * @param array $array
     * @param string $class
     * @return PPOEntity 
     */
	private function fillEntity($array, $class){

		if (count($array) < 0 ) return null;
		$entity = new $class;
		foreach ($array as $idFiled => $field){
			if( array_key_exists($idFiled, $this->_columns) == 1 ){
				$col = $this->_columns[$idFiled];
				$value = $field;
				if( getType($value) == 'string' ) $value = trim($value);
				if ($col["TYPE"] == 'string' || $col["TYPE"] == 'date') $value = "'" . str_replace("'", "\\'", $value) . "'";
				if( $value != NULL && $idFiled != NULL ) eval ("\$entity->set" . $idFiled . "(". $value . ");");
			}
		}

		return $entity;

	}

}

?>
