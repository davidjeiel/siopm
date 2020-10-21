<?php
//Configuração
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$title = $siopm->getTitle();

	$widgets = array();
	$controllerFile = "/controllers/dashboard.controller.php";
	$app_path = str_replace("/index.php", "", str_replace($controllerFile, "", $_SERVER["PHP_SELF"]));
	include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/recursos.php";
	
	$habilitacaoDAO 	= new HabilitacoesDAO($em);
	$habilitacoes = $habilitacaoDAO->listAllLastHabilitacoes();
	$widgets[] = 'habilitacao';

	$propostasDAO = new PropostasDAO($em);
	$propostas = $propostasDAO->listAllPorAnoOrcamentario(date("Y"));
	$widgets[] = 'proposta';

	$ativosSaldosDAO			= new AtivosSaldosDAO($em);
	$saldos = $ativosSaldosDAO->getSaldosPorSecuritizadora();
	$widgets[] = 'saldo';

	$transacaoDAO = new TransacoesDAO($em);
	$transacoes = $transacaoDAO->listarUltimasTransacoes();
	$widgets[] = 'transacao';
	
	require $siopm->getTemplate('dashboard');

?>
