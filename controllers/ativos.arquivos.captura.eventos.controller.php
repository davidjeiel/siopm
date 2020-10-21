<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$controllerFile = "/controllers/ativos.arquivos.captura.eventos.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";	
	include_once $siopm->getRootPath() . "/controllers/CapturaPlanilha.Class.php";

	session_start();

	@set_time_limit(5 * 60);

	$result = array();

	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac']; 

	//$ativosDAO					= new AtivosDAO($em);
	$arquivosDAO 				= new ArquivosDAO($em);
	// $ativosArquivosDAO 			= new AtivosArquivosDAO($em);
	// $ativosArquivosTiposDAO 	= new ativosArquivosTiposDAO($em);
	// $capturaControleDAO 		= new CapturaControleDAO($em);
	// $capturaPlanilhaEventosDAO 	= new CapturaPlanilhaEventosDAO($em);
	// $capturaPlanilhaAtivosDAO 	= new CapturaPlanilhaAtivosDAO($em);
	$eventosTiposDAO 			= new EventosTiposDAO($em);
	$capturaPlanilha = new CapturaPlanilha($em, $user);
	

	switch ($action) {

		case "upload" :

			try{

				$AtivoID = null;

				$fileToProcess = null;

				if (!isset($_SESSION['file_to_process'])){
					die('{"result" : "false", "mensagem": "Não foi definido um arquivo de upload. Selecione um arquivo e refaça o upload!"}');
				}
				
				if (!is_file($_SESSION['file_to_process'])) {
					$fileToProcess = $_SESSION['file_to_process'];
					die('{"result" : "false", "mensagem": "Erro de sessão, arquivo não encontrado: $fileToProcess"}');
				} 

				// if (!isset($_REQUEST["AtivoID"])) {
				// 	die('{"result" : "false", "mensagem": "Erro: Campo ID do ativo não foi enviado!"}');
				// }

				// $AtivoID = $_REQUEST["AtivoID"];
				// if (!preg_match('/^\d+$/', $AtivoID)) {
				// 	die('{"result" : "false", "mensagem": "Erro: Campo ID do ativo não é inválido!"}');
				// }

				if (!isset($_REQUEST["ArquivoDescricao"])) {
					die('{"result" : "false", "mensagem": "Erro: O Tipo de arquivo não foi enviado corretamente!"}');
				}

				// $AtivoArquivoTipoID = $_REQUEST["AtivoArquivoTipoID"];
				// if (!preg_match('/^\d+$/', $AtivoID)) {
				// 	die('{"result" : "false", "mensagem": "Erro: O Tipo de arquivo é inválido!"}');
				// }

		  		//$ativosArquivosTipos = new AtivosArquivosTipos();
				//$ativosArquivosTipos = $ativosArquivosTiposDAO->find($AtivoArquivoTipoID);
				
				$fileDesc 				= "";
				$newFileLocation		= "Reserva de ID do arquivo...";
				$file_name				= "Gerando nome do arquivo...";
				
				$file_type 			= $_SESSION['file_type'];
				$file_size 			= $_SESSION['file_size'];
		  		$file      			= $_SESSION['file_to_process'];

		  		$file_ext 	= explode('.',$file);
		  		$file_ext 	= end($file_ext);

		  		// aqui vai a descrição
				$fileDesc = $_REQUEST["ArquivoDescricao"];
					
				$em->beginTransaction();

				$arquivo = new Arquivos();
				$arquivo->setArquivoDataCadastro(date("Y-m-d H:i:s", time()));
				$arquivo->setArquivoMatricula($user->getUsuarioMatricula());
				$arquivo->setArquivoNome($file_name);
				$arquivo->setArquivoExtensao($file_ext);
				$arquivo->setarquivoMimeType($file_type);
				$arquivo->setArquivoDescricao($fileDesc);
				$arquivo->setArquivoTamanho($file_size);
				$arquivo->setArquivoDataAlteracao(date("Y-m-d H:i:s", time()));
				$arquivo->setArquivo($newFileLocation);

				$arquivo->setArquivoID((int)$arquivosDAO->persist($arquivo, null, true));

				//COLOCAR AQUI A INCLUSÃO NA TABELA [tblCapturaControle]
				// $ativoArquivo =  new AtivosArquivos();
				// $ativoArquivo->setArquivoID($arquivo->getArquivoID());
				// $ativoArquivo->setAtivoArquivoTipoID($ativosArquivosTipos->getAtivoArquivoTipoID());
				// $ativoArquivo->setAtivoID($AtivoID);
				// $ativoArquivo->setAtivoArquivoID($ativosArquivosDAO->persist($ativoArquivo));
				
				$file_name = ".". $user->getUsuarioMatricula() .	".D" .	date("Ymd", time()) . ".$file_ext";

				$file_name = "A" . str_pad($arquivo->getArquivoID(), 5, "0", STR_PAD_LEFT) . $file_name;
	 		
		 		$new_file = dirname($file) . DIRECTORY_SEPARATOR . $file_name;
		 		
		  		if (file_exists($new_file)) unlink($new_file);
		  		
		  		$success = rename($file, $new_file);
				
				if (!$success) {
					$em->rollBack();
					die('{"result" : "false", "mensagem": "Erro: Falha ao renomear arquivo!"}');
				}
				
				$newFileLocation = $_SERVER["DOCUMENT_ROOT"] . $app_path . "/files/ativos/capturaeventos" . DIRECTORY_SEPARATOR . $file_name;

				$success = copy($new_file, $newFileLocation);

				if (!$success) {
					$em->rollBack();
					if (file_exists($new_file)) unlink($new_file);
				    die('{"result" : "false", "mensagem": "Erro: Falha ao copiar arquivo para pasta de destino!"}');
				}

				if (file_exists($new_file)) unlink($new_file);

				$arquivo->setArquivo($newFileLocation);
				$arquivo->setArquivoNome($file_name);
				$arquivoID = $arquivo->getArquivoID();

				$arquivosDAO->update($arquivo, null, true);

				
				//------------------------------------------------------------

				//chamar a leitura do arquivo aqui. Vericar se o commint server nessa situacao

				//$result = incluirDadosPlanilha ($arquivoID, $newFileLocation);

				// if ($arquivoID == 0 ) {
				// die('{"result" : "false", "mensagem": "Erro: Campo ID do arquivo não foi enviado!"}');
				// }
				// if (!preg_match('/^\d+$/', $arquivoID)) {
				// 	die('{"result" : "false", "mensagem": "Erro: Campo ID do arquivo é inválido!"}');
				// }
				// $arquivo = $arquivosDAO->find($arquivoID);
				// if (empty($arquivo)) die('{"result" : "false", "mensagem": "Erro: ID do arquivo não localizado!"}');
				
				// //Criar nova linha na tabela tblCapturaControle
				// $voCapturaControle = New CapturaControle();
				// $voCapturaControle->setData(date("Y-m-d H:i:s", time()));
				// $voCapturaControle->setArquivoID($arquivoID);
				// $voCapturaControle->setImportador($user->getUsuarioMatricula());		
				// //$ativoID = $ativosDAO->persist($vo, null, true);
				// $controleID = $capturaControleDAO->persist($voCapturaControle);

				
				$capturaPlanilha->importarPlanilha($arquivo);

				//COMECA A LEITURA DA PLANILHA para incluir na tabela 
				
				//$data = new Spreadsheet_Excel_Reader($newFileLocation);			
				
				
				// //COMEÇA O FOR PARA INCLUSAO DO ARQUIVO NA TABELA.
				// $planilhaAtivosID = 0;

				// for( $i=2; $i <= $data->rowcount($sheet_index=0); $i++ ){ 
					
									
				// 	if(strlen($data->val($i, 2)) > 0){
				// 		$ativo = $data->val($i, 2);
				// 		$ativodados = array();
				// 		$ativodados = $ativosDAO->procurarPorCodigoCetip($ativo);

				// 		//começa a set os dados da tblplanilhaativos
				// 		$voCapturaPlanilhaAtivos = New CapturaPlanilhaAtivos();
				// 		$voCapturaPlanilhaAtivos->setCapturaControleID($controleID);
				// 		$voCapturaPlanilhaAtivos->setCodigoAtivo($ativo);
				// 		$voCapturaPlanilhaAtivos->setAtivoID($ativodados['AtivoID']);		
						
				// 		$planilhaAtivosID = $capturaPlanilhaAtivosDAO->persist($voCapturaPlanilhaAtivos);
				// 	}

				// // 	//$ativo = (strlen($data->val($i, 2)) > 0)? $data->val($i, 2): $ativo;

				// 	$dataEvento = (strlen($data->val($i, 1)) > 0)? $data->val($i, 1): $dataEvento;				
				// 	$evento = $data->val($i, 3);
				// 	$valor = $data->val($i, 4);

				// 	//$tblEventosTipos = $eventosTiposDAO->procurarEventoTipo($evento);
					
				// 	$voPlanilhaEventos = New CapturaPlanilhaEventos();
				// 	$voPlanilhaEventos->setCapturaPlanilhaAtivosID($planilhaAtivosID);
				// 	$voPlanilhaEventos->setDataEvento($dataEvento);
				// 	$voPlanilhaEventos->setEvento("Evento teste");
				// 	$voPlanilhaEventos->setValor(10.5);
				// 	// //$voPlanilhaEventos->setTipoEventoID($tblEventosTipos['EventoTipoID']);
				// 	//$em->pr($voPlanilhaEventos);
					


				// 	$planilhaEventosID = $capturaPlanilhaEventosDAO->insert($voPlanilhaEventos);//, null, false, true);

				// }



				//--------------------------------------------------------------------------------

				cleanup();

				$em->commit();
				
				$result = 
					json_encode(
						array(
							"result"=> true,
							"ativoid" => $AtivoID,
							"mensagem"=>"Arquivo salvo com sucesso!", 
							"arquivoid" => $arquivo->getArquivoID(), 
							"filename" => $file_name)
					);

			}catch (Exception $e){

				//throw new Exception("Error Processing Request", 1);
				
				if (file_exists($new_file)) unlink($new_file);

				cleanup();
		
				$em->rollBack();
				
				$result = 
					json_decode(
						array("result"=> false, "mensagem"=>"Erro: Erro ao gravar arquivo!", 
							"exception" => $e->getTraceAsString())
					);

			}

			die($result);

			break;

		case "delete" :

			$ArquivoID = 0;
			$AtivoArquivoID = 0;
		
			if ( isset($_REQUEST["AtivoArquivoID"]) and $_REQUEST["AtivoArquivoID"] > 0 &&
				 isset($_REQUEST["ArquivoID"]) and $_REQUEST["ArquivoID"] > 0) {
				$ArquivoID = $_REQUEST["ArquivoID"];
				$AtivoArquivoID = $_REQUEST["AtivoArquivoID"];
				try{
					$em->beginTransaction();
					$ativosArquivosDAO->deleteByID($AtivoArquivoID);
					$arquivo = $arquivosDAO->find($ArquivoID);
					if (isset($arquivo)){
						$file = $arquivo->getArquivo();	
						$arquivosDAO->delete($arquivo);
						if (file_exists($file)) {
							@unlink($file);
						}
					}
					$em->commit();
					$result = json_encode(array("result"=> true, "mensagem"=>"Arquivo excluído com sucesso!"));
				}catch (Exception $e){
					$em->rollBack();
					$result = json_encode(array("result"=> false, "mensagem"=>"Erro: Erro ao tentar exlcuir arquivo da análise de risco!", "exception" => $e->getTraceAsString()));
				}
			}else{
				$result = json_encode(array("result"=> false, "mensagem"=>"Os identificadoes de arquivo não foram passados corretamente!", "exception" => $e->getTraceAsString()));
			}
			die($result);
			break;

		case "download" :
			$ArquivoID = 0;
			if (isset($_REQUEST["ArquivoID"]) and $_REQUEST["ArquivoID"] > 0) {
				$ArquivoID = $_REQUEST["ArquivoID"];
			}
			if ($ArquivoID == 0 ) {
				die('{"result" : "false", "mensagem": "Erro: Campo ID do arquivo não foi enviado!"}');
			}
			if (!preg_match('/^\d+$/', $ArquivoID)) {
				die('{"result" : "false", "mensagem": "Erro: Campo ID do arquivo é inválido!"}');
			}
			$arquivo = $arquivosDAO->find($ArquivoID);
			if (empty($arquivo)) die('{"result" : "false", "mensagem": "Erro: ID do arquivo não localizado!"}');
			downloadFile($arquivo);
			break;
	default:
		if (isset($_REQUEST['ac'])){
			$post_acao = $_REQUEST['ac'];
			if (!in_array($post_acao, array('upload','download','delete'))) {
				echo json_encode(array("result" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O campo "ação" não foi indicado corretamente.'));
				exit;
			}
		} else echo json_encode(array("result" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': USUARIO POST AC NAO DEFINIDO.'));
		break;
	}


?>