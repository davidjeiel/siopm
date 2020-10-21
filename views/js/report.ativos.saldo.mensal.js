
$(document).off("click", '.cabecalho-report .gerar-relatorio');
$(document).on("click", '.cabecalho-report .gerar-relatorio', function() {
	gerarRelatorio();
});

$(document).off("click", '.cabecalho-report .gerar-excel');
$(document).on("click", '.cabecalho-report .gerar-excel', function() {
	gerarExcel();
});

function gerarRelatorio(){

	var form =$(".cabecalho-report form");

	if($(form).valid())	$.ajax({
		url: app_path + "/controllers/relatorio.ativos.saldo.mensal.controller.php",
		data : "ac=RELATORIO_SALDOS&" + form.serialize(),
		dataType : "html",
		success : function(reportBody) {
			$('#spanBody').html(reportBody);
			$(".corpo-report").show();
			//$(".cabecalho-report").hide();
		},
		error: function(xhr, ajaxOptions, thrownError) {
			bootbox.alert("ERRO report.ativos.saldos.mensais.js gerarRelatorio:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});

}

function gerarExcel(){
	var form =$(".cabecalho-report form");

	if($(form).valid()){
	window.open( app_path + "/controllers/relatorio.ativos.saldo.mensal.controller.php" 	+ "?ac=RELATORIO_SALDOS_EXCEL&" + form.serialize());
	}
}
