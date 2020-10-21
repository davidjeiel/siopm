<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$controllerFile = "/controllers/orcamentos.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";
	
	$result = array();

	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac'];
	if (!user_has_access("CRI_ORCAMENTO")) $siopm->getHtmlError("Você não possui acesso a este módulo");

	$OrcamentosDAO = new OrcamentosDAO($em);


	switch ($action) {

		case 'LISTAR_ORCAMENTOS':
		case 'LISTAR_ORCAMENTOS_ATUALIZACAO':
			$db_orcamentos_arr = $OrcamentosDAO->listAllAtivaCRI();
			require $siopm->getTemplate('orcamentos');
			if ($action == "LISTAR_ORCAMENTO_ATUALIZACAO") echo $contents;
			break;

		case 'VISUALIZAR_VALOR_APLICADO':

			$tituloForm = "Orçamentos - CRI";

			if (!user_has_access("CRI_ORCAMENTO_DETALHES")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-orcamento-valor-aplicado");
				die();
			}

			$orcamento 			= array();
			$listasubscricoes 	= array();

			if (isset($_REQUEST["OrcamentoID"]) && $_REQUEST["OrcamentoID"] > 0) {
			 	$orcamento  = $OrcamentosDAO->getOrcamentoByID($_REQUEST["OrcamentoID"]);
			 	$listasubscricoes = $OrcamentosDAO->listSubscricoesByOrcamentoID($_REQUEST["OrcamentoID"]);
			}

			require $siopm->getForm('orcamentos.list.aplicacao');
			
			break;

		case 'EDITAR_ORCAMENTO':

			if (!user_has_access("CRI_ORCAMENTO_EDITAR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-orcamento" );
				die();
			}

			$subTitulo = "Inclusão";

			$arr = null;

			if (isset($_REQUEST["OrcamentoID"]) && $_REQUEST["OrcamentoID"] > 0) {
				$arr = $OrcamentosDAO->getOrcamentoByID($_REQUEST["OrcamentoID"]);
				$subTitulo = "Edição";
			}

			require $siopm->getForm('orcamentos');

			break;

		case 'SALVAR_ORCAMENTO':

			if (!user_has_access("CRI_ORCAMENTO_EDITAR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-orcamento" );
				die();
			}

			$OrcamentoAno = "";
			$result = "[]";
			$result = true;
			//$result = validaDados($_REQUEST);
			$OrcamentoAno = $OrcamentosDAO->hasOrcamentoAnoCRI($_REQUEST["OrcamentoAno"]);

			if ($OrcamentoAno && $_REQUEST["OrcamentoID"] == "") {

				$result = json_encode(array("resultado"=> false, "mensagem"=> "O Orçamento de " . $_REQUEST["OrcamentoAno"] . " já está cadastrado! Você deve editá-lo para alterar os dados"));

			} else if ($result === true) {

				try {

					$em->beginTransaction();
					$vo = $OrcamentosDAO->fillEntitybyRequest($_REQUEST);

					$logger->prepararLog($vo);
					$orcamentoid = $OrcamentosDAO->persist($vo);
					$logger->logar($vo);
					$em->commit();
					$result = json_encode(array("resultado"=> true, "orcamentoid" => $orcamentoid, "mensagem"=> "Dados do orçamento de " . $_REQUEST["OrcamentoAno"] . " salvos com sucesso!" ));

				} catch (Exception $e) {

					$em->rollBack();
					$result =
						json_encode(
							array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) .
								": Erro ao gravar os dados do orçamento de " . $_REQUEST["OrcamentoAno"] . "!", "exception" => $e->getMessage() . " |TRACK==>" . $e->getTraceAsString()
							)
						);
				}

			}

			echo $result;
			break;

		case 'EXCLUIR_ORCAMENTO':

			if (!user_has_access("CRI_ORCAMENTO_EXCLUIR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-orcamento" );
				die();
			}			
			$result = "[]";
			//$result = validaUsuarioMatricula($_REQUEST);
			$result = true;

			if ($result === true) {

				$orcamentoid = $_REQUEST["OrcamentoID"];

				try {

					$em->beginTransaction();

					$vo = $OrcamentosDAO->find($orcamentoid);
					$logger->prepararLog($vo);				
					$vo->setOrcamentoAtivo(0);
					$OrcamentosDAO->update($vo);
					$logger->logar($vo);
					//$OrcamentosDAO->execute("UPDATE tblOrcamentos SET OrcamentoAtivo = 0 WHERE OrcamentoID = ':orcamentoid'", array(":orcamentoid" => $orcamentoid));
					$em->commit();
					$result = json_encode(array("resultado" => true, "mensagem" => "Orçamento excluído com sucesso!"));

				} catch (Exception $e) {

					$em->rollBack();
					$result =
						json_encode(
							array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) .
								": Erro ao excluir orçamento!", "exception" => $e->getTraceAsString()
							)
						);

				}

			}

			echo $result;
			break;

		default:
			if (isset($_REQUEST['ac'])) {

				$post_acao = $_REQUEST['ac'];

				if (!in_array($post_acao, array('LISTAR_ORCAMENTOS','EDITAR_ORCAMENTO','SALVAR_ORCAMENTO','EXCLUIR_ORCAMENTO'))) {
					echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O campo "ação" não foi indicado corretamente.'));
					exit;
				}

			} else {
				echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': USUARIO POST AC NAO DEFINIDO.'));
			}

			break;

	}
?>
