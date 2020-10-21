
<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$controllerFile = "/controllers/entidades.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";

	$result = array();

	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac']; 
	
	$EntidadesDAO 			= new EntidadesDAO($em);
	$EntidadeContatosDAO 	= new EntidadesContatosDAO($em);
	$ContatosDAO			= new ContatosDAO($em);

	/* Axilia no preenchimento de combos de seleção */
	$gdEntidadesTipo		= new EntidadesTiposDAO($em);
	$gdUnidadesFederacao 	= new UnidadesFederacaoDAO($em);
	
	if (!user_has_access("CADASTRO_ENTIDADE")) $siopm->getHtmlError("Você não possui acesso a este módulo");

	switch ($action) {

		case 'LISTAR_ENTIDADES':
		
			$db_entidades_arr = $EntidadesDAO->listAllAtivas();			
			require $siopm->getTemplate('entidades');						
			break;

		case 'EDITAR_ENTIDADE':
		case 'VISUALIZAR_ENTIDADE':

			if ($action=="VISUALIZAR_ENTIDADE" and !user_has_access("CADASTRO_ENTIDADE_VISUALIZAR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-entidade" );
				die();
			}			
			if ($action=="EDITAR_ENTIDADE" and !user_has_access("CADASTRO_ENTIDADE_EDITAR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-entidade" );
				die();
			}				

			if($action=="VISUALIZAR_ENTIDADE"){
				$titulo_form = "Visualização";
			}else{
				$titulo_form = "Manutenção";
			}

			$unidadesFederacao 	= $gdUnidadesFederacao->listAll();
			$arr_tipo_entidades = $gdEntidadesTipo->listAll();			
			$arr = array();
			
			if (isset($_REQUEST["EntidadeID"]) && $_REQUEST["EntidadeID"] > 0) {
				$arr = $EntidadesDAO->findByID($_REQUEST["EntidadeID"]);					
			}		
			
			require $siopm->getForm('entidades');
			
			break;
		
		case 'EDITAR_ENTIDADE_CONTATO':

			$titulo_form = "Entidade - Contatos";

			if (isset($_REQUEST["EntidadeID"]) && $_REQUEST["EntidadeID"] > 0){		
				$entidade = $EntidadesDAO->findByID($_REQUEST["EntidadeID"]);
				$contatos = $EntidadeContatosDAO->listAllContatosByEntidadeID($entidade["EntidadeID"]);
				require $siopm->getForm('entidades.contatos');
			} else {
				echo $siopm->getErrorModal("Não foi passado o id de detalhe da proposta corretamente");
			}
			
			break;

		case 'EXCLUIR_ENTIDADE_CONTATO':


			if (isset($_REQUEST["EntidadeContatoID"]) && $_REQUEST["EntidadeContatoID"] > 0){
				
				try{

					$em->beginTransaction();
					
					$voEC = $EntidadeContatosDAO->find($_REQUEST["EntidadeContatoID"]);
					$vo = $ContatosDAO->find($voEC->getContatoID());
					
					$logger->logarExclusao($vo);
					$ContatosDAO->delete($vo);
					
					$logger->logarExclusao($voEC);
					$EntidadeContatosDAO->delete($voEC);

					$em->commit();

					$result = json_encode(array("resultado" => true, "mensagem" => "Contato excluído com sucesso!"));

				}catch (Exception $e){

					$em->rollBack();
					$result = json_encode(
							array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
								": Erro ao excluir contato!", "exception" => $e->getTraceAsString()
							)
						);
				}

			}else{
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
							": Identificador do contato não enviado. Erro ao tentar excluir.", "exception" => $e->getTraceAsString()
						)
					);
			}
			
			echo $result;

			break;

		case 'SALVAR_ENTIDADE_CONTATO':

			if (isset($_REQUEST["EntidadeID"]) && $_REQUEST["EntidadeID"] > 0){
				try{

					$em->beginTransaction();

					$vo = $ContatosDAO->fillEntityByRequest($_REQUEST);
					
					$logger->prepararLog($vo);
					$vo->setContatoID((int) $ContatosDAO->persist($vo));
					$logger->logar($vo);

					$voEC = $EntidadeContatosDAO->fillEntityByRequest($_REQUEST);
					$voEC->setContatoID($vo->getContatoID());
					
					$logger->prepararLog($voEC);
					$voEC->setEntidadeContatoID((int)$EntidadeContatosDAO->persist($voEC));
					$logger->logar($voEC);

					$em->commit();

					$result = json_encode(array(
						"contatoid" => $vo->getContatoID(),
						"entidadecontatoid" => $voEC->getEntidadeContatoID(),
						"resultado" => true, 
						"mensagem" => "Dados do contato salvos com sucesso!")
					);

				}catch (Exception $e){
					
					$em->rollBack();
					
					$result = 
						json_encode(
							array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
								": Erro ao gravar dados do contato! " . $e->getMessage(), "exception" => $e->getTraceAsString())
						);

				}

			}else{
				$result = json_encode(array("resultado"=> false,"mensagem"=> "O ID da Entidade não foi enviado corretamente!"));
			}

			echo $result;

			break;


		case 'PROCURAR_ENTIDADE':	
			
			if (isset($_REQUEST["EntidadeCnpj"]) && count($_REQUEST["EntidadeCnpj"])>0){
				$dadosEntidade = $EntidadesDAO->findByCnpj($_REQUEST["EntidadeCnpj"]);			
			}

			echo json_encode($dadosEntidade);

			break;

		case 'SALVAR_ENTIDADE':

			if (!user_has_access("CADASTRO_ENTIDADE_EDITAR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-entidade" );
				die();
			}			

			$result = "[]";			
			$result = validaDados($_REQUEST);
			
			if ($result === true)	try{
				
				$em->beginTransaction();
				$vo = $EntidadesDAO->fillEntitybyRequest($_REQUEST);
				$logger->prepararLog($vo);
				
				$vo->setEntidadeID((int) $EntidadesDAO->persist($vo));
				$logger->logar($vo);				

				$em->commit();
				$result = json_encode(array("resultado"=> true, "mensagem"=> "Dados da entidade " . 
					$_REQUEST["EntidadeCnpj"] . " salvos com sucesso!" , "entidadeid" => $vo->getEntidadeID()));
			
			}catch (Exception $e){

				$em->rollBack();	
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
							": Erro ao gravar dados da Entidade: " . $_REQUEST["EntidadeCnpj"] . "!", "exception" => $e->getMessage() . " |TRACK==>" . $e->getTraceAsString())
					);
			}

			echo $result;

			break;

		case 'EXCLUIR_ENTIDADE':	

			if (!user_has_access("CADASTRO_ENTIDADE_EXCLUIR")) die("Você não possui acesso a este módulo");		

			$cnpj = $_REQUEST["EntidadeCnpj"];
			$EntidadeID = $_REQUEST["EntidadeID"];									
			
			try{


				$em->beginTransaction();
				$vo = $EntidadesDAO->find($EntidadeID);
				$logger->prepararLog($vo);
				
				$vo->setEntidadeAtiva(0);
				//$EntidadesDAO->execute("UPDATE tblEntidades SET EntidadeAtiva = 0 WHERE EntidadeID = :entidadeid", array(":entidadeid" =>  $EntidadeID));				
				$EntidadesDAO->update($vo);
				$logger->logar($vo);


				$em->commit();
				$result = json_encode(array("resultado" => true, "mensagem" => "Entidade $cnpj excluída com sucesso!"));

			}catch (Exception $e){

				$em->rollBack();
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
							": Erro ao excluir entidade $cnpj", "exception" => $e->getTraceAsString()
						)
					);
			}		
			
			echo $result;
			break;	
		default:
			if (isset($_REQUEST['ac'])){
				$post_acao = $_REQUEST['ac'];
				if (!in_array($post_acao, array('list','edit','save', 'find'))) {
					echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O campo "ação" não foi indicado corretamente.'));
					exit;
				}
			} else echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': USUARIO POST AC NAO DEFINIDO.'));
			break;
	}

	function validaDados($post){

		if (!validaEntidade($post)) return validaEntidade($post);
		
		if (!isset($post['EntidadeNomeRazao']))
			return json_encode(array("resultado" => false, "mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O Nome/Razao não foi enviado.'));

		$post_nome = trim($post['EntidadeNomeRazao']);
		if (strlen($post_nome) < 4 or stripos($post_nome, ' ') === false)
			return json_encode(array("resultado" => false, "mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': Nome/Razao inválido, por favor preencha o Nome/Razao completo.'));

		if (!isset($post['EntidadeNomeFantasia']))
			return json_encode(array("resultado" => false, "mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O Nome Fantasia não foi enviado.'));

		$post_nome = trim($post['EntidadeNomeFantasia']);
		if (strlen($post_nome) < 4 )
			return json_encode(array("resultado" => false, "mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': Nome Fantasia inválido, por favor preencha Nome Fantasia completo.'));

		if (!isset($post['EntidadeDataAbertura']))
			return json_encode(array("resultado" => false, "mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': A data de abertura não foi enviada.'));

		if (!isset($post['EntidadeTipoID']))
			return json_encode(array("resultado" => false, "mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O Tipo de Entidade não foi enviado.'));
		
		if (!isset($post['EntidadeAtiva']) || ($post['EntidadeAtiva'] == "") )
			return json_encode(array("resultado" => false, "mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': A informação sobre o status da Entidade não foi enviada.'));

		return true;
	}

	function validaEntidade($post){

		$post_cnpj = mb_strtolower($post['EntidadeCnpj']);
		$post_cnpj_val = mb_strtolower( preg_replace( "@[./-]@", "", $post_cnpj ));

		$cnpjverificado = valida_cnpj($post_cnpj_val);
			
		if (!$cnpjverificado)
			return json_encode(array("resultado" => false, "mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O CNPJ informado não é válido.'));

		if (!preg_match('/^[0-9+\/.-]{18}$/i', $post_cnpj))
			return json_encode(array("resultado" => false, "mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': Formato CNPJ inválido, deve estar no padrão 99.999.999/9999-99.'));

		if (!isset($post_cnpj)) 
			return json_encode(array("resultado" => false, "mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O campo CNPJ não foi enviado.'));		

		return true;

	}

	function valida_cpf($cpf){ 
		for( $i = 0; $i < 10; $i++ ){ 
	        if ( $cpf ==  str_repeat( $i , 11) or !preg_match("@^[0-9]{11}$@", $cpf ) or $cpf == "12345678909" )			return false;                
				if ( $i < 9 ) $soma[]  = $cpf{$i} * ( 10 - $i ); 
	                $soma2[] = $cpf{$i} * ( 11 - $i );                       
		} 
		
		if(((array_sum($soma)% 11) < 2 ? 0 : 11 - ( array_sum($soma)  % 11 )) != $cpf{9})return false; 
			return ((( array_sum($soma2)% 11 ) < 2 ? 0 : 11 - ( array_sum($soma2) % 11 )) != $cpf{10}) ? false : true; 
	}

	function valida_cnpj( $cnpj ) {
		if( strlen( $cnpj ) <> 14 or !is_numeric( $cnpj ) ){
			return false;
		}
	 
		$k = 6;
		$soma1 = "";
		$soma2 = "";
	 
		for( $i = 0; $i < 13; $i++ ){
			$k = $k == 1 ? 9 : $k;
			$soma2 += ( $cnpj{$i} * $k );
			$k--;
			
			if($i < 12) {
				if($k == 1) {
					$k = 9;
					$soma1 += ( $cnpj{$i} * $k );
					$k = 1;
				} else {
					$soma1 += ( $cnpj{$i} * $k );
				}
			}
		}

		$digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
		$digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;

		return ( $cnpj{12} == $digito1 and $cnpj{13} == $digito2 );
	}

?>
