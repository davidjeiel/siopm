<?php

	class Contador{
		
		public function __construct( $em, $user, $controllerFile){
		
			$dao = new AcessosDAO( $em );
			
			try{
				
				$acao = (isset($_REQUEST['ac'])) ? $_REQUEST['ac'] : "Nenhuma ação foi definida!";

				$vo = new Acessos();
				$vo->setDataHora(date('Y-m-d H:i:s'));
				$vo->setMatricula($user->getUsuarioMatricula());
				$vo->setController(str_replace(".controller.php", "", str_replace("/controllers/", "", $controllerFile)));
				$vo->setEndereco($controllerFile);
				$vo->setUnidade($user->getUnidadeID());
				$vo->setAcao($acao);
				$dao->insert($vo);
			} catch (Exception $e) {
				echo json_decode(
					array("result"=> false, "mensagem"=>"Erro: Não foi possível gravar acesso de usuário!", 
						"exception" => $e->getTraceAsString())
				);
			}
			
		}
		
	}
	
?>