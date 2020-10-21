<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$controllerFile = "/controllers/ativos.juros.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";

	$result = array();	

	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac']; 
	if (!user_has_access("CRI_ATIVOS")) $siopm->getHtmlError("Você não possui acesso a este módulo");

	$ativosDAO					= new AtivosDAO($em);
	$jurosDAO					= new JurosDAO($em);
	$ativosJurosTiposDAO		= new AtivosJurosTiposDAO($em);

	switch ($action) {

		case 'LISTAR_ATIVO_JUROS':		
			
			$listajuros = $jurosDAO->listAllJurosByIDAtivo($_REQUEST["AtivoID"]);	
			
			require $siopm->getForm('ativos.juros.list');
			
			break;

		case 'EDITAR_ATIVO_JUROS':

			if (!user_has_access("CRI_ATIVOS_JUROS")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-ativo-juros" );
				die();
			}			 

			$ativoJuros 	= array();
			$listajuros 	= array();
			$tituloForm 	= "Ativo Financeiro - Cadastrar Juros";


			if (isset($_REQUEST["AtivoID"]) && $_REQUEST["AtivoID"] != ""){
					$listajuros = $jurosDAO->listAllJurosByIDAtivo($_REQUEST["AtivoID"]);
			}

			if (isset($_REQUEST["AtivoID"]) && $_REQUEST["AtivoID"] > 0) {
			 	$ativoDadoBasico = $ativosDAO->findByID($_REQUEST["AtivoID"]);			 	
			}
			
			if (isset($_REQUEST["JurosID"]) && $_REQUEST["JurosID"] > 0) {
			 	$ativoJuros = $jurosDAO->findByID($_REQUEST["JurosID"]);
			}
			
			require $siopm->getForm('ativos.juros');
			
			break;

		case 'SALVAR_ATIVO_JUROS':

			if (!user_has_access("CRI_ATIVOS_JUROS")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-ativo-juros" );
				die();
			}			

			$result = "[]";
			$result = true;	
 
			$result = validaDadosJuros($_REQUEST);
			
			if ($result === true) try{

				$em->beginTransaction();
				
				$vo =  new Juros();
				$vo = $jurosDAO->fillEntitybyRequest($_REQUEST);
				$logger->prepararLog($vo);			
				$jurosID = $jurosDAO->persist($vo);	
				$logger->logar($vo);		

				$em->commit();
				$result = json_encode(array("resultado"=> true, 
											"mensagem"=> "Taxa de juros salva com sucesso!", 
											"jurosid" => $jurosID));

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

		case 'EXCLUIR_ATIVO_JUROS':

			if (!user_has_access("CRI_ATIVOS_JUROS_EXCLUIR")) {
				echo $siopm->getErrorModal("Você não possui acesso a este módulo", "dialog-manut-ativo-juros" );
				die();
			}			

			$result = "[]";
			$result = true;

			if ($result === true) {

				$jurosid = $_REQUEST["JurosID"];

				try {

					$em->beginTransaction();

					$vojuros = $jurosDAO->find($jurosid);
					$logger->logarExclusao($vojuros);
					$jurosDAO->delete($vojuros);

					//$jurosDAO->execute("DELETE tblJuros where JurosID = ':jurosid'", array(":jurosid" => $jurosid));
					$em->commit();
					$result = json_encode(array("resultado" => true, "mensagem" => "Taxa de juros excluída com sucesso!"));

				} catch (Exception $e) {

					$em->rollBack();
					$result = 
						json_encode(
							array("resultado"=> false, "mensagem"=>"ERRO INTERNO " . basename(__FILE__) . 
								": Erro ao excluir Juros $jurosid!", "exception" => $e->getTraceAsString()
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
	function validaDadosJuros($post){

		if(!(is_null($post['AtivoDataEmissao']))){	

			if (strtotime(PPOEntity::toDateBr($post['AtivoDataEmissao'], "Y-m-d")) > strtotime(PPOEntity::toDateBr($post['JurosDataInicialVigencia'], "Y-m-d"))) 
				return json_encode(array("resultado" => false, "mensagem"=>'A data Inicial de Vigência do juro não deve ser maior que a data de Emissão.'));	
	
		}

		if(!(is_null($post['AtivoDataVencimento']))){	

			if (strtotime(PPOEntity::toDateBr($post['JurosDataFinalVigencia'], "Y-m-d")) > strtotime(PPOEntity::toDateBr($post['AtivoDataVencimento'], "Y-m-d"))) 
				return json_encode(array("resultado" => false, "mensagem"=>'A data Final de Vigência do juro não deve ser maior que a data de Vencimento do Ativo.'));	
	
		}

		if (strtotime(PPOEntity::toDateBr($post['JurosDataInicialVigencia'], "Y-m-d")) > strtotime(PPOEntity::toDateBr($post['JurosDataFinalVigencia'], "Y-m-d"))) 
			return json_encode(array("resultado" => false, "mensagem"=>'A data Inicial de Vigência do juro não deve ser maior que a data Final de Vigência.'));

		return true;
	}
	
?>
