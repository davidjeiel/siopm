<?php
//1.0

error_reporting(E_ALL);
ini_set('display_errors', 1);

$controllerFile = "/index.php";
$app_path = str_replace($controllerFile, "", $_SERVER["PHP_SELF"]);

//echo "<h1>$app_path</h1>";exit;

if ($_SERVER['REQUEST_URI'] == $app_path . "/index.php?phpinfo"){
	echo phpinfo();
	die;
}

include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/config/siopm.class.php";
$siopm 	= new Siopm($app_path);

$uri = "";
$vet = array();

switch ($_SERVER['REQUEST_URI']) {

	case "":
	case "/":
	case $app_path . "/index.php":
	case $app_path . "/index.php?dashboard":
		require $siopm->getController("dashboard");
		break;
	case $app_path . "/index.php?log":
		if (!isset($_REQUEST['ac']) || $_REQUEST['ac'] == "") $_REQUEST['ac'] = 'REPORT_HEADER';
		require $siopm->getController("relatorio.log");
		break;
	case $app_path . "/index.php?acessos":
		if (!isset($_REQUEST['ac']) || $_REQUEST['ac'] == "") $_REQUEST['ac'] = 'REPORT_HEADER';
		require $siopm->getController("relatorio.acessos");
		break;
	case $app_path . "/index.php?usuarios":
		if (!isset($_REQUEST['ac']) || $_REQUEST['ac'] == "") $_REQUEST['ac'] = 'LISTAR_USUARIOS';
		require $siopm->getController("usuarios");
		break;
	case $app_path . "/index.php?entidades":
		if (!isset($_REQUEST['ac']) || $_REQUEST['ac'] == "") $_REQUEST['ac'] = 'LISTAR_ENTIDADES';
		require $siopm->getController("entidades");
		break;

	case $app_path . "/index.php?entidadestipos":
		if (!isset($_REQUEST['ac']) || $_REQUEST['ac'] == "") $_REQUEST['ac'] = 'list';
		require $siopm->getController("entidadestipos");
		break;

	case $app_path . "/index.php?perfis":
		if (!isset($_REQUEST['ac']) || $_REQUEST['ac'] == "") $_REQUEST['ac'] = 'LISTAR_PERFIS';
		require $siopm->getController("perfis");
		break;

	case $app_path . "/index.php?orcamentoscri":
		if (!isset($_REQUEST['ac']) || $_REQUEST['ac'] == "") $_REQUEST['ac'] = 'LISTAR_ORCAMENTOS';
		require $siopm->getController("orcamentos");
		break;

	case $app_path . "/index.php?habilitacao":
		if (!isset($_REQUEST['ac']) || $_REQUEST['ac'] == "") $_REQUEST['ac'] = 'LISTAR_HABILITACOES';
		require $siopm->getController("habilitacao");
		break;

	case $app_path . "/index.php?propostapreliminar":
		if (!isset($_REQUEST['ac']) || $_REQUEST['ac'] == "") $_REQUEST['ac'] = 'LISTAR_PROPOSTA_PRELIMINAR';
		require $siopm->getController("propostas.cri");
		break;

	case $app_path . "/index.php?propostadefinitiva":
		if (!isset($_REQUEST['ac']) || $_REQUEST['ac'] == "") $_REQUEST['ac'] = 'LISTAR_PROPOSTA_DEFINITIVA';
		require $siopm->getController("propostas.cri");
		break;

	case $app_path . "/index.php?ativoscri":
		if (!isset($_REQUEST['ac']) || $_REQUEST['ac'] == "") $_REQUEST['ac'] = 'LISTAR_ATIVOS';
		require $siopm->getController("ativos");
		break;

	case $app_path . "/index.php?eventoscri":
		if (!isset($_REQUEST['ac']) || $_REQUEST['ac'] == "") $_REQUEST['ac'] = 'LISTAR_EVENTOS_CRI';
		require $siopm->getController("ativos.eventos");
		break;

	case $app_path . "/index.php?capturaeventoscri":
		if (!isset($_REQUEST['ac']) || $_REQUEST['ac'] == "") $_REQUEST['ac'] = 'LISTAR_ARQUIVOS_CAPTURADOS';
		require $siopm->getController("ativos.captura.eventos");
		break;

	case $app_path . "/index.php?capturasaldomensal":
		if (!isset($_REQUEST['ac']) || $_REQUEST['ac'] == "") $_REQUEST['ac'] = 'LISTAR_ARQUIVOS_CAPTURADOS';
		require $siopm->getController("ativos.captura.saldo.mensal");
		break;

	case $app_path . "/index.php?fechamentocompetenciascri":
		if (!isset($_REQUEST['ac']) || $_REQUEST['ac'] == "") $_REQUEST['ac'] = 'LISTAR_COMPETENCIAS_FECHADAS';
		require $siopm->getController("ativos.fechamento.competencia");
		break;

	case $app_path . "/index.php?eventos-report":
		if (!isset($_REQUEST['ac']) || $_REQUEST['ac'] == "") $_REQUEST['ac'] = 'RELATORIO_EVENTOS_CABECALHO';
		require $siopm->getController("relatorios.eventos");
		break;
	
	case $app_path . "/index.php?ativo-saldo-mensal-report":
		if (!isset($_REQUEST['ac']) || $_REQUEST['ac'] == "") $_REQUEST['ac'] = 'RELATORIO_SALDOS_CABECALHO';
		require $siopm->getController("relatorio.ativos.saldo.mensal");
		break;

	case $app_path . "/index.php?orcamentos-report":
		if (!isset($_REQUEST['ac']) || $_REQUEST['ac'] == "") $_REQUEST['ac'] = 'RELATORIO_ORCAMENTOS_CABECALHO';
		require $siopm->getController("relatorio.orcamentos");
		break;

	case $app_path . "/index.php?phpinfo":
		echo phpinfo();
		exit;
	 default:
	 	header('Status: 404 Not Found');
    	$contents = '<html><body><h1>Página não Encontrada</h1></body></html>';

}

require $siopm->getTemplate("_layout");

//include_once $_SERVER["DOCUMENT_ROOT"] . $app_path . "/views/forms/proposta.preliminar.cri.form.php";

/*
if (strpos($_SERVER['REQUEST_URI'], "?") > 0) {
	$vet = explode("?", $_SERVER['REQUEST_URI']);
	$uri = $vet[1];
} else $uri = $_SERVER['REQUEST_URI'];

/*
$url = $_SERVER['QUERY_STRING'];
list($err,$url) = explode(";",$url);
if($err=='404' && !$url) $_GET['q']=$url;

$em->pr($uri);
$em->pr($url);
*/



?>
