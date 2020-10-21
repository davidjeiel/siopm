<?php

	class CapturaControleEventos{

		private $user;		
		private $capturaControleDAO;
		private $ativosDAO;
		private $planilhaAtivosDAO;
		private $planilhaEventosDAO;
		private $eventosTiposDAO;
		private $capturaDemonstrativoDAO;
		private $eventosDAO;
		private $fechamentoCompetenciaDAO;
		private $transacoesDAO;
		private $capturaTesourariaDAO;
		private $em;

		public function __construct($em, $user){
			$this->em = $em;
			$this->user = $user;			
			$this->capturaControleDAO = new CapturaControleDAO($em);
			$this->ativosDAO = new ativosDAO ($em);
			$this->planilhaAtivosDAO 	= new CapturaPlanilhaAtivosDAO($em);
			$this->planilhaEventosDAO 	= new CapturaPlanilhaEventosDAO($em);
			$this->eventosTiposDAO = new EventosTiposDAO($em);
			$this->capturaDemonstrativoDAO = new CapturaDemonstrativoDAO($em);
			$this->eventosDAO = new EventosDAO($em);
			$this->fechamentoCompetenciaDAO = new FechamentoCompetenciaDAO($em);
			$this->transacoesDAO = new TransacoesDAO($em);
			$this->capturaTesourariaDAO = new CapturaTesourariaDAO($em);
		}

		public function conciliarValores($controleid){

			$dadosControle = $this->capturaControleDAO->findByID($controleid);

			if (empty($dadosControle['DataCaptura']) ){
				$result = json_encode(array("resultado" => false, "mensagem" =>"É necessário rodar a macro de captura do saldo contábel para os títulos do arquivo!"));
				die($result);
			}
			if (!empty($dadosControle['DataConciliacao']) ){
				$result = json_encode(array("resultado" => false, "mensagem" =>"Arquivo já conciliado!"));
				die($result);
			}

			$listaPlanilhaAtivos = $this->dadosPlanilhaAtivos($controleid);

			foreach ($listaPlanilhaAtivos as $capturaDados) {

				$this->verificarCompetenciaFechada($capturaDados["DataEvento"]);
				$voDemonstrativo = $this->criarVoSaldoDevedor($capturaDados);
				$transacaoID = $this->gravarTransacao($capturaDados, $voDemonstrativo);
				//$transacaoID = $this->gravarTransacao($capturaDados);
				$this->gravarPlanilhaAtivo($capturaDados, $voDemonstrativo, $transacaoID);
				//$this->gravarPlanilhaAtivo($capturaDados, $transacaoID);
				$this->gravarPlanilhaDemonstravivo($voDemonstrativo);
				$listaeventoscapturados = $this->dadosPlanilhaEventos($capturaDados["PlanilhaAtivosID"]);

				foreach ($listaeventoscapturados as $evento) {

					//$capturaTesouria =  $this->capturaControleDAO->verificarExistenciaLancamento($evento['DataEvento'],$evento['Valor']);
					//$capturaPlanilhaAtivo = $capturaPlanilhaAtivosDAO->findByID($evento["PlanilhaAtivosID"]);
						
						//if (isset($capturaTesouria["ID"]) && $capturaTesouria["ID"] > 0){
							if ($evento["TipoEventoID"] == 3){
								$valorTaxa = $this->capturaControleDAO->pegarTaxadeRisco($evento["ControleID"], $evento["DataEvento"], $evento["AtivoID"]);
								
								if($valorTaxa == null){									
									$result = json_encode(array("resultado" => false, "mensagem" =>"Arquivo possue um ativo sem lançamento de Taxa de Risco!"));
										$this->em->rollback();
									die ($result);
								}

								$evento["Valor"] = $evento["Valor"] - $valorTaxa;
							}							
							$eventoID = $this->gravarEvento($transacaoID,$evento);
							//$this->gravarPlanilhaEvento($evento["PlanilhaEventosID"], $capturaTesouria["ID"], $eventoID);
							$this->gravarPlanilhaEvento($evento["PlanilhaEventosID"], $eventoID);
							//$this->gravarTesouraria($capturaTesouria["ID"]);
						//}

				}//endforeach da lista de eventos

				
			}//endforeach da lista planilha ativo

			$this->gravarControle($controleid);	


		}

		private function dadosPlanilhaAtivos($id){
			try {

				$listaPlanilhaAtivos = $this->capturaControleDAO->listPlanilhaAtivosByControleId($_REQUEST["ArquivoCapturadoID"]);				
				
				$totalLinhas = count($listaPlanilhaAtivos); 
				if ($totalLinhas < 1){
					$result = json_encode(array("resultado" => false, "mensagem" =>"Arquivo não possui eventos para concialiação!"));
					die($result);
				}

				return $listaPlanilhaAtivos;
				
			} catch (Exception $e) {
				throw new Exception("Error Processing Request", 1);
			}
		}
		
		private function dadosPlanilhaEventos($id){
			try {

					$listaeventoscapturados = $this->capturaControleDAO->listEventosByPlanilhaAtivoId($id);	
					$totalLinhas = count($listaeventoscapturados);

					if($totalLinhas==0){
						//$em->pr($capturaDados);
						$result = json_encode(array("resultado" => false, "mensagem" =>"Não foram encontrados eventos capturados!"));
						$this->em->rollback();
						die($result);
					}

					return $listaeventoscapturados;

				
			} catch (Exception $e) {
				throw new Exception("Error Processing Request", 1);
			}
		}

		private function gravarTransacao($capturaDados, $voDemonstrativo){

			$voTransacao = New Transacoes();
			$voTransacao->setAtivoID($capturaDados["AtivoID"]);
			$voTransacao->setTransacaoData($capturaDados["DataEvento"]);
			$voTransacao->setSaldoDevedor(0.00);//pegar da tabela de demonstrativo, pesquisar pela data do evento.
			$voTransacao->setSaldoDevedor($voDemonstrativo->getValorContabil());//pegar da tabela de demonstrativo, pesquisar pela data do evento.
			// $logger->prepararLog($voTransacao);
			return $transacaoID = $this->transacoesDAO->persist($voTransacao);
			// $logger->logar($voTransacao);
		}

		private function gravarPlanilhaAtivo($capturaDados, $voDemonstrativo, $transacaoID){

			$voCapturaPlanilhaAtivos =  $this->planilhaAtivosDAO->findVoByID($capturaDados["PlanilhaAtivosID"]);//pegar o vo pelo id
			$voCapturaPlanilhaAtivos->setTransacaoID($transacaoID);
			$voCapturaPlanilhaAtivos->setDemonstrativoID($voDemonstrativo->getId());
			//$logger->prepararLog($voCapturaPlanilhaAtivos);
			$this->planilhaAtivosDAO->update($voCapturaPlanilhaAtivos);
			//$logger->logar($voCapturaPlanilhaAtivos);	

		}

		private function gravarPlanilhaDemonstravivo($voDemonstrativo) {

			$voDemonstrativo->setDataConciliacao(date("Y-m-d", time()));
			$this->capturaDemonstrativoDAO->update($voDemonstrativo);

		}

		private function gravarEvento($transacaoID, $evento){			

			try {
				$voEventos = New Eventos();
				$voEventos->setTransacaoID($transacaoID);
				$voEventos->setEventoTipoID($evento["TipoEventoID"]);
				$voEventos->setEventoValor($evento['Valor']);
				//$logger->prepararLog($voEventos);
				$eventoID = $this->eventosDAO->persist($voEventos);
				//$logger->logar($voEventos);
				return $eventoID;	
				
			} catch (Exception $e) {
				throw new Exception("Não foi pssível gravar o evento.", 1);
			}
		}

		private function gravarPlanilhaEvento($planilhaEventosID, $eventoID){			

			try {
				$voCapturaPlanilhaEventos = $this->planilhaEventosDAO->findVOByID($planilhaEventosID);
				//$voCapturaPlanilhaEventos->setCapturaTesourariaID($capturaTesouriaID);
				$voCapturaPlanilhaEventos->setEventoID($eventoID);
				$this->planilhaEventosDAO->update($voCapturaPlanilhaEventos);				
			} catch (Exception $e) {
				throw new Exception("Não foi pssível gravar o evento.", 1);
			}
		}

		private function gravarTesouraria($id){

			try {
				$voTesouraria = $this->capturaTesourariaDAO->findVOByID($id);
				$voTesouraria->setDataConciliacao(date("Y-m-d H:i:s", time()));			
				// $logger->prepararLog($voControle);
				$this->capturaTesourariaDAO->update($voTesouraria);
				// $logger->logar($voControle);
				
			} catch (Exception $e) {
				throw new Exception("Erro ao gravar a captura de arquivo", 1);
			}
		
		}

		private function gravarControle($id){

			try {
				$voControle = $this->capturaControleDAO->findVOByID($id);
				$voControle->setDataConciliacao(date("Y-m-d H:i:s", time()));
				$voControle->setConciliador($this->user->getUsuarioMatricula());
				// $logger->prepararLog($voControle);
				return (int) $this->capturaControleDAO->persist($voControle);
				// $logger->logar($voControle);
					
			} catch (Exception $e) {
				throw new Exception("Erro ao gravar a captura de arquivo", 1);
			}
		
		}

		private function verificarCompetenciaFechada($data)	{			

			$competencia = PPOEntity::toDateBr($data, "Y-m");
			$competenciaFechada = $this->fechamentoCompetenciaDAO->verificarSeCompetenciaFechada($competencia);
			
			$total = count($competenciaFechada); 	
			
			if ($total > 0){

				$result = json_encode(array("resultado" => false, "mensagem" =>$competencia."|". $competenciaFechada["Competencia"].$total. "Competência fechada para lançamentos!"));
				$this->em->rollback();
				die($result);
			}	

		}

		private function criarVoSaldoDevedor($capturaDados)	{

			$voDemonstrativo = $this->capturaDemonstrativoDAO->findByCodigoAtivoAndData($capturaDados["CodigoAtivo"],$capturaDados["DataEvento"]);

			if (count($voDemonstrativo->getID()) === 0){
				$result = json_encode(array("resultado" => false, "mensagem" =>"Não foi realizado captura do saldo para data informada!" . $capturaDados["CodigoAtivo"] . "-" . $capturaDados["DataEvento"]));
				$this->em->rollback();
				die($result);
			}else{

				return $voDemonstrativo;
			}	

		}

	}
	
?>