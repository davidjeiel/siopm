
$(document).off("click", '.cabecalho-report .gerar-relatorio');
$(document).on("click", '.cabecalho-report .gerar-relatorio', function() {
	gerarRelatorio();
});


function gerarRelatorio(){

	var form =$(".cabecalho-report form");

	if($(form).valid())	$.ajax({
		url: app_path + "/controllers/relatorio.acessos.controller.php",
		data : "ac=REPORT_BODY&" + form.serialize(),
		dataType : "html",
		success : function(reportBody) {
			$('#spanBody').html(reportBody);
			$(".corpo-report").show();
		},
		error: function(xhr, ajaxOptions, thrownError) {
			bootbox.alert("ERRO acesso.report.js gerarRelatorio:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});

}


