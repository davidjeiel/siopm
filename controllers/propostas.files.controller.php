<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$controllerFile = "/controllers/propostas.files.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";

	session_start();

	@set_time_limit(5 * 60);

	$result = array();

	if (isset($_REQUEST['ac'])) $action = $_REQUEST['ac']; 

	$arquivosDAO = new ArquivosDAO($em);

	switch ($action) {

		case "upload" :

			try{

				$prop_det_id = null;

				$tmp_file_to_process = null;

				if (!isset($_SESSION['file_to_process'])){
					die('{"resultado" : "false", "mensagem": "Não foi definido um arquivo de upload. Selecione um arquivo e refaça o upload!"}');
				}
				
				if (!is_file($_SESSION['file_to_process'])) {
					$tmp_file_to_process = $_SESSION['file_to_process'];
					die('{"resultado" : "false", "mensagem": "Erro de sessão, arquivo não encontrado: $tmp_file_to_process"}');
				} 

				if (!isset($_REQUEST["PropostaDetalheID"])) {
					die('{"resultado" : "false", "mensagem": "Erro: Campo ID do detalhe da proposta não foi enviado!"}');
				}

				$prop_det_id = $_REQUEST["PropostaDetalheID"];
				if (!preg_match('/^\d+$/', $prop_det_id)) {
					die('{"resultado" : "false", "mensagem": "Erro: Campo ID do detalhe da proposta é inválido!"}');
				}

				$id_arquivo 			= 0;
				$id_tbl_acessoria 		= 0;
				$data_cadastro 			= null;
				$file_desc 				= "";
				$file_name_tipo			= "";
				$sql 					= "";
				$new_file_location		= "Reserva de ID do arquivo...";

				$file_type 			= $_SESSION['file_type'];
				$file_size 			= $_SESSION['file_size'];
		  		$file      			= $_SESSION['file_to_process'];

		  		$file_ext 	= explode('.',$file);
		  		$file_ext 	= end($file_ext);

		  		$proposta_fase = $_REQUEST["PropostaFaseNome"];

		  		if (isset($_REQUEST["PropJuridicaID"])) {
					$id_tbl_acessoria 	= $_REQUEST["PropJuridicaID"];
					$file_name_tipo 	= ".AJ";
					$file_desc		 	= "Proposta " . strtolower($proposta_fase) . " - Análise Jurídica";
					$sql 				= "UPDATE tblPropostasAnalisesJuridicas SET PropJuridicaArquivoID = :arquivoid WHERE PropJuridicaID = ";
					if (isset($_POST["PropJuridicaArquivoID"]) && $_POST["PropJuridicaArquivoID"] > 0) $id_arquivo = $_POST["PropJuridicaArquivoID"];
				}

				if (isset($_REQUEST["PropRiscoID"])) {
					$id_tbl_acessoria 	= $_REQUEST["PropRiscoID"];
					$file_name_tipo 	= ".AR";
					$file_desc		 	= "Proposta " . strtolower($proposta_fase) . " - Análise de Risco";
					$sql 				= "UPDATE tblPropostasAnalisesRiscos SET PropRiscoArquivoID = :arquivoid WHERE PropRiscoID = ";
					if (isset($_POST["PropRiscoArquivoID"]) && $_POST["PropRiscoArquivoID"] > 0) $id_arquivo = $_POST["PropRiscoArquivoID"];
				}

				if (isset($_REQUEST["PropManifGifugID"])) {
					$id_tbl_acessoria 	= $_REQUEST["PropManifGifugID"];
					$file_name_tipo 	= ".MG";
					$file_desc		 	= "Proposta " . strtolower($proposta_fase) . " - Manifestação da Gifug";
					$sql 				= "UPDATE tblPropostasManifGifug SET GifugArquivoID = :arquivoid WHERE PropManifGifugID = ";
					if (isset($_POST["GifugArquivoID"]) && $_POST["GifugArquivoID"] > 0) $id_arquivo = $_POST["GifugArquivoID"];
				}

				if (isset($_REQUEST["PropManifGefomID"])) {
					$id_tbl_acessoria 	= $_REQUEST["PropManifGefomID"];
					$file_name_tipo 	= ".MF";
					$file_desc		 	= "Proposta " . strtolower($proposta_fase) . " - Manifestação da Gefom";
					$sql 				= "UPDATE tblPropostasManifGefom SET GefomArquivoID = :arquivoid WHERE PropManifGefomID = ";
					if (isset($_POST["GefomArquivoID"]) && $_POST["GefomArquivoID"] > 0) $id_arquivo = $_POST["GefomArquivoID"];
				}

				if (isset($_REQUEST["PropResolucaoConselhoID"])) {
					$id_tbl_acessoria 	= $_REQUEST["PropResolucaoConselhoID"];
					$file_name_tipo 	= ".RC";
					$file_desc		 	= "Proposta " . strtolower($proposta_fase) . " - Resolução do Conselho";
					$sql 				= "UPDATE tblPropostasResolucoes SET PropResolucaoArquivoID = :arquivoid WHERE PropResolucaoConselhoID = ";
					if (isset($_POST["PropResolucaoArquivoID"]) && $_POST["PropResolucaoArquivoID"] > 0) $id_arquivo = $_POST["PropResolucaoArquivoID"];
				}


				if (!preg_match('/^\d+$/', $id_tbl_acessoria)) {
					die('{"resultado" : "false", "mensagem": "Erro: Campo ID da tabela acessória inválido!"}');
				}

				if ($id_tbl_acessoria == 0) die('{"resultado" : "false", "mensagem": "Erro: Campo ID da tabela acessória não foi enviado!"}');

		  		$file_name = ".P". 
		  			strtoupper(substr($proposta_fase, 0, 1)) . 
		  			str_pad($prop_det_id, 4, "0", STR_PAD_LEFT) . 
		  			$file_name_tipo . 
		  			str_pad($id_tbl_acessoria, 4, "0", STR_PAD_LEFT) . ".D" . 
		  			date("Ymd", time()) . ".$file_ext";
		  			
				$arquivo = new Arquivos();

				if ($id_arquivo > 0 ) {
					$arquivo->setArquivoID($id_arquivo);
				}else{
					$arquivo->setArquivoDataCadastro(date("Y-m-d H:i:s", time()));
				}

				$arquivo->setArquivoMatricula($user->getUsuarioMatricula());
				$arquivo->setArquivoNome($file_name);
				$arquivo->setArquivoExtensao($file_ext);
				$arquivo->setarquivoMimeType($file_type);
				$arquivo->setArquivoDescricao($file_desc);
				$arquivo->setArquivoTamanho($file_size);
				$arquivo->setArquivoDataAlteracao(date("Y-m-d H:i:s", time()));
				$arquivo->setArquivo($new_file_location);

				$em->beginTransaction();

				$arquivo->setArquivoID( (int) $arquivosDAO->persist($arquivo, null, true));
		
				$file_name = "A" . str_pad($arquivo->getArquivoID(), 5, "0", STR_PAD_LEFT) . $file_name;
	 		
		 		$new_file = dirname($file) . DIRECTORY_SEPARATOR . $file_name;
		 		
		  		if (file_exists($new_file)) unlink($new_file);
		  		
		  		$success = rename($file, $new_file);
				
				if (!$success) {
					$em->rollBack();
					die('{"resultado" : "false", "mensagem": "Erro: Falha ao renomear arquivo!"}');
				}
				
				$new_file_location = $_SERVER["DOCUMENT_ROOT"] . $app_path . "/files/propostas" . DIRECTORY_SEPARATOR . $file_name;

				$success = copy($new_file, $new_file_location);

				if (!$success) {
					if (file_exists($new_file)) unlink($new_file);
					$em->rollBack();
				    die('{"resultado" : "false", "mensagem": "Erro: Falha ao copiar arquivo para pasta de destino!"}');
				}

				if (file_exists($new_file)) unlink($new_file);

				$arquivo->setArquivo($new_file_location);
				$arquivo->setArquivoNome($file_name);

				$arquivo->setArquivoID( (int) $arquivosDAO->persist($arquivo, null, true));

				$sql = $sql . $id_tbl_acessoria;

				$sql = str_replace(":arquivoid", $arquivo->getArquivoID(), $sql); 
			
				$em->getConnection()->execute($sql);

				cleanup();

				$em->commit();
				
				$result = 
					json_encode(
						array(
							"resultado"=> true, 
							"mensagem"=>"Arquivo salvo com sucesso!", 
							"arquivoid" => $arquivo->getArquivoID(), 
							"filename" => $file_name)
					);

			}catch (Exception $e){
				if (file_exists($new_file)) unlink($new_file);
				cleanup();
				$em->rollBack();
				$result = 
					json_encode(
						array("resultado"=> false, "mensagem"=>"Erro: Erro ao gravar arquivo!", 
							"exception" => $e->getTraceAsString())
					);
			}

			die($result);

			break;

		case "delete" :

			$id_arquivo 			= 0;
			$id_tbl_acessoria 		= 0;
			
			if ( isset($_REQUEST["PropJuridicaID"]) and $_REQUEST["PropJuridicaID"] > 0) {
				$id_tbl_acessoria = $_REQUEST["PropJuridicaID"];
				$sql = "UPDATE tblPropostasAnalisesJuridicas SET PropJuridicaArquivoID = NULL WHERE PropJuridicaID = $id_tbl_acessoria";
				if (isset($_POST["PropJuridicaArquivoID"]) && $_POST["PropJuridicaArquivoID"] > 0) $id_arquivo = $_POST["PropJuridicaArquivoID"];
			}

			if ( isset($_REQUEST["PropRiscoID"]) and $_REQUEST["PropRiscoID"] > 0) {
				$id_tbl_acessoria = $_REQUEST["PropRiscoID"];
				$sql = "UPDATE tblPropostasAnalisesRiscos SET PropRiscoArquivoID = NULL WHERE PropRiscoID = $id_tbl_acessoria";
				if (isset($_POST["PropRiscoArquivoID"]) && $_POST["PropRiscoArquivoID"] > 0) $id_arquivo = $_POST["PropRiscoArquivoID"];
			}

			if ( isset($_REQUEST["PropManifGifugID"]) and $_REQUEST["PropManifGifugID"] > 0) {
				$id_tbl_acessoria = $_REQUEST["PropManifGifugID"];
				$sql = "UPDATE tblPropostasManifGifug SET GifugArquivoID = NULL WHERE PropManifGifugID = $id_tbl_acessoria";
				if (isset($_POST["GifugArquivoID"]) && $_POST["GifugArquivoID"] > 0) $id_arquivo = $_POST["GifugArquivoID"];
			}

			if ( isset($_REQUEST["PropManifGefomID"]) and $_REQUEST["PropManifGefomID"] > 0) {
				$id_tbl_acessoria = $_REQUEST["PropManifGefomID"];
				$sql = "UPDATE tblPropostasManifGefom SET GefomArquivoID = NULL WHERE PropManifGefomID = $id_tbl_acessoria";
				if (isset($_POST["GefomArquivoID"]) && $_POST["GefomArquivoID"] > 0) $id_arquivo = $_POST["GefomArquivoID"];
			}

			if ( isset($_REQUEST["PropResolucaoConselhoID"]) and $_REQUEST["PropResolucaoConselhoID"] > 0) {
				$id_tbl_acessoria = $_REQUEST["PropResolucaoConselhoID"];
				$sql = "UPDATE tblPropostasResolucoes SET PropResolucaoArquivoID = NULL WHERE PropResolucaoConselhoID = $id_tbl_acessoria";
				if (isset($_POST["PropResolucaoArquivoID"]) && $_POST["PropResolucaoArquivoID"] > 0) $id_arquivo = $_POST["PropResolucaoArquivoID"];
			}

			if ($id_tbl_acessoria == 0) {
				die('{"resultado" : "false", "mensagem": "Erro: Campo ID da tabela acessória não foi enviado!"}');
			}

			if ($id_arquivo == 0 ) {
				die('{"resultado" : "false", "mensagem": "Erro: Campo ID do arquivo não foi enviado!"}');
			}

			if (!preg_match('/^\d+$/', $id_tbl_acessoria)) {
				die('{"resultado" : "false", "mensagem": "Erro: Campo ID da tabela acessória inválido!"}');
			}

			if (!preg_match('/^\d+$/', $id_arquivo)) {
				die('{"resultado" : "false", "mensagem": "Erro: Campo ID do arquivo é inválido!"}');
			}

			try{

				$em->beginTransaction();

				$em->getConnection()->execute($sql);

				$arquivo = $arquivosDAO->find($id_arquivo);

				$file_name = $arquivo->getArquivoNome();

				if (isset($arquivo)){
					
					$file = $arquivo->getArquivo();	//$file = $_SERVER["DOCUMENT_ROOT"] .  "/files/habilitacoes/" . $arquivo->getArquivoNome();

					$arquivosDAO->delete($arquivo);

					if (file_exists($file)) {

						@unlink($file);

					}

				}
		
				$em->commit();

				$result = json_encode(array("resultado"=> true, "mensagem"=>"Arquivo excluído com sucesso!"));

			}catch (Exception $e){

				$em->rollBack();
						
				$result = json_encode(array("resultado"=> false, "mensagem"=>"Erro: Erro ao tentar exlcuir arquivo da análise de risco!", "exception" => $e->getTraceAsString()));

			}

			die($result);

			break;

		case "download" :

			$id_arquivo = 0;

			if (isset($_REQUEST["ArquivoID"]) and $_REQUEST["ArquivoID"] > 0) {
				$id_arquivo = $_REQUEST["ArquivoID"];
			}

			if ($id_arquivo == 0 ) {
				die('{"resultado" : "false", "mensagem": "Erro: Campo ID do arquivo não foi enviado!"}');
			}

			if (!preg_match('/^\d+$/', $id_arquivo)) {
				die('{"resultado" : "false", "mensagem": "Erro: Campo ID do arquivo é inválido!"}');
			}

			$arquivo = $arquivosDAO->find($id_arquivo);

			if (empty($arquivo )) die('{"resultado" : "false", "mensagem": "Erro: ID do arquivo não localizado!"}');

			downloadFile($arquivo);

			break;

	default:

		if (isset($_REQUEST['ac'])){
			$post_acao = $_REQUEST['ac'];
			if (!in_array($post_acao, array('upload','download','delete'))) {
				echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': O campo "ação" não foi indicado corretamente.'));
				exit;
			}
		} else echo json_encode(array("resultado" => false,"mensagem"=>'ERRO INTERNO ' . basename(__FILE__) . ': USUARIO POST AC NAO DEFINIDO.'));
		
		break;
	}





?>