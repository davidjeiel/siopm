<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$controllerFile = "/controllers/ativos.fechamento.competencia.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";

	$result = array();

	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac'];
	if (!user_has_access("CRI_FECHAMENTO_COMPETENCIA")) $siopm->getHtmlError("Você não possui acesso a este módulo");

	$fechamentoCompetenciaDAO = new FechamentoCompetenciaDAO($em);
	$ativosDAO = new AtivosDAO ($em);
	$usuariosDAO = new UsuariosDAO($em);	

	switch ($action) {

		case 'LISTAR_COMPETENCIAS_FECHADAS':
		case 'LISTAR_COMPETENCIAS_FECHADAS_ATUALIZACAO':
			$listacompetencias = $fechamentoCompetenciaDAO->listAll();
			require $siopm->getTemplate('fechamentocompetencia');
			if ($action == "LISTAR_COMPETENCIAS_FECHADAS_ATUALIZACAO") echo $contents;
			break;

		case 'LISTAR_EVENTOS_CAPTURADOS':
			ob_clean();
			$tituloForm = "Detalhes do arquivo importado - Lista de Eventos";	
			$listaeventoscapturados = $capturaControleDAO->listEventosByControleId($_REQUEST["ArquivoCapturadoID"]);
			require $siopm->getForm('ativo.captura.eventos.detalhes');
			//if ($action == "LISTAR_EVENTOS_CAPTURADOS") echo $contents;
			break;

		case 'FECHAR_COMPETENCIA':

			if (!user_has_access("CRI_FECHAMENTO_COMPETENCIA_EDITAR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "fechar competencia" );
				die();
			}		

			$tituloForm = "Fechar Competência";			

			$ultimaCompetenciaFechada = $fechamentoCompetenciaDAO->pegarUltimaCompetenciaFechada();

			$competencia = PPOEntity::toDateBr(proximaCompetencia(PPOEntity::toDateBr($ultimaCompetenciaFechada['Competencia'], "d/m/Y")), "m/Y");
			$competenciaFormatadaParaBusca = PPOEntity::toDateBr(proximaCompetencia(PPOEntity::toDateBr($ultimaCompetenciaFechada['Competencia'], "d/m/Y")), "Y-m");
			$matricula = $user->getUsuarioMatricula();
			$dataFechamento = PPOEntity::toDateBr(date("Y-m-d H:i:s", time()));

			$listaativos = $fechamentoCompetenciaDAO->getListAtivosComTransacoesPorCompetencia($competenciaFormatadaParaBusca);

			//ativoDadoBasico["AtivoDataFinalizacao"] = PPOEntity::toDateBr(date("Y-m-d H:i:s", time()));
			//$inconsistencias = $ativoMsgErroDAO->listInconsistenciasAtivo($_REQUEST["AtivoID"]);	

			// if (isset($_REQUEST["OrcamentoID"]) && $_REQUEST["OrcamentoID"] > 0) {
			// 	$arr = $OrcamentosDAO->getOrcamentoByID($_REQUEST["OrcamentoID"]);
			
			// }

			//$em->pr("chegou aqui");

			$fechamentoCompetencia = array("Competencia" => $competencia, 
											"Matricula" => $matricula, 
											"DataFechamento" => $dataFechamento, 
											"ModalidadeID"=> "1");

			require $siopm->getForm('fechamento.competencia');

			break;

		case 'CONFIRMAR_FECHAMENTO_COMPETENCIA':

			if (!user_has_access("CRI_FECHAMENTO_COMPETENCIA_EDITAR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-ativo-fechar-competencia" );
				die();
			}			

			$result = "[]";
			$result = true;	 
			
			if ($result === true) try{

				$em->beginTransaction();
				
				$vo =  new FechamentoCompetencia();
				$vo = $fechamentoCompetenciaDAO->fillEntitybyRequest($_REQUEST);
				
				$ultimaCompetenciaFechada = $fechamentoCompetenciaDAO->pegarUltimaCompetenciaFechada();
				$competencia = PPOEntity::toDateBr(proximaCompetencia(PPOEntity::toDateBr($ultimaCompetenciaFechada['Competencia'], "d/m/Y")), "Y-m-d");
				
				$vo->setCompetencia($competencia);
				$logger->prepararLog($vo);			
				$fechamentoCompetenciaID = $fechamentoCompetenciaDAO->persist($vo);	
				$logger->logar($vo);		

				$em->commit();
				$result = json_encode(array("resultado"=> true, 
											"mensagem"=> "Competência fechada com sucesso!", 
											"jurosid" => $fechamentoCompetenciaID));

			}catch (Exception $e){

				$em->rollBack();
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
							": Erro ao gravar Informações de Juros do Ativo Financeiro !", "exception" => $e->getTraceAsString()
						)
					);

			}	
			
			echo $result;
			break;
	
			break;		

		default:
			if (isset($_REQUEST['ac'])) {

				$post_acao = $_REQUEST['ac'];

				if (!in_array($post_acao, array('list','edit','save', 'find'))) {
					echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O campo "ação" não foi indicado corretamente.'));
					exit;
				}

			} else {
				echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': USUARIO POST AC NAO DEFINIDO.'));
			}

			break;

	}

	function proximaCompetencia($competencia){		 

		if(count($competencia)>0){						
			$competencia = DateTime::createFromFormat('d/m/Y', $competencia)->modify('+1 month')->format('d/m/Y');
			return $competencia;
		}
		return $competencia;
	}	

?>
