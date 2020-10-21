/*
 * Escrito por Paulo Souto
 * c091636 Em 13/05/2015
 * versão 1.0
 */


$(document).ready(function() {
	aplicaDataTableListadeArquivos();
});

$(document).off("click", '.btn_importar');
$(document).on("click", '.btn_importar', function() {
	importarArquivo("");
});

$(document).off("click", '.btn_zerar');
$(document).on("click", '.btn_zerar', function() {
	zerarDadosCaptura();
});


$(document).off("click", "#lista_arquivos td a.conciliar-captura");
$(document).on("click", "#lista_arquivos td a.conciliar-captura", function() {
	var ArquivoCapturadoID  = $(this).closest("tr").data("arquivocapturadoid");
	bootbox.confirm("Tem certeza que deseja conciliar as informações do arquivo importado com os valores capturados", function(confirmou) {
		    if (confirmou) {
		      conciliarEventosCapturados(ArquivoCapturadoID);
		    }
	  });
    //alert(ArquivoCapturadoID);
    
});

$(document).off("click", "#lista_arquivos td a.detalhes");
$(document).on("click", "#lista_arquivos td a.detalhes", function() {	
     var ArquivoCapturadoID  = $(this).closest("tr").data("arquivocapturadoid");
     //alert(ArquivoCapturadoID);
     consultarEventosCapturados(ArquivoCapturadoID);
});

$(document).off("click", "#lista_arquivos td a.demonstrativo-captura");
$(document).on("click", "#lista_arquivos td a.demonstrativo-captura", function() {	
     var ArquivoCapturadoID  = $(this).closest("tr").data("arquivocapturadoid");
     //alert(ArquivoCapturadoID);
     consultarDemonstrativoCapturados(ArquivoCapturadoID);
});

$(document).off("click", "#lista_arquivos td a.excluir");
$(document).on("click", "#lista_arquivos td a.excluir", function() {	
    var ArquivoCapturadoID  = $(this).closest("tr").data("arquivocapturadoid");
	  bootbox.confirm("Tem certeza que deseja apagar o arquivo importado", function(confirmou) {
		    if (confirmou) {
		      excluirArquivo(ArquivoCapturadoID);
		    }
	  });
});

function conciliarEventosCapturados(ArquivoCapturadoID) {
	
	$.ajax(
	 	
	 	{
	 		url: app_path + "/controllers/ativos.captura.eventos.controller.php",
	 		data: {
	 			"ac": "CONCILIAR_VALORES_EVENTOS",
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
				error_message("ERRO ativos.js conciliarEventosCapturados:\r\nNão foi possível conciliar o arquivo.");
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

function zerarDadosCaptura() {
	$.ajax(
		{
			url: app_path + "/controllers/ativos.captura.eventos.controller.php",
			data: {
				"ac": "ZERAR_DADOS_CAPTURA"
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
				error_message("ERRO capturaeventos.js importarArquivo():\r\nNão foi possível carregar os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);
}

function importarArquivo() {

	$.ajax(
		{
			url: app_path + "/controllers/ativos.captura.eventos.controller.php",
			data: {
				"ac": "IMPORTAR_ARQUIVO_EVENTOS"
			},
			dataType: "html",
			success: function(form_retorno) {
				$('#spanForm').html(form_retorno);				
				$("#dialog-captura-eventos").modal('show');				
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO capturaeventos.js importarArquivo():\r\nNão foi possível carregar os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);

}

function consultarDemonstrativoCapturados(ArquivoCapturadoID){

	$.ajax({
		url: app_path + "/controllers/ativos.captura.eventos.controller.php",
		data : {
			"ac" : "LISTAR_DEMONSTRATIVO_CAPTURADOS",
			"ArquivoCapturadoID" : ArquivoCapturadoID
		},
		dataType : "html",
		success : function(form) {
			$('#spanForm').html(form);
			$("#dialog-manut-ativo-demonstrativo-capturados").modal('show');	
		},
		 error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO  capturaeventos.js consultarDemonstrativoCapturados:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});	
}

function consultarEventosCapturados(ArquivoCapturadoID){

	$.ajax({
		url: app_path + "/controllers/ativos.captura.eventos.controller.php",
		data : {
			"ac" : "LISTAR_EVENTOS_CAPTURADOS",
			"ArquivoCapturadoID" : ArquivoCapturadoID
		},
		dataType : "html",
		success : function(form) {
			$('#spanForm').html(form);
			$("#dialog-manut-ativo-eventos-capturados").modal('show');	
		},
		 error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO  capturaeventos.js consultarEventosCapturados:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});	
}



function aplicaDataTableListadeArquivos(){
	$('table#lista_arquivos').dataTable({
		"oLanguage": {
			"sUrl": app_path + "/lib/DataTables/dataTables.portugues.txt",
			"sInfoThousands": "."
		},
		"sEmptyTable": "Nenhum registro encontrado.",
		"order": [[ 0, 'desc' ], [ 4, 'asc' ]],
		"aoColumnDefs":[
			{ "sType": "date-br", "aTargets": [ 0 ] }, 
			{ "sType": "date-br", "aTargets": [ 3 ] }, 
			{ "sType": "date-br", "aTargets": [ 4 ] }, 			
			{ "orderable": false, "aTargets": [ 6 ] }
		],
		"sDom": '<"top">rt<"bottom"iflp><"clear">',
		 "bPaginate": false,
		"sScrollY": "450px"
	});
}

function atualizarListadeArquivos(){
		
	$.ajax({
		url: app_path + "/controllers/ativos.captura.eventos.controller.php",
		data : {
			"ac" : "LISTAR_ARQUIVOS_ATUALIZACAO",
		},
		dataType : "html",
		success : function(lista) {
			$('#spanConteudo').html(lista);			
			aplicaDataTableListadeArquivos();
		},
		 error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO orcamentos.js atualizarListaAtivo:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});
	
}

