<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$controllerFile = "/controllers/ativos.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";

	$result = array();	

	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac']; 

	//if($user->getUsuarioMatricula() == "c091636") $siopm->getHtmlError("Você não possui acesso a este módulo.");

	if (!user_has_access("CRI_ATIVOS")) $siopm->getHtmlError("Você não possui acesso a este módulo.");

	$ativosDAO					= new AtivosDAO($em);
	$modalidadesDAO				= new ModalidadesDAO($em);
	$subscricoesDAO				= new SubscricoesDAO($em);
	$ativosSituacoesDAO			= new AtivosSituacoesDAO($em);
	$ativosSubtiposDAO			= new AtivosSubtiposDAO($em);
	$ativosLiquidacoesTiposDAO 	= new AtivosLiquidacoesTiposDAO($em);
	$diasAnosDAO				= new DiasAnosDAO($em);
	$diasBasesDAO				= new DiasBasesDAO($em);
	$intervalosDAO				= new IntervalosDAO($em);
	$ativosJurosTiposDAO		= new AtivosJurosTiposDAO($em);
	$ativosAmortizacoesTiposDAO	= new AtivosAmortizacoesTiposDAO($em);
	$jurosDAO					= new JurosDAO($em);
	$ativosEntidadesDAO			= new AtivosEntidadesDAO($em);
	$ativosGarantiasDAO			= new AtivosGarantiasDAO($em);
	$indexadoresDAO				= new IndexadoresDAO($em);
	$garantiasDAO 				= new GarantiasDAO($em);
	$integralizacoesDAO			= new IntegralizacoesDAO($em);
	$ativoArquivosDAO 			= new AtivosArquivosDAO($em);
	$ativoArquivosTiposDAO 		= new AtivosArquivosTiposDAO($em);

	$titulo_form = "Ativo Financeiro";

	switch ($action) {

		case 'LISTAR_ATIVOS_ATUALIZACAO':
		case 'LISTAR_ATIVOS':
			$db_ativos_arr = $ativosDAO->listAllAtivasCRI();
			require $siopm->getTemplate('ativos');
			if ($action == "LISTAR_ATIVOS_ATUALIZACAO") echo $contents;
			break;

		case 'arquivos':
			$titulo_form .= " - Cadastrar Arquivos";
			if (isset($_REQUEST["AtivoID"]) && $_REQUEST["AtivoID"] > 0){
				$ativo = $ativosDAO->findByID($_REQUEST["AtivoID"]);
				$arquivos = $ativoArquivosDAO->listAquivosByAtivoID($_REQUEST["AtivoID"]);
				$arquivosTipos = $ativoArquivosTiposDAO->listAll();
				require $siopm->getForm('ativos.arquivos');
			} else {
				echo $siopm->getErrorModal("Não foi passado o id do ativo corretamente");
			}
			break;


		case 'VISUALIZAR_DADOS_CADASTRADOS':

			$tituloForm = "Ativo Financeiro - Visualizar Dados Cadastrados";
			if(!user_has_access("CRI_ATIVOS_VISUALIZAR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo.", "dialog-manut-ativo-view" );
				die();
			}

			$ativoDadoBasico 			= array();
			$ativosGarantiasExistentes 	= array();
			$ativosGarantias 			= array();
			$modalidades 				= $modalidadesDAO->listAll();
			$liquidacoes 				= $ativosLiquidacoesTiposDAO->listAll();
			$ativosSituacoes 			= $ativosSituacoesDAO->listAll();
			$ativosSubtipos 			= $ativosSubtiposDAO->listAll();
			$indexadores 				= $indexadoresDAO->listAll();
			$diasano 					= $diasAnosDAO->listAll();
			$diasbase 					= $diasBasesDAO->listAll();
			$intervalos 				= $intervalosDAO->listAll();
			$jurostipos 				= $ativosJurosTiposDAO->listAll();
			$amortizacaostipos 			= $ativosAmortizacoesTiposDAO->listAll();
			$garantias 					= $garantiasDAO->listAll();

			if (isset($_REQUEST["AtivoID"]) && $_REQUEST["AtivoID"] > 0) {
				$AtivoDadoBasico  = $ativosDAO->findByID($_REQUEST["AtivoID"]);
				$ativosGarantias  = $ativosGarantiasDAO->listByAtivoID($_REQUEST["AtivoID"]);
				$listasubscricoes = $subscricoesDAO->listAllByIDAtivo($_REQUEST["AtivoID"]);
				$arquivos = $ativoArquivosDAO->listAquivosByAtivoID($_REQUEST["AtivoID"]);
				//$listaintegralizacoes = $integralizacoesDAO->listAllBySubscricaoID($listasubscricoes["SubscricoesID"]);
				$listaentidades  = $ativosEntidadesDAO->listAllByIDAtivo($_REQUEST["AtivoID"]);
				$listajuros      = $jurosDAO->listAllJurosByIDAtivo($_REQUEST["AtivoID"]);
			}

			if (isset($ativosGarantias)) foreach ($ativosGarantias as $key => $value) {
					if(isset($value["GarantiaID"])) $ativosGarantiasExistentes[] = $value["GarantiaID"];
			}

			require $siopm->getForm('ativos');
			
			break;


		case 'EXCLUIR_ATIVO':

			if (!user_has_access("CRI_ATIVOS_EXCLUIR")) {

				$result = json_encode(array("resultado" => false, "mensagem" => "Você não possui permissão para excluida um  Ativo cadastrado!"));

			}else if (isset($_REQUEST["AtivoID"]) && $_REQUEST["AtivoID"] != "") {

				$ativoID = $_REQUEST["AtivoID"];

				try {

					$em->beginTransaction();

					$vo = $ativosDAO->find($ativoID);
					$vo->setAtivoAtivo(0);
					$ativosDAO->update($vo);
					//$ativosDAO->execute("UPDATE tblAtivos SET AtivoAtivo = 0 WHERE AtivoID = ':ativoid'", array(":ativoid" => $ativoID));
					$em->commit();
					$result = json_encode(array("resultado" => true, "ativoid" => $ativoID, "mensagem" => "Ativo excluido com sucesso!"));

				} catch (Exception $e) {

					$em->rollBack();
					$result = 
						json_encode(
							array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
								": Erro ao excluir Ativo!", "exception" => $e->getTraceAsString()
							)
						);

				}

			}

			echo $result;
			break;

		default:

			if (isset($_REQUEST['ac'])) {

				$post_acao = $_REQUEST['ac'];

				if (!in_array($post_acao, array('LISTAR_ATIVOS','EXCLUIR_ATIVO','VISUALIZAR_DADOS_CADASTRADOS'))) {
					echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O campo "ação" não foi indicado corretamente.'));
					exit;
				}

			} else {
				echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': USUARIO POST AC NAO DEFINIDO.'));
			}

			break;

	}

?>
