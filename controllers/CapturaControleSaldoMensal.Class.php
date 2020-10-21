<?php

	class CapturaControleSaldoMensal{

		private $em;
		private $user;				
		private $ativosDAO;
		private $ativosSaldosDAO;
		private $capturaDemonstrativoDAO;		
		private $fechamentoCompetenciaDAO;				
		

		public function __construct($em, $user){
			$this->em = $em;
			$this->user = $user;						
			$this->ativosDAO = new ativosDAO ($em);			
			$this->ativosSaldosDAO = new AtivosSaldosDAO($em);
			$this->capturaDemonstrativoDAO = new CapturaDemonstrativoDAO($em);			
			$this->fechamentoCompetenciaDAO = new FechamentoCompetenciaDAO($em);			
		}

		public function conciliarValores($data){
		
			$dadosCapturadosSaldoMensal = $this->capturaDemonstrativoDAO->listSaldosByDataCaptura($data);	

			$this->verificarCompetenciaFechada($dadosCapturadosSaldoMensal['1']["Data"]);
			$this->verificarSeCapturaDeSaldoFoiConciliado($dadosCapturadosSaldoMensal['1']['DataConciliacao']);

			foreach ($dadosCapturadosSaldoMensal as $capturaDados) {
				
				$ativoID = $this->ativosDAO->procurarPorCodigoCetip($capturaDados['TitulosPrivados']);				
				$voDemonstrativo = $this->criarVoSaldoDevedor($capturaDados);
				$this->gravarAtivoSaldo($voDemonstrativo, $ativoID);				
				$this->gravarPlanilhaDemonstravivo($voDemonstrativo);
								
			}//endforeach da lista planilha ativo		

		}	

		private function gravarAtivoSaldo($voDemonstrativo, $ativoID){

			$voAtivosSaldos = New AtivosSaldos();

			$voAtivosSaldos->setAtivoID($ativoID);
			$voAtivosSaldos->setSaldoData($voDemonstrativo->getData());
			$voAtivosSaldos->setSaldoValor(0.00);//pegar da tabela de demonstrativo, pesquisar pela data do evento.			
			$voAtivosSaldos->setSaldoValor($voDemonstrativo->getValorContabil());//pegar da tabela de demonstrativo, pesquisar pela data do evento.			
			$voAtivosSaldos->setProvisaoTaxaRisco(0.00);//pegar da tabela de demonstrativo, pesquisar pela data do evento.
			$voAtivosSaldos->setProvisaoTaxaRisco($voDemonstrativo->getTaxaRiscoProvisionada());//pegar da tabela de demonstrativo, pesquisar pela data do evento.
			$this->ativosSaldosDAO->insert($voAtivosSaldos);
			// $logger->prepararLog($voTransacao);			
			// $logger->logar($voTransacao);
		}

		private function gravarPlanilhaDemonstravivo($voDemonstrativo) {

			$voDemonstrativo->setDataConciliacao(date("Y-m-d", time()));
			$this->capturaDemonstrativoDAO->update($voDemonstrativo);

		}

		private function verificarSeCapturaDeSaldoFoiConciliado($data)	{
			
			if (!empty($data)){
				$result = json_encode(array("resultado" => false, "mensagem" =>"Captura já conciliado!"));
				$this->em->rollback();
				die($result);
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

		private function verificarSeExisteLancamentoSaldoCompetencia($data)	{			

			$mes = PPOEntity::toDateBr($data, "m");
			$ano = PPOEntity::toDateBr($data, "Y");			
			$competenciaPossuiLancamento = $this->fechamentoCompetenciaDAO->verificarSeCompetenciaFechada($competencia);			
			$total = count($competenciaPossuiLancamento); 	
			
			if ($total > 0){

				$result = json_encode(array("resultado" => false, "mensagem" => $mes."/".$ano ." - Competência possuí saldo devedor lançado!"));
				$this->em->rollback();
				die($result);
			}	

		}

		private function criarVoSaldoDevedor($capturaDados)	{

			$voDemonstrativo = $this->capturaDemonstrativoDAO->findByCodigoAtivoAndData($capturaDados["TitulosPrivados"],$capturaDados["Data"]);

			if (count($voDemonstrativo->getID()) === 0){
				$result = json_encode(array("resultado" => false, "mensagem" =>"Não foi realizado captura do saldo para data informada!" . $capturaDados["TitulosPrivados"] . "-" . $capturaDados["Data"]));
				$this->em->rollback();
				die($result);
			}else{

				return $voDemonstrativo;
			}	

		}

	}
	
?>