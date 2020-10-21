/*
 * Escrito por Paulo Souto
 * c091636 Em 13/05/2015
 * versão 1.0
 */


$(document).ready(function() {
	aplicaDataTableListadeSaldosMensais();
});

$(document).off("click", "#lista_saldos td a.confirmar-captura");
$(document).on("click", "#lista_saldos td a.confirmar-captura", function() {
	var CapturaData  = $(this).closest("tr").data("capturadata"); 
	bootbox.confirm("Tem certeza que deseja confirmar as informações dos saldos capturados com o SIOPM?", function(confirmou) {
		    if (confirmou) {
		      conciliarSaldosCapturados(CapturaData);
		    }
	  });
    //alert(ArquivoCapturadoID);
    
});

$(document).off("click", "#lista_saldos td a.detalhes");
$(document).on("click", "#lista_saldos td a.detalhes", function() {	
     var CapturaData  = $(this).closest("tr").data("capturadata");     
     consultarSaldosMensaisCapturados(CapturaData);
});

$(document).off("click", "#lista_saldos td a.excluir");
$(document).on("click", "#lista_saldos td a.excluir", function() {	
    var ArquivoCapturadoID  = $(this).closest("tr").data("arquivocapturadoid");
	  bootbox.confirm("Tem certeza que deseja apagar o arquivo importado", function(confirmou) {
		    if (confirmou) {
		      excluirArquivo(ArquivoCapturadoID);
		    }
	  });
});

function conciliarSaldosCapturados(CapturaData) {
	
	$.ajax(
	 	
	 	{
	 		url: app_path + "/controllers/ativos.captura.saldo.mensal.controller.php",
	 		data: {
	 			"ac": "CONCILIAR_VALORES_SALDOS",
	 			"CapturaData": CapturaData
	 		},
	 		dataType: "json",
	 		success: function(json) {
				if (json.resultado == true) {
					atualizarListadeArquivos();
					success_message(json.mensagem);
				} else {
					error_message(json.mensagem);
					console.log(json.mensagem + "\r\n" + json.exception);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO ativos.js conciliarEventosCapturados:\r\nNão foi possível confirmar o arquivo.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);
	
}

function excluirArquivo(ArquivoCapturadoID) {
	
	$.ajax(
	 	
	 	{
	 		url: app_path + "/controllers/ativos.captura.eventos.controller.php",
	 		data: {
	 			"ac": "EXCLUIR_ARQUIVO",
	 			"ArquivoCapturadoID": ArquivoCapturadoID
	 		},
	 		dataType: "json",
	 		success: function(json) {
				if (json.resultado == true) {
					atualizarListadeArquivos();
					success_message(json.mensagem);
				} else {
					error_message(json.mensagem);
					console.log(json.mensagem + "\r\n" + json.exception);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO ativos.js excluirArquivo:\r\nNão foi possível excluir o arquivo.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);
	
}


function consultarSaldosMensaisCapturados(CapturaData){

	$.ajax({
		url: app_path + "/controllers/ativos.captura.saldo.mensal.controller.php",
		data : {
			"ac" : "LISTAR_SALDOS_MENSAIS_CAPTURADOS",
			"CapturaData" : CapturaData
		},
		dataType : "html",
		success : function(form) {			
			$('#spanForm').html(form);
			$("#dialog-manut-ativo-saldos-mensais-capturados").modal('show');	
		},
		 error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO  ativo.capturasaldomensal.js consultarSaldosMensaisCapturados:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});	
}


function aplicaDataTableListadeSaldosMensais(){
	$('table#lista_saldos').dataTable({
		"oLanguage": {
			"sUrl": app_path + "/lib/DataTables/dataTables.portugues.txt",
			"sInfoThousands": "."
		},
		"sEmptyTable": "Nenhum registro encontrado.",
		"aoColumnDefs":[
			{ "sType": "date-br", "aTargets": [ 0 ] }, 				
			{ "orderable": false, "aTargets": [ 2 ] }
		],
		"sDom": '<"top">rt<"bottom"iflp><"clear">',
		 "bPaginate": false,
		"sScrollY": "450px"
	});
}

function atualizarListadeArquivos(){
		
	$.ajax({
		url: app_path + "/controllers/ativos.captura.saldo.mensal.controller.php",
		data : {
			"ac" : "LISTAR_ARQUIVOS_ATUALIZACAO",
		},
		dataType : "html",
		success : function(lista) {
			$('#spanConteudo').html(lista);			
			aplicaDataTableListadeSaldosMensais();
		},
		 error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO orcamentos.js atualizarListaAtivo:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});
	
}

