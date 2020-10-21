<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$controllerFile = "/controllers/ativos.eventos.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";
	
	$titulo_form  		= "Ativo Financeiro";

	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac']; 
	
	$ativosDAO					= new AtivosDAO($em);
	$transacoesDAO				= new TransacoesDAO($em);
	$eventosDAO					= new EventosDAO($em);
	$ativosTiposEventosTiposDAO	= new AtivosTiposEventosTiposDAO($em);
	$ativosSaldosDAO			= new AtivosSaldosDAO($em);
	$fechamentoCompetenciaDAO 	= new FechamentoCompetenciaDAO($em);

	switch ($action) {


		case 'LISTAR_SALDOS_CRI':
			
			$listasaldos = $ativosSaldosDAO->listAllSaldosByIDAtivo($_REQUEST["AtivoID"]);	
			
			require $siopm->getForm('ativos.saldos.list');
			
			break;

		case 'LISTAR_EVENTOS_CRI':

			$titulo_da_pagina = "Eventos Financeiros - CRI";

			$ativos = $ativosDAO->listAllAtivasCRIEventos();

			require $siopm->getTemplate('eventos.cri'); 

			break;

		case 'EDITAR_TRANSACOES':
		case 'LISTAR_TRANSACOES_PARA_VISUALIZAR':
		case 'LISTAR_TRANSACOES_PARA_TABELA':

			if (isset($_REQUEST["AtivoID"]) && $_REQUEST["AtivoID"] > 0){

				$titulo_form .= " - Eventos Financeiros";
				$ativo = $ativosDAO->findByID($_REQUEST["AtivoID"]);
				$transacoes = array();
				$transacoes = $transacoesDAO->listAllByAtivoID($_REQUEST["AtivoID"]);

				if ($action == 'EDITAR_TRANSACOES'){
					if (!user_has_access("CRI_EVENTOS_TRANSACOES_EDITAR")) { 
						$result = json_encode(array("resultado" => false, "mensagem" => "Você não possui permissão para excluida editar uma transação!"));
					}
					require $siopm->getForm('ativos.transacoes');
				}else if ($action == 'LISTAR_TRANSACOES_PARA_TABELA'){
					if (!user_has_access("CRI_EVENTOS_TRANSACOES")) { 
						$result = json_encode(array("resultado" => false, "mensagem" => "Você não possui permissão para excluida editar uma transação!"));
					}
					require $siopm->getForm('ativos.transacoes.table');
				}else 
					if (!user_has_access("CRI_EVENTOS_TRANSACOES")) { 
						$result = json_encode(array("resultado" => false, "mensagem" => "Você não possui permissão para excluida editar uma transação!"));
					}
					require $siopm->getForm('ativos.transacoes.view'); 
			}

			break;

		case "EXCLUIR_TRANSACAO":

			//HAS_ACCESS(PERMISSAO_PRA_GRAVAR_DE_QQ_MANEIRA);
			//QUANDO EXCLUIR TRANSACAO
			//APENAS PERMITE EXCLUIR TRANSACOES DO MES ATUAL E ANTERIOR.  

			$result = "[]";

			if (!user_has_access("CRI_EVENTOS_TRANSACOES_EXCLUIR")) {

				$result = json_encode(array("resultado" => false, "mensagem" => "Você não possui permissão para excluida um  Ativo cadastrado!"));

			}else if (isset($_REQUEST["TransacaoID"]) && $_REQUEST["TransacaoID"] != ""){
				try{

					$em->beginTransaction();
					$transacaoID = $_REQUEST["TransacaoID"];

					$sql = "DELETE FROM tblEventos WHERE TransacaoID = $TransacaoID";					
					$eventosDAO->execute($sql);

					$votran = $transacoesDAO->find($transacaoID);
					$logger->logarExclusao($votran);
					$transacoesDAO->delete($votran);
					

					$em->commit();

					$result = json_encode(array("resultado"=> true,"mensagem"=> "Transação excluida com sucesso!"));

				}catch (Exception $e){

					$em->rollBack();
					$result = 
						json_encode(
							array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
								": Erro ao tentar excluir transações!", "exception" => $e->getTraceAsString()
							)
						);

				}


			}else{
				$result = '{"resultado" : false, "mensagem" : "O identificador da transação não foi passado corretamente!"}';
			}

			echo $result;
			
			break;

		case 'EDITAR_EVENTOS':

			if (isset($_REQUEST["AtivoID"]) && $_REQUEST["AtivoID"] > 0){

				$ativo = $ativosDAO->findByID($_REQUEST["AtivoID"]);
				$eventosExistentes = array();
				$eventosTipos = $ativosTiposEventosTiposDAO->listAllEventosTiposCRI();

				if (isset($_REQUEST["TransacaoID"]) && $_REQUEST["TransacaoID"] > 0){
					$transacao = $transacoesDAO->findArrayByID($_REQUEST["TransacaoID"]);
					$eventos = $eventosDAO->listByTransacaoID($_REQUEST["TransacaoID"]);									

					if (isset($eventos)) foreach ($eventos as $key => $value) {
						if(isset($value["EventoID"])) $eventosExistentes[$value["EventoTipoID"]] = $value["EventoValor"];
					}
					$titulo_form .= " - Editar Transação";
				}else{
					$titulo_form .= " - Nova Transação";
				}	
				require $siopm->getForm('ativos.eventos');

			}

			break;

		case "SALVAR_EVENTOS":
		
			try{

				if (!user_has_access("CRI_EVENTOS_TRANSACOES_EDITAR")) {

					$result = json_encode(array("resultado" => false, "mensagem" => "Você não possui permissão para excluida um  Ativo cadastrado!"));

				}else if (isset($_REQUEST["AtivoID"]) && $_REQUEST["AtivoID"] != ""){

					$em->beginTransaction();					
					$voTransacao = $transacoesDAO->fillEntitybyRequest($_REQUEST);					

					//comecar aqui o teste
					if (!user_has_access("CRI_EVENTOS_SALVAR_PRIVILEGIADO")) {

						$competencia = $voTransacao->getTransacaoData("Y-m");
						$competenciaFechada = $fechamentoCompetenciaDAO->verificarSeCompetenciaFechada($competencia);
						
						$total = count($competenciaFechada); 	
						
						if ($total > 0){

							$result = json_encode(array("resultado" => false, "mensagem" =>$competencia."|". $competenciaFechada["Competencia"].$total. "Competência fechada para lançamentos!"));
							$em->rollback();
							die($result);
						}
						
					}
					//termina aqui
					
					
					//HAS_ACCESS(CRI_EVENTOS_SALVAR_PRIVILEGIADO);

					//QUANDO SALVAR TRANSACAO
					// Verificar se existe transacão cadastrada para o mes/ano do POST
					// SE NAO EXISTIR PERMITE GRAVAR
					// SE EXISTIR UMA TRANSACAO JA CADASTRADA, APENAS PERMITE GRAVAR TRANSACOES DO MES ATUAL E ANTERIOR.  

					if (strtotime($voTransacao->getTransacaoData("Y-m-d")) < strtotime(PPOEntity::toDateUnicode($_REQUEST["AtivoDataEmissao"], "Y-m-d"))){
						$result = json_encode(array("resultado"=> false, "erroID" => "ERRO_DATA_INFERIOR",
							"mensagem"=> "A data da transação não pode ser anterior à data de emissão."));
						$em->rollback();
						die($result);
					}

					if (strtotime($voTransacao->getTransacaoData("Y-m-d")) > strtotime(PPOEntity::toDateUnicode($_REQUEST["AtivoDataVencimento"], "Y-m-d"))){
						$result = json_encode(array("resultado"=> false, "erroID" => "ERRO_DATA_SUPERIOR",
							"mensagem"=> "A data da transação não pode ser posterior à data de vencimento."));
						$em->rollback();
						die($result);
					}

					if ($transacoesDAO->existeTransacao($voTransacao)){
						$result = json_encode(array("resultado"=> false, "erroID" => "ERRO_DATA_EXITE",
							"mensagem"=> "Já existe uma transação cadastrada no dia " . $voTransacao->getTransacaoData("d/m/Y") . "."));
						$em->rollback();
						die($result);
					}

					$logger->prepararLog($voTransacao);
					$TransacaoID = $transacoesDAO->persist($voTransacao);
					$logger->logar($voTransacao);

					$sql = "DELETE FROM tblEventos WHERE TransacaoID = $TransacaoID";

					if ($TransacaoID > 0) {
						$eventosDAO->execute($sql);
						$eventosTipos = $ativosTiposEventosTiposDAO->listAllEventosTiposCRI();
						$valorTotalEventos = 0.00;
						$TotalJurosTaxaRisco = 0.00;
						foreach($eventosTipos as $eventos) {

							if (
								isset($_REQUEST["eventotipo_" . $eventos["EventoTipoID"]])
								&& $_REQUEST["eventotipo_" . $eventos["EventoTipoID"]] > 0
							)
							{
								$vo = New Eventos();
								$vo->setTransacaoID($TransacaoID);
								$vo->setEventoTipoID($eventos["EventoTipoID"]);
								$vo->setEventoValor($_REQUEST["eventotipo_" . $eventos["EventoTipoID"]]);
								$logger->prepararLog($vo);
								$vo->setEventoID((int)$eventosDAO->persist($vo));
								$logger->logar($vo);
								$valorTotalEventos += $vo->getEventoValor();
							}
						 	
						}
						
						if ($valorTotalEventos > 0){
							$juros = 0.00;
							$risco = 0.00;
							if (isset($_REQUEST["eventotipo_3"]) && $_REQUEST["eventotipo_3"] > 0) $juros = $_REQUEST["eventotipo_3"];
							if (isset($_REQUEST["eventotipo_5"]) && $_REQUEST["eventotipo_3"] > 0) $risco = $_REQUEST["eventotipo_4"];
							$em->commit();
							$result = json_encode(array(
										"resultado"=> true, 
										"mensagem"=> "Transação salva com sucesso!" , 
										"totaleventos" => PPOEntity::toMoneyBr($valorTotalEventos),
										"totaljurosrisco" => PPOEntity::toMoneyBr($juros + $risco),
										"transacaoid" => $TransacaoID));
						}else{
							$em->rollback();
							$result = json_encode(array("resultado"=> false, "erroID" => "TOTAL_EVENTOS_ZERADOS", "mensagem"=> "É necessário preencher um dos campos de evento financeiro com valor diferente de “R$ 0,00”" , "transacaoid" => $TransacaoID));
						}
					}else{
						$result = json_encode(array("resultado"=> false, "erroID" => "ERRO_GRAVAR_TRANSACAO", "mensagem"=> "Erro ao gravar a transação!"));
						$em->rollback();
					}


				}else{
					$result = json_encode(array("resultado"=> false, "erroID" => "ERRO_ATIVOID", "mensagem"=> "O identificador do ativo não foi passado corretamente."));
				}

			}catch (Exception $e){

				$em->rollBack();
				$result = 
					json_encode(
						array("resultado"=> false, "erroID" => "ERRO_DESCONHECIDO", "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
							": Erro ao gravar a transação!", "exception" => $e->getTraceAsString()
						)
					);

			}

			echo $result;


			break;

		case 'EDITAR_SALDO':
	
			$formTitulo = "Ativo Financeiro - Saldos Mensais";
			
			$listasaldos 	= array();
			$ativoSaldo 	= array();

			if (isset($_REQUEST["AtivoID"]) && $_REQUEST["AtivoID"] != ""){
					$listasaldos = $ativosSaldosDAO->listAllSaldosByIDAtivo($_REQUEST["AtivoID"]);
			}

			if (isset($_REQUEST["AtivoID"]) && $_REQUEST["AtivoID"] > 0) {
			 		$ativoDadoBasico = $ativosDAO->findByID($_REQUEST["AtivoID"]);
			}
			
			if (isset($_REQUEST["SaldoID"]) && $_REQUEST["SaldoID"] > 0) {
			 		$ativoSaldo = $ativosSaldosDAO->findByID($_REQUEST["SaldoID"]);
			}
			
			//$em->pr($ativoDadoBasico );

			require $siopm->getForm('ativos.saldos');
			
			break;

		case 'SALVAR_SALDO':

			$result = "[]";
			$result = true;	
 			
 			$ativoid = $_REQUEST["AtivoID"];
			//$result = validaDados($_REQUEST);
			
			if ($result === true) try{

				$em->beginTransaction();
				$vo =  new AtivosSaldos();
				$vo = $ativosSaldosDAO->fillEntitybyRequest($_REQUEST);	
				$saldoID = $ativosSaldosDAO->persist($vo);
				$em->commit();

				$result = json_encode(array("resultado"=> true, "ativoid" => $ativoid, "mensagem"=> "Informações do Saldo do Ativo Financeiro salvos com Sucesso!" , "saldoid" => $saldoID));

			}catch (Exception $e){

				$em->rollBack();
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
							": Erro ao gravar Informações do Saldo do Ativo Financeiro !", "exception" => $e->getTraceAsString()
						)
					);

			}

			echo $result;
			break;

		case 'EXCLUIR_SALDO':

			$result = "[]";
			$result = true;

			if ($result === true) {

				$saldoid = $_REQUEST["SaldoID"];

				try {

					$em->beginTransaction();
					$ativosSaldosDAO->execute("DELETE tblAtivosSaldos where SaldoID = ':saldoid'", array(":saldoid" => $saldoid));
					$em->commit();
					$result = json_encode(array("resultado" => true, "mensagem" => "Saldo excluído com sucesso!"));

				} catch (Exception $e) {

					$em->rollBack();
					$result = 
						json_encode(
							array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
								": Erro ao excluir Saldo $saldoid!", "exception" => $e->getTraceAsString()
							)
						);

				}

			}

			echo $result;
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

?>
