<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$controllerFile = "/controllers/perfis.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";
	
	$result = array();
	
	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac']; 

	$PerfisDAO 				  = new PerfisDAO($em);
	$FuncionalidadesDAO 	  = new FuncionalidadesDAO($em);
	$PerfisFuncionalidadesDAO = new PerfisFuncionalidadesDAO($em);

	if (!user_has_access("CADASTRO_PERFIL")) $siopm->getHtmlError("Você não possui acesso a este módulo");

	switch ($action) {

		case 'LISTAR_PERFIS':
		case 'LISTAR_PERFIS_ATUALIZACAO':

			$db_perfis_arr = $PerfisDAO->listAllAtivas();
			
			if( $db_perfis_arr === null ) $db_perfis_arr = array(); 

			require $siopm->getTemplate('Perfis');

			/* 
			*	Em caso de utilizar o resultado em um ajax, deve-se 'imprimir' o conteúdo da variável $contents 
			*  	Quando a solicitação vem do INDEX, não é necessário pois, haverá um getTemplate('layout'), vindo do
			*  	index, chamando o layout principal, e este encarrega-se de imprimir $contents. A variável $contents é
			* 	utilizada e criada apensa em templates.
			*/
			if ($action == "LISTAR_PERFIS_ATUALIZACAO") echo $contents;

			break;

		case 'VISUALIZAR_PERFIL':
		case 'EDITAR_PERFIL':

			if (($action == "VISUALIZAR_PERFIL") && (!user_has_access("CADASTRO_PERFIL_VISUALIZAR"))) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-perfil" );
				die();
			}

			if (($action == "EDITAR_PERFIL") and (!user_has_access("CADASTRO_PERFIL_EDITAR"))) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-perfil" );
				die();
			}

			$arrPerfis = null;
			$arrFuncionalidades = null;
			$arrPerfisFuncionalidades = null;

			$arrFuncionalidadesExistentes =  array();

			$arrFuncionalidades = $FuncionalidadesDAO->listAll();

			if (isset($_REQUEST["PerfilID"])){
				$arrPerfis = $PerfisDAO->findByID($_REQUEST["PerfilID"]);
				$arrPerfisFuncionalidades = $PerfisFuncionalidadesDAO->listByPerfilID($_REQUEST["PerfilID"]);
			}

			foreach ($arrPerfisFuncionalidades as $key => $value) {
				if(isset($value["FuncionalidadeNome"])) $arrFuncionalidadesExistentes[] = $value["FuncionalidadeNome"];
			}

			require $siopm->getForm('perfis');

			break; 

		case 'SALVAR_PERFIL':

			if (!user_has_access("CADASTRO_PERFIL_EDITAR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-perfil" );
				die();
			}			

			$result = "[]";
			$result = validaDados($_REQUEST);

			if ($result === true) try{

				$em->beginTransaction();
				
				$PerfilID = $_REQUEST['PerfilID']; 
				
				$arrFuncionalidades = $FuncionalidadesDAO->listAll();
				
				if ($PerfilID > 0) $PerfisFuncionalidadesDAO->execute("DELETE FROM tblPerfisFuncionalidades WHERE PerfilId = :perfilid", array(":perfilid" => $PerfilID));

				$vo = new Perfis();

				$vo = $PerfisDAO -> fillEntityByRequest($_REQUEST);
				$logger->prepararLog($vo);
				$PerfilID = $PerfisDAO->persist($vo);
				$logger->logar($vo);


				foreach($arrFuncionalidades as $Funcionalidade) {

					if (isset($_REQUEST[$Funcionalidade["FuncionalidadeNome"]])){

						$pfVO = New PerfisFuncionalidades();
						$pfVO->setPerfilID($PerfilID);
						$pfVO->setFuncionalidadeID($Funcionalidade["FuncionalidadeID"]);
						$logger->prepararLog($pfVO);
						$PerfisFuncionalidadesDAO->persist($pfVO);
						$logger->logar($pfVO);
					}
				}

				$em->commit();
				$result = json_encode(array("resultado"=> true, "mensagem"=> "Os dados do perfil foram salvos com sucesso!" , "perfilid" => $PerfilID));

			}catch (Exception $e){

				$em->rollBack();
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
							": Erro ao gravar os dados do perfil!", "exception" => $e->getTraceAsString()
						)
					);

			}

			echo $result;
			break;

		case 'EXCLUIR_PERFIL':

			if (!user_has_access("CADASTRO_PERFIL_EXCLUIR")) {

				$result = json_encode(array("resultado" => false, "mensagem" => "Você não possui permissão para excluida uma habilitação!"));

			}else if (isset($_REQUEST["PerfilID"]) && $_REQUEST["PerfilID"] != ""){

				$PerfilID = $_REQUEST['PerfilID'];

				try{

					$em->beginTransaction();


					$vo = $PerfisDAO->find($PerfilID);
					$logger->prepararLog($vo);				
					$vo->setPerfilAtivo(0);
					$PerfisDAO->update($vo);
					$logger->logar($vo);


					//$PerfisDAO->execute("UPDATE tblPerfis SET PerfilAtivo = 0 WHERE PerfilID = ':perfilid'", array(":perfilid" => $PerfilID));
					$em->commit();

					$result = json_encode(array("resultado"=> true, "mensagem"=>"O perfil $PerfilID foi excluído com sucesso!"));

				}catch (Exception $e){

					$em->rollBack();
					$result = 
						json_encode(
							array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
								": Erro ao excluir Perfil $PerfilID!", "exception" => $e->getTraceAsString()
							)
						);
				}
			}
			
			echo $result;
			break;

		default:
			if (isset($_REQUEST['ac'])){
				$post_acao = $_REQUEST['ac'];
				if (!in_array($post_acao, array('LISTAR_PERFIS','EDITAR_PERFIL','SALVAR_PERFIL', 'VISUALIZAR_PERFIL', 'EXCLUIR_PERFIL'))) {
					echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O campo "ação" não foi indicado corretamente.'));
					exit;
				}
			} else echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': PERFIL POST AC NAO DEFINIDO.'));
			break;
	}

	function validaDados($post){

		$possuifuncionalidade = false;

		if (!isset($post['PerfilNome']))
			return json_encode(array("resultado" => false, "mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O nome do perfil não foi enviado.'));

		foreach($post as $linhas) {

			if ($linhas == "on") {
				$possuifuncionalidade = true;
			}
		}

		if (!$possuifuncionalidade)
			return json_encode(array("resultado" => false, "mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': Nenhuma funcionalidade foi selecionada.'));

		$post_nome = trim($post['PerfilNome']);

		if (strlen($post_nome) < 3)
			return json_encode(array("resultado" => false, "mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': Nome inválido. Por favor, preencha com o nome completo.'));

		return true;
	}

?>
