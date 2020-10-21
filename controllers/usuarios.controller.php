<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$controllerFile = "/controllers/usuarios.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	require  $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";
	
	$result = array();
	
	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac']; 

	$UsuariosDAO 	= new UsuariosDAO($em);
	$PerfisDAO 		= new PerfisDAO($em);
	$UnidadesDAO 	= new UnidadesDAO($em);

	if (!user_has_access("CADASTRO_USUARIOS")) $siopm->getHtmlError("Você não possui acesso a este módulo.");

	switch ($action) {

		case 'LISTAR_USUARIOS':
		case 'LISTAR_USUARIOS_ATUALIZACAO':
		
			$db_usuarios_arr = $UsuariosDAO->listAllUserAtivos();
			
			if( $db_usuarios_arr === null ) $db_usuarios_arr = array();

			require $siopm->getTemplate('usuarios');

			if ($action == "LISTAR_USUARIOS_ATUALIZACAO") echo $contents;

			break;

		case 'EDITAR_USUARIO':
		case 'VISUALIZAR_USUARIO':

			if (($action == "view") && (!user_has_access("CADASTRO_USUARIOS_VISUALIZAR"))) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo.", "dialog-manut-ativo-view");
				die();
			}
			if (($action == "edit") && (!user_has_access("CADASTRO_USUARIOS_EDITAR"))) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo.", "dialog-manut-ativo-view");
				die();
			}

			$perfis_arr = $PerfisDAO->listAllAtivas();

			$arrUsuarios = null;

			if (isset($_REQUEST["UsuarioMatricula"]) && $_REQUEST["UsuarioMatricula"] != "")
				$arrUsuarios = $UsuariosDAO->findByMatricula($_REQUEST["UsuarioMatricula"]);

			require $siopm->getForm('usuarios');

			break;

		case 'SALVAR_USUARIO':

			if (!user_has_access("CADASTRO_USUARIOS_EDITAR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo.", "dialog-manut-ativo-view" );
				die();
			}

			$result = "[]";

			$result = validaDados($_REQUEST);

			if ($result === true) try{

				$em->beginTransaction();
				$vo = $UsuariosDAO->fillEntitybyRequest($_REQUEST);	
				//$voUn =  $UnidadesDAO-> fillEntitybyRequest($_REQUEST);
				//$logger->prepararLog($voUn);
				//$unidade = $UnidadesDAO->persist($voUn);
				//$logger->logar($voUn);
				$logger->prepararLog($vo);
				$matricula = $UsuariosDAO->persist($vo);//, null, false, true);
				$logger->logar($vo);
				
				$em->commit();

				$result = json_encode(array("resultado"=> true, "mensagem"=> "Dados do usuário $matricula, salvos com sucesso!"));

			}catch (Exception $e){

				$em->rollBack();
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
							": Erro ao gravar dados de usuários!", "exception" => $e->getTraceAsString()
						)
					);

			}

			echo $result;

			break;

		case 'EXCLUIR_USUARIO':

			if (!user_has_access("CADASTRO_USUARIOS_EXCLUIR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo.", "dialog-manut-ativo-view" );
				die();
			}

			$result = "[]";

			$result = validaUsuarioMatricula($_REQUEST);

			if ($result === true) {

				$matricula = $_REQUEST["UsuarioMatricula"];
				
				try{

					$em->beginTransaction();

					$vo = $UsuariosDAO->find($matricula);
					$logger->prepararLog($vo);				
					$vo->setUsuarioAtivo(0);
					$UsuariosDAO->update($vo);
					$logger->logar($vo);

					//$UsuariosDAO->execute("UPDATE tblUsuarios SET UsuarioAtivo = 0 WHERE UsuarioMatricula = ':matricula'", array(":matricula" => $matricula));
					$em->commit();

					$result = json_encode(array("resultado"=> true, "mensagem"=>"O usuário $matricula foi excluido com sucesso!"));

				}catch (Exception $e){

					$em->rollBack();
					$result = 
						json_encode(
							array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
								": Erro ao excluir o usuário $matricula!", "exception" => $e->getTraceAsString()
							)
						);
				}
			}
			
			echo $result;
			break;	

		case "PROCURAR_USUARIO":
			$usrs = $UsuariosDAO->findLDAP($_REQUEST["UsuarioMatricula"]);

			if (count($usrs)>0) {
					$nome = explode(" ", $usrs["UsuarioNome"]);
					foreach ($nome as &$palavra) {
						$palavra = strtolower($palavra);
						if (!in_array($palavra, array("de", "da", "do", "dos", "das", "as", "e", "os"))) $palavra = ucfirst($palavra);					}
					$usrs["UsuarioNome"] = implode(" ", $nome); 
				echo json_encode($usrs);
			} else echo json_encode(array("resultado"=> false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': A matrícula informada não foi encontrada.'));
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

		if (!validaUsuarioMatricula($post)) return !validaUsuarioMatricula($post);
		
		if (!isset($post['UsuarioNome']))
			return json_encode(array("resultado" => false, "mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O nome não foi enviado.'));

		$post_nome = trim($post['UsuarioNome']);
		if (strlen($post_nome) < 4 or stripos($post_nome, ' ') === false)
			return json_encode(array("resultado" => false, "mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': Nome inválido. Por favor, preencha com o nome completo.'));

		return true;
	}

	function validaUsuarioMatricula($post){

		$post_matricula = mb_strtolower($post['UsuarioMatricula']);
		
		if (!preg_match('/^\w\d{6}$/', $post_matricula))
			return json_encode(array("resultado" => false, "mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': Matrícula inválida. Por favor, preencha no padrão C999999.'));

		if (!isset($post_matricula)) 
			return json_encode(array("resultado" => false, "mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': A matrícula não foi enviada.'));
		return true;

	}

?>
