
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
		url: app_path + "/controllers/relatorio.orcamentos.controller.php",
		data : "ac=RELATORIO_ORCAMENTOS&" + form.serialize(),
		dataType : "html",
		success : function(reportBody) {
			$('#spanBody').html(reportBody);
			$(".corpo-report").show();
			//$(".cabecalho-report").hide();
		},
		error: function(xhr, ajaxOptions, thrownError) {
			bootbox.alert("ERRO report.orcamentos.js gerarRelatorio:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});

}

function gerarExcel(){
	var form =$(".cabecalho-report form");

	if($(form).valid()){
	window.open( app_path + "/controllers/relatorio.orcamentos.controller.php" 	+ "?ac=RELATORIO_ORCAMENTOS_EXCEL&" + form.serialize());
	}
}