<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$controllerFile = "/controllers/habilitacao.files.controller.php";
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

				$tmp_file_to_process = null;

				if (!isset($_SESSION['file_to_process'])){
					die('{"resultado" : "false", "mensagem": "Não foi definido um arquivo de upload. Selecione um arquivo e refaça o upload!"}');
				}
				
				if (!is_file($_SESSION['file_to_process'])) {
					$tmp_file_to_process = $_SESSION['file_to_process'];
					die('{"resultado" : "false", "mensagem": "Erro de sessão, arquivo não encontrado: $tmp_file_to_process"}');
				} 

				if (!isset($_REQUEST["HabilitacaoID"])) {
					die('{"resultado" : "false", "mensagem": "Erro: Campo ID da habilitação não foi enviado!"}');
				}

				$hab_id = $_REQUEST["HabilitacaoID"];
				if (!preg_match('/^\d+$/', $hab_id)) {
					die('{"resultado" : "false", "mensagem": "Erro: Campo ID da habilitação é inválido!"}');
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

				if (isset($_REQUEST["HabRiscoID"])) {
					$id_tbl_acessoria 	= $_REQUEST["HabRiscoID"];
					$file_name_tipo 	= ".AR";
					$file_desc		 	= "Habilitação - Análise de Risco";
					$sql 				= "UPDATE tblHabilitacoesAnalisesRiscos SET HabRiscoArquivoID = :arquivoid WHERE HabRiscoID = ";
					if (isset($_POST["HabRiscoArquivoID"]) && $_POST["HabRiscoArquivoID"] > 0) $id_arquivo = $_POST["HabRiscoArquivoID"];
				}

				if (isset($_REQUEST["HabJuridicaID"])) {
					$id_tbl_acessoria 	= $_REQUEST["HabJuridicaID"];
					$file_name_tipo 	= ".AJ";
					$file_desc		 	= "Habilitação - Análise Jurídica";
					$sql 				= "UPDATE tblHabilitacoesAnalisesJuridicas SET HabJuridicaArquivoID = :arquivoid WHERE HabJuridicaID = ";
					if (isset($_POST["HabJuridicaArquivoID"]) && $_POST["HabJuridicaArquivoID"] > 0) $id_arquivo = $_POST["HabJuridicaArquivoID"];
				}

				if (isset($_REQUEST["HabRiscoExtID"])) {
					$id_tbl_acessoria 	= $_REQUEST["HabRiscoExtID"];
					$file_name_tipo 	= ".AE";
					$file_desc		 	= "Habilitação - Análise Risco Externo";
					$sql 				= "UPDATE tblHabilitacoesAnalisesRiscosExternos SET HabRiscoExtArquivoID = :arquivoid WHERE HabRiscoExtID = ";
					if (isset($_POST["HabRiscoExtArquivoID"]) && $_POST["HabRiscoExtArquivoID"] > 0) $id_arquivo = $_POST["HabRiscoExtArquivoID"];
				}

				if (isset($_REQUEST["HabCertID"])) {
					$id_tbl_acessoria 	= $_REQUEST["HabCertID"];
					$file_name_tipo 	= ".CT";
					$file_desc		 	= "Habilitação - Certificação";
					$sql 				= "UPDATE tblHabilitacoesCertificacoes SET HabCertArquivoID = :arquivoid WHERE HabCertID = ";
					if (isset($_POST["HabCertArquivoID"]) && $_POST["HabCertArquivoID"] > 0) $id_arquivo = $_POST["HabCertArquivoID"];
				}

				if (!preg_match('/^\d+$/', $id_tbl_acessoria)) {
					die('{"resultado" : "false", "mensagem": "Erro: Campo ID da tabela acessória inválido!"}');
				}

				if ($id_tbl_acessoria == 0) die('{"resultado" : "false", "mensagem": "Erro: Campo ID da tabela acessória não foi enviado!"}');

		  		$file_name = ".H" . str_pad($hab_id, 4, "0", STR_PAD_LEFT) .  $file_name_tipo . str_pad($id_tbl_acessoria, 4, "0", STR_PAD_LEFT) . ".D" . date("Ymd", time()) . ".$file_ext";

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

				$id_arquivo = $arquivosDAO->persist($arquivo, null, true);

				$file_name = "A" . str_pad($id_arquivo, 5, "0", STR_PAD_LEFT) . $file_name;
	 		
		 		$new_file = dirname($file) . DIRECTORY_SEPARATOR . $file_name;
		 		
		  		if (file_exists($new_file)) unlink($new_file);
		  		
		  		$success = rename($file, $new_file);
				
				if (!$success) {
					die('{"resultado" : "false", "mensagem": "Erro: Falha ao renomear arquivo!"}');
				}
				
				$new_file_location = $_SERVER["DOCUMENT_ROOT"] . $app_path . "/files/habilitacoes" . DIRECTORY_SEPARATOR . $file_name;

				$success = copy($new_file, $new_file_location);

				if (!$success) {
					if (file_exists($new_file)) unlink($new_file);
				    die('{"resultado" : "false", "mensagem": "Erro: Falha ao copiar arquivo para pasta de destino!"}');
				}

				if (file_exists($new_file)) unlink($new_file);
				
				$arquivo->setArquivo($new_file_location);

				$arquivo->setArquivoNome($file_name);

				$id_arquivo = $arquivosDAO->persist($arquivo, null, true);

				$sql = $sql . $id_tbl_acessoria;

				$sql = str_replace(":arquivoid", $id_arquivo, $sql); 

				$em->getConnection()->execute($sql);

				cleanup();

				$em->commit();
				
				$result = 
					json_encode(
						array(
							"resultado"=> true, 
							"mensagem"=>"Arquivo salvo com sucesso!", 
							"arquivoid" => $id_arquivo, 
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
			
			if ( isset($_REQUEST["HabRiscoID"]) and $_REQUEST["HabRiscoID"] > 0) {
				$id_tbl_acessoria = $_REQUEST["HabRiscoID"];
				$sql = "UPDATE tblHabilitacoesAnalisesRiscos SET HabRiscoArquivoID = NULL WHERE HabRiscoID = $id_tbl_acessoria";
				if (isset($_POST["HabRiscoArquivoID"]) && $_POST["HabRiscoArquivoID"] > 0) $id_arquivo = $_POST["HabRiscoArquivoID"];
			}

			if ( isset($_REQUEST["HabJuridicaID"]) and $_REQUEST["HabJuridicaID"] > 0) {
				$id_tbl_acessoria = $_REQUEST["HabJuridicaID"];
				$sql = "UPDATE tblHabilitacoesAnalisesJuridicas SET HabJuridicaArquivoID = NULL WHERE HabJuridicaID = $id_tbl_acessoria";
				if (isset($_POST["HabJuridicaArquivoID"]) && $_POST["HabJuridicaArquivoID"] > 0) $id_arquivo = $_POST["HabJuridicaArquivoID"];
			}

			if ( isset($_REQUEST["HabRiscoExtID"]) and $_REQUEST["HabRiscoExtID"] > 0) {
				$id_tbl_acessoria = $_REQUEST["HabRiscoExtID"];
				$sql = "UPDATE tblHabilitacoesAnalisesRiscosExternos SET HabRiscoExtArquivoID = NULL WHERE HabRiscoExtID = $id_tbl_acessoria";
				if (isset($_POST["HabRiscoExtArquivoID"]) && $_POST["HabRiscoExtArquivoID"] > 0) $id_arquivo = $_POST["HabRiscoExtArquivoID"];
			}
			

			if ( isset($_REQUEST["HabCertID"]) and $_REQUEST["HabCertID"] > 0) {
				$id_tbl_acessoria = $_REQUEST["HabCertID"];
				$sql = "UPDATE tblHabilitacoesCertificacoes SET HabCertArquivoID = NULL WHERE HabCertID = $id_tbl_acessoria";
				if (isset($_POST["HabCertArquivoID"]) && $_POST["HabCertArquivoID"] > 0) $id_arquivo = $_POST["HabCertArquivoID"];
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
						
			if (isset($_REQUEST["HabRiscoArquivoID"]) and $_REQUEST["HabRiscoArquivoID"] > 0) {
				$id_arquivo = $_REQUEST["HabRiscoArquivoID"];
			}

			if (isset($_REQUEST["HabJuridicaArquivoID"]) and $_REQUEST["HabJuridicaArquivoID"] > 0) {
				$id_arquivo = $_REQUEST["HabJuridicaArquivoID"];
			}

			if (isset($_REQUEST["HabRiscoExtArquivoID"]) and $_REQUEST["HabRiscoExtArquivoID"] > 0) {
				$id_arquivo = $_REQUEST["HabRiscoExtArquivoID"];
			}

			if (isset($_REQUEST["HabCertArquivoID"]) and $_REQUEST["HabCertArquivoID"] > 0) {
				$id_arquivo = $_REQUEST["HabCertArquivoID"];
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