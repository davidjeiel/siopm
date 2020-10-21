<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$controllerFile = "/controllers/ativos.dados.basicos.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";

	$result = array();	

	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac']; 
	if (!user_has_access("CRI_ATIVOS")) $siopm->getHtmlError("Você não possui acesso a este módulo");
	
	$ativosDAO					= new AtivosDAO($em);
	$modalidadesDAO				= new ModalidadesDAO($em);
	$indexadoresDAO				= new IndexadoresDAO($em);
	$ativosSituacoesDAO			= new AtivosSituacoesDAO($em);
	$ativosSubtiposDAO			= new AtivosSubtiposDAO($em);
	$ativosLiquidacoesTiposDAO 	= new AtivosLiquidacoesTiposDAO($em);
	$ativosRegistrosDAO 		= new AtivosRegistrosDAO($em);
	$diasAnosDAO				= new DiasAnosDAO($em);
	$diasBasesDAO				= new DiasBasesDAO($em);
	$intervalosDAO				= new IntervalosDAO($em);
	$ativosJurosTiposDAO		= new AtivosJurosTiposDAO($em);
	$ativosAmortizacoesTiposDAO	= new AtivosAmortizacoesTiposDAO($em);	
	$ativosGarantiasDAO			= new AtivosGarantiasDAO($em);
	$garantiasDAO 				= new GarantiasDAO($em);

	switch ($action) {

		case 'PROCURAR_ATIVO':

			$result = json_encode(array("resultado"=> false));

			if (isset($_REQUEST['tipo'])) $tipo = $_REQUEST['tipo'];

			if ($tipo == 'Cetip' && isset($_REQUEST["codigo"]) && count($_REQUEST["codigo"]) > 0) {	
				$dadosAtivo = $ativosDAO->findByCodigoCetip($_REQUEST["codigo"], $_REQUEST["ativoid"]);	
			}

			if ($tipo == 'BmfBovespa' && isset($_REQUEST["codigo"]) && count($_REQUEST["codigo"]) > 0) {
				$dadosAtivo = $ativosDAO->findByCodigoBmfBovespa($_REQUEST["codigo"], $_REQUEST["ativoid"]);
			}

			if ($tipo == 'Isin' && isset($_REQUEST["codigo"]) && count($_REQUEST["codigo"]) > 0) {		
				$dadosAtivo = $ativosDAO->findByCodigoIsin($_REQUEST["codigo"], $_REQUEST["ativoid"]);
			}

			if(isset($dadosAtivo["AtivoID"]) && count($dadosAtivo["AtivoID"])>0){
				$result = json_encode(array(
					"resultado"=> true, 
					"tipo"=> $tipo,
					"AtivoID"=> $dadosAtivo['AtivoID'], 
					"AtivoCodigoCetip" => $dadosAtivo['AtivoCodigoCetip'],
					"AtivoCodigoBmfBovespa" => $dadosAtivo['AtivoCodigoBmfBovespa'],
					"AtivoCodigoIsin" => $dadosAtivo['AtivoCodigoIsin'],
					"AtivoCodigoSIOPM" => $dadosAtivo['AtivoCodigoSIOPM'])
			);
			
			}else{
				$result = json_encode(array("resultado"=> false,"tipo"=> $tipo));
			}

			echo $result;

			break;

		case 'EDITAR_ATIVO_DADOS_GERAIS':

			if (!user_has_access("CRI_ATIVOS_DADOS_GERAIS")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-ativo-dados-basicos" );
				die();
			}			
			$tituloForm = "Ativo Financeiro - Cadastrar Dados Gerais";

			$ativoDadoBasico 			= array();
			$ativosGarantiasExistentes 	= array();
			$ativosGarantias 			= array();
			$modalidades 				= $modalidadesDAO->listAll();
			$liquidacoes 				= $ativosLiquidacoesTiposDAO->listAll();
			$ativosSituacoes 			= $ativosSituacoesDAO->listAll();
			$ativosSubtipos 			= $ativosSubtiposDAO->listSubtiposCRI();
			$indexadores 				= $indexadoresDAO->listAll();
			$diasano 					= $diasAnosDAO->listAll();
			$diasbase 					= $diasBasesDAO->listAll();
			$intervalos 				= $intervalosDAO->listAll();
			$jurostipos 				= $ativosJurosTiposDAO->listAll();
			$amortizacaostipos 			= $ativosAmortizacoesTiposDAO->listAll();
			$garantias 					= $garantiasDAO->listAll();

			 if (isset($_REQUEST["AtivoID"]) && $_REQUEST["AtivoID"] > 0) {
			 	$AtivoDadoBasico = $ativosDAO->findByID($_REQUEST["AtivoID"]);
			 	$ativosGarantias 	= $ativosGarantiasDAO->listByAtivoID($_REQUEST["AtivoID"]);
			 } 

			if (isset($ativosGarantias)) foreach ($ativosGarantias as $key => $value) {
					if(isset($value["GarantiaID"])) $ativosGarantiasExistentes[] = $value["GarantiaID"];
			}

			//$em->pr($AtivoDadoBasico);

			require $siopm->getForm('ativos.dados.basicos');
			
			break;

		case 'SALVAR_DADOS_GERAIS':

			if (!user_has_access("CRI_ATIVOS_DADOS_GERAIS")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-ativo-dados-basicos" );
				die();
			}

			$result = "[]";
			$result = true;	
 
			$result = validaDados($_REQUEST);
			
			if ($result === true) try{

				$em->beginTransaction();
				
				$vo =  new Ativos();
				$voReg = new AtivosRegistros();

				$vo = $ativosDAO->fillEntitybyRequest($_REQUEST);

				if (!(int) $vo->getAtivoID() > 0) {
					$vo->setAtivoDataCadastro(
						PPOEntity::toDateBr(date("Y-m-d H:i:s", time()))
					);
				}

				$voReg = $ativosRegistrosDAO->fillEntitybyRequest($_REQUEST);
				$logger->prepararLog($vo);
				$ativoID = $ativosDAO->persist($vo, null, true);
				$logger->logar($vo);
				
				$voReg->setAtivoID($ativoID);

				$logger->prepararLog($voReg);
				$ativoRegistroID = $ativosRegistrosDAO->persist($voReg);
				$logger->logar($voReg);
				
				$garantias = $garantiasDAO->listAll();

				if ($ativoID > 0) $ativosGarantiasDAO->execute("DELETE FROM tblAtivosGarantias WHERE AtivoID = :ativoid", array(":ativoid" => $ativoID));

				foreach($garantias as $garantia) {
					if (isset($_REQUEST[$garantia["GarantiaID"]])){
						$voGarantias = New AtivosGarantias();
						$voGarantias->setAtivoID($ativoID);
						$voGarantias->setGarantiaID($garantia["GarantiaID"]);
						$logger->prepararLog($voGarantias);
						$ativosGarantiasDAO->persist($voGarantias);
						$logger->logar($voGarantias);
					}
				}

				$em->commit();
				
				$result = json_encode(array("resultado"=> true, "mensagem"=> "Dados Básicos do Ativo Financeiro salvos com Sucesso!" , "ativoid" => $ativoID));

			}catch (Exception $e){

				$em->rollBack();
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
							": Erro ao gravar Dados Básicos do Ativo Financeiro !", "exception" => $e->getTraceAsString()
						)
					);

			}

			echo $result;
			break;
		
		default:

			if (isset($_REQUEST['ac'])) {

				$post_acao = $_REQUEST['ac'];

				if (!in_array($post_acao, array('SALVAR_DADOS_GERAIS','EDITAR_ATIVO_DADOS_GERAIS','PROCURAR_ATIVO'))) {
					echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O campo "ação" não foi indicado corretamente.'));
					exit;
				}

			} else {
				echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': USUARIO POST AC NAO DEFINIDO.'));
			}

			break;

	}

	function validaDados($post){

		if (strtotime(PPOEntity::toDateBr($post['AtivoDataEmissao'], "Y-m-d")) > strtotime(PPOEntity::toDateBr($post['AtivoDataVencimento'], "Y-m-d"))) 
			return json_encode(array("resultado" => false, "mensagem"=>'A data da Emissão não deve ser maior que a data do Vencimento.'));
		
		if(!(empty($post['AtivoDataPrimeiraRemuneracao']))){

			if (strtotime(PPOEntity::toDateBr($post['AtivoDataEmissao'], "Y-m-d")) > strtotime(PPOEntity::toDateBr($post['AtivoDataPrimeiraRemuneracao'],"Y-m-d"))) 
				return json_encode(array("resultado" => false, "mensagem"=>'A data da Primeira Remuneração não deve ser menor que a data da Emissão.'));

			if (strtotime(PPOEntity::toDateBr($post['AtivoDataPrimeiraRemuneracao'], "Y-m-d")) > strtotime(PPOEntity::toDateBr($post['AtivoDataVencimento'], "Y-m-d"))) 
				return json_encode(array("resultado" => false, "mensagem"=>'A data da Primeira Remuneração não deve ser maior que a data do Vencimento.'));
		}

		if(!(empty($post['AtivoDataPrimeiraAmortizacao']))){

			if (strtotime(PPOEntity::toDateBr($post['AtivoDataEmissao'], "Y-m-d")) > strtotime(PPOEntity::toDateBr($post['AtivoDataPrimeiraAmortizacao'], "Y-m-d"))) 
				return json_encode(array("resultado" => false, "mensagem"=>'A data da Primeira Amortização não deve ser menor que a data da Emissão.'));

			if (strtotime(PPOEntity::toDateBr($post['AtivoDataPrimeiraAmortizacao'], "Y-m-d")) > strtotime(PPOEntity::toDateBr($post['AtivoDataVencimento'], "Y-m-d"))) 
				return json_encode(array("resultado" => false, "mensagem"=>'A data da Primeira Amortização não deve ser maior que a data do Vencimento.'));	
		}
	
		return true;
	}
	
?>
