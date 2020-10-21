<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$controllerFile = "/controllers/propostas.arquivos.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";

	session_start();

	@set_time_limit(5 * 60);

	$result = array();

	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac']; 

	$arquivosDAO = new ArquivosDAO($em);
	$propostasArquivosDAO = new PropostasArquivosDAO($em);
	$propostasArquivosTiposDAO = new PropostasArquivosTiposDAO($em);

	switch ($action) {

		case "upload":

			try{

				$propostaDetalheID = null;

				$tmp_file_to_process = null;

				if (!isset($_SESSION['file_to_process'])){
					die('{"result" : "false", "mensagem": "Não foi definido um arquivo de upload. Selecione um arquivo e refaça o upload!"}');
				}
				
				if (!is_file($_SESSION['file_to_process'])) {
					$tmp_file_to_process = $_SESSION['file_to_process'];
					die('{"result" : "false", "mensagem": "Erro de sessão, arquivo não encontrado: $tmp_file_to_process"}');
				} 

				if (!isset($_REQUEST["PropostaDetalheID"])) {
					die('{"result" : "false", "mensagem": "Erro: Campo ID do detalhe da proposta não foi enviado!"}');
				}

				$propostaDetalheID = $_REQUEST["PropostaDetalheID"];
				if (!preg_match('/^\d+$/', $propostaDetalheID)) {
					die('{"result" : "false", "mensagem": "Erro: Campo ID do detalhe da proposta é inválido!"}');
				}

				if (!isset($_REQUEST["PropostaArquivoTipoID"])) {
					die('{"result" : "false", "mensagem": "Erro: O Tipo de arquivo não foi enviado corretamente!"}');
				}

				$propostaArquivoTipoID = $_REQUEST["PropostaArquivoTipoID"];
				if (!preg_match('/^\d+$/', $propostaArquivoTipoID)) {
					die('{"result" : "false", "mensagem": "Erro: O Tipo de arquivo é inválido!"}');
				}

		  		$propostaFaseNome = $_REQUEST["PropostaFaseNome"];
		  		$propostasArquivosTipos = new PropostasArquivosTipos();
				$propostasArquivosTipos = $propostasArquivosTiposDAO->find($propostaArquivoTipoID);
				
				$fileDesc 				= "";
				$newFileLocation		= "Reserva de ID do arquivo...";
				$file_name				= "Gerando nome do arquivo...";
				
				$file_type 			= $_SESSION['file_type'];
				$file_size 			= $_SESSION['file_size'];
		  		$file      			= $_SESSION['file_to_process'];

		  		$file_ext 	= explode('.',$file);
		  		$file_ext 	= end($file_ext);

				$fileDesc = "Proposta " . strtolower($propostaFaseNome) . " - " . $propostasArquivosTipos->getPropostaArquivoDescricao();
					
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
				
				$arquivo->setArquivoID((int)$arquivosDAO->insert($arquivo));		

				$propostaArquivo =  new PropostasArquivos();
				$propostaArquivo->setArquivoID($arquivo->getArquivoID());
				$propostaArquivo->setPropostaArquivoTipoID($propostasArquivosTipos->getPropostaArquivoTipoID());
				$propostaArquivo->setPropostaDetalheID($propostaDetalheID);
				$propostaArquivo->setPropostaArquivoID($propostasArquivosDAO->persist($propostaArquivo));
				$file_name = ".P" .	strtoupper(substr($propostaFaseNome, 0, 1)) . str_pad($propostaDetalheID, 4, "0", STR_PAD_LEFT) .
				".TP". str_pad($propostaArquivoTipoID, 2, "0", STR_PAD_LEFT) . 
				".PA". str_pad($propostaArquivo->getPropostaArquivoID(), 3, "0", STR_PAD_LEFT) .
				".D" .	date("Ymd", time()) . ".$file_ext";

				$file_name = "A" . str_pad($arquivo->getArquivoID(), 5, "0", STR_PAD_LEFT) . $file_name;
	 		
		 		$new_file = dirname($file) . DIRECTORY_SEPARATOR . $file_name;
		 		
		  		if (file_exists($new_file)) unlink($new_file);
		  		
		  		$success = rename($file, $new_file);
				
				if (!$success) {
					die('{"result" : "false", "mensagem": "Erro: Falha ao renomear arquivo!"}');
				}
				
				$newFileLocation = $_SERVER["DOCUMENT_ROOT"] . $app_path . "/files/propostas" . DIRECTORY_SEPARATOR . $file_name;

				$success = copy($new_file, $newFileLocation);

				if (!$success) {
					$em->rollBack();
					if (file_exists($new_file)) unlink($new_file);
				    die('{"result" : "false", "mensagem": "Erro: Falha ao copiar arquivo para pasta de destino!"}');
				}

				if (file_exists($new_file)) unlink($new_file);

				$arquivo->setArquivo($newFileLocation);
				$arquivo->setArquivoNome($file_name);			
				$arquivosDAO->update($arquivo);//, null, true);

				cleanup();

				$em->commit();
				
				$result = 
					json_encode(
						array(
							"result"=> true, 
							"mensagem"=>"Arquivo salvo com sucesso!", 
							"arquivoid" => $arquivo->getArquivoID(), 
							"propostaarquivoid" => $propostaArquivo->getPropostaArquivoID(),
							"propostaarquivodescricao" => $propostasArquivosTipos->getPropostaArquivoDescricao(),
							"filename" => $file_name)
					);

			}catch (Exception $e){

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
			$PropostaArquivoID = 0;
		
			if ( isset($_REQUEST["PropostaArquivoID"]) and $_REQUEST["PropostaArquivoID"] > 0 &&
				 isset($_REQUEST["ArquivoID"]) and $_REQUEST["ArquivoID"] > 0) {
				$ArquivoID = $_REQUEST["ArquivoID"];
				$PropostaArquivoID = $_REQUEST["PropostaArquivoID"];
				try{
					$em->beginTransaction();
					$propostasArquivosDAO->deleteByID($PropostaArquivoID);
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