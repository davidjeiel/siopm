<?php

	class CapturaPlanilha{

		private $user;
		private $arquivosDAO;
		private $controleDAO;
		private $ativosDAO;
		private $planilhaAtivosDAO;
		private $planilhaEventosDAO;
		private $eventosTiposDAO;
		private $em;

		public function __construct($em, $user){
			$this->em = $em;
			$this->user = $user;
			$this->arquivosDAO  = new ArquivosDAO($em);
			$this->controleDAO = new CapturaControleDAO($em);
			$this->ativosDAO = new ativosDAO ($em);
			$this->planilhaAtivosDAO 	= new CapturaPlanilhaAtivosDAO($em);
			$this->planilhaEventosDAO 	= new CapturaPlanilhaEventosDAO($em);
			$this->eventosTiposDAO = new EventosTiposDAO($em);
		}


		public function importarPlanilha($arquivo){

			$controleID = $this->gravarControle($arquivo->getArquivoID());
			$planilha = new Spreadsheet_Excel_Reader($arquivo->getArquivo());

			for( $i=1; $i <= $planilha->rowcount($sheet_index=0); $i++ ){					
				
				if ($i == 1) {

					$cabecalho = array("DataEvento" => $this->removeAcentos($planilha->val(1, 1)),
										"Ativo" => $this->removeAcentos($planilha->val(1, 2)),
										"Evento" => $this->removeAcentos($planilha->val(1, 3)),
										"Valor" => $this->removeAcentos($planilha->val(1, 4))
										);					
					
					$validado = $this->validarCabecalhoPlanilha($cabecalho);
					if (!$validado) { die('{"result" : "false", "mensagem": "Cabeçalho não validado"}');	} 

				}else{

					if(strlen($planilha->val($i, 2)) > 0){
						$ativo = $planilha->val($i, 2);
						$data = (strlen($planilha->val($i, 1)) > 0)? $planilha->val($i, 1): $data;
						//começa a set os dados da tblplanilhaativos

						// testar para verificar se existe uma transacao para essa data e evento.

						$possuiEventoData = $this->controleDAO->verificarEventoData(
																					$this->tratarData($data),
																					$this->ativosDAO->procurarPorCodigoCetip($ativo)																				
																					);						
						$possuiEventoCapturadoParaMesmaData = $this->controleDAO->verificarSePossuiEventoCapturadoParaMesmaData(
																					$this->tratarData($data),
																					$this->ativosDAO->procurarPorCodigoCetip($ativo)																				
																					);						

						if ($possuiEventoCapturadoParaMesmaData) { die('{"result" : "false", "mensagem": "Possui planilha importadas para mesma data, verifique!"}');	} 

						if ($possuiEventoData) {

							die('{"result" : "false", "mensagem": "Eventos já foram lançados"}');					
							
						}else{
									//$this->em->pr($possuiEventoData);
							$planilhaAtivosID = $this->gravarPlanilhaAtivo($controleID, $ativo, $data);
		
						}


						// $this->em->pr(
						// 			$this->tratarData($data).'-'.
						// 			$this->ativosDAO->procurarPorCodigoCetip($ativo).'-'.
						// 			$this->eventosTiposDAO->procurarEventoTipo($this->tratarEvento($planilha->val($i, 3))).'-'.
						// 			$this->tratarValor($planilha->val($i, 4))
						// 			);
						
									
					}
					//criar ROLLBACK		
					$vo = New CapturaPlanilhaEventos();
					$vo->setCapturaPlanilhaAtivosID($planilhaAtivosID);				
					$vo->setEvento($this->tratarEvento($planilha->val($i, 3)));
					$vo->setValor($this->tratarValor($planilha->val($i, 4)));
					//criar ROLLBACK	
					$vo->setTipoEventoId($this->eventosTiposDAO->procurarEventoTipo($this->tratarEvento($planilha->val($i, 3))));
					$this->gravarPlanilhaEvento($vo);//, null, false, true);
				}

			}


		}

		private function tratarEvento($evento){
			try {

				$evento = $this->removeAcentos($evento);

				if($evento == "amortizacao") $evento = "Amortização";
				elseif($evento =="amortizacao extraordinaria")  $evento = "Amortização Extraordinária";
				elseif ($evento =="juros") $evento = "Juros";
				elseif (
						$evento =="taxa de risco" || 
						$evento == "taxa de resgate" || 
						$evento  == "taxa de custodia"
				) 
					$evento = "Taxa de Risco";
				elseif ($evento =="remuneracao selic") $evento = "Remuneração SELIC";
				else $evento = $evento;
				
				return $evento;
			} catch (Exception $e) {
				throw new Exception("Error Processing Request", 1);
			}
		}

		private function tratarValor($valor){
			try {				
				$valor = str_replace(",","", $valor);
				return (float)$valor;				
			} catch (Exception $e) {
				throw new Exception("Error Processing Request", 1);
			}
		}

		private function tratarData($data){
			try {

				$time = strtotime(trim($data));
				$data = date('Y-m-d',$time);
				return $data;
			} catch (Exception $e) {
				throw new Exception("Error Processing Request", 1);
			}
		}

		private function gravarControle($arquivoID){
			$vo = New CapturaControle();
			$vo->setData(date("Y-m-d H:i:s", time()));
			$vo->setArquivoID($arquivoID);
			$vo->setImportador($this->user->getUsuarioMatricula());
			try {	
				//$erro = 10/0; 
				return (int) $this->controleDAO->persist($vo);
			} catch (Exception $e) {
				throw new Exception("Erro ao gravar a captura de arquivo", 1);
			}
		}

		private function gravarPlanilhaAtivo($controleID, $ativo, $data){			
			
			$ativoID = $this->ativosDAO->procurarPorCodigoCetip($ativo);

			if (is_null($ativoID)) {die('{"result" : "false", "mensagem": "Arquivo possui ativo, ' . $ativo .  ', lançado na planilha que não está cadastrado no SIOPM"}');	} 
			
			$vo = New CapturaPlanilhaAtivos();
			$vo->setCapturaControleID($controleID);
			$vo->setCodigoAtivo($ativo);
			$vo->setDataEvento($this->tratarData($data));			
			$vo->setAtivoID($ativoID);
			try {
				return (int) $this->planilhaAtivosDAO->persist($vo);
			} catch (Exception $e) {
				throw new Exception("Erro ao gravar ativos capturados.", 1);
			}
		}

		private function gravarPlanilhaEvento($vo){			

			try {
				$this->planilhaEventosDAO->persist($vo);//, null, false, true);
			} catch (Exception $e) {
				throw new Exception("Não foi pssível gravar o evento.", 1);
			}

		}

		private function validarCabecalhoPlanilha($cabecalho){			
		
			if($cabecalho["DataEvento"] == "data do evento" && 
				$cabecalho["Ativo"] == "ativo" && 
				$cabecalho["Evento"] == "evento" && 
				$cabecalho["Valor"] == "valor (r$)"){
				return true;
			}else{
				return false;
			}	

		}

		private function removeAcentos($string, $slug = false) {
			  $string = strtolower($string);

			  // Código ASCII das vogais
			  $ascii['a'] = range(224, 230);
			  $ascii['e'] = range(232, 235);
			  $ascii['i'] = range(236, 239);
			  $ascii['o'] = array_merge(range(242, 246), array(240, 248));
			  $ascii['u'] = range(249, 252);

			  // Código ASCII dos outros caracteres
			  $ascii['b'] = array(223);
			  $ascii['c'] = array(231);
			  $ascii['d'] = array(208);
			  $ascii['n'] = array(241);
			  $ascii['y'] = array(253, 255);

			  foreach ($ascii as $key=>$item) {
			    $acentos = '';
			    foreach ($item AS $codigo) $acentos .= chr($codigo);
			    $troca[$key] = '/['.$acentos.']/i';
			  }

			  $string = preg_replace(array_values($troca), array_keys($troca), $string);

			  // Slug?
			  if ($slug) {
			    // Troca tudo que não for letra ou número por um caractere ($slug)
			    $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
			    // Tira os caracteres ($slug) repetidos
			    $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
			    $string = trim($string, $slug);
			  }

			  return $string;
			}

	}
	
?>