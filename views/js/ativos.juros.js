

function aplicaDataTableJuros(){
	
	$('table#lista_ativos_juros').dataTable({
		"oLanguage": {
			"sUrl": app_path + "/lib/DataTables/dataTables.portugues.txt",
			"sInfoThousands": "."
		},
		"sEmptyTable": "Nenhum registro encontrado.",
		"aoColumnDefs":[
					{ "sType": "date-br", "aTargets": [ 0 ] }, 
					{ "sType": "date-br", "aTargets": [ 1 ] }, 
					{ "sType": "money-br", "aTargets": [ 2 ] },
					{ "sType": "money-br", "aTargets": [ 3 ] },
					{ "orderable": false, "aTargets": [4] }
		],
		"sDom": '<"top">rt<"bottom"iflp><"clear">',
		"bPaginate": false,
		"sScrollY": "150px"
	});
}

function excluirJuros(JurosID) {

	AtivoID = $("#dialog-manut-ativo-juros form").find("input[name=AtivoID]").val();
		
	$.ajax(
	 	
	 	{
	 		url: app_path + "/controllers/ativos.juros.controller.php",
	 		data: {
	 			"ac": "EXCLUIR_ATIVO_JUROS",
	 			"JurosID": JurosID
	 		},
	 		dataType: "json",
	 		success: function(json) {
				if (json.resultado == true) {					
					atualizarListaJuros(AtivoID);
					success_message(json.mensagem);
				} else {
					error_message(json.mensagem);
					console.log(json.mensagem + "\r\n" + json.exception);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO ativos.js excluirJuros:\r\nNão foi possível excluir os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);

}

function salvarJuros(){

	var form = $('#dialog-manut-ativo-juros form');

	AtivoID = $(form).find("input[name=AtivoID]").val();
	maskFormUn(2,6);

	if ($(form).valid()){

	 	$.ajax({

			url: app_path + "/controllers/ativos.juros.controller.php",
			data: "ac=SALVAR_ATIVO_JUROS&" + form.serialize(),
			dataType: "json",

			success: function(dados) {

	 		if (dados.resultado == true) {       

	 					atualizarListaJuros(AtivoID);
				        $("#camposjuros").hide('slow');
				        $("#dialog-manut-ativo-juros #btn_cancelar").text("Sair");						
						$('#camposjuros input').val('');									
						$("#div_lista_ativos_juros").show();			
			 			$("#dialog-manut-ativo-juros #btn_salvar").hide();	 		
			 			success_message(dados.mensagem);

			 		} else {

			 			error_message(dados.mensagem);
			 			console.log(dados.mensagem + "\r\n"
			 					+ dados.exception);
			 		}

		 		 },

		 	  error: function(xhr, ajaxOptions, thrownError) {
		 		error_message("ERRO ativos.juros.js salvarJuros:\r\nNão foi possível carregar os dados\r\n\r\n(" +
		 		  xhr.status + " - " + thrownError + ")");
		 	  }
		 	});

	 }

	maskFormBr(2,6);

}

function atualizarListaJuros(AtivoID){
		
	$.ajax({
		url: app_path + "/controllers/ativos.juros.controller.php",
		data : {
			"ac" : "LISTAR_ATIVO_JUROS",
			"AtivoID": AtivoID
		},
		dataType : "html",
		success : function(lista) {
			$('#spanListaConteudo').html(lista);
			aplicaDataTableJuros();
		},
		 error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO  ativo.subscricoes.js editarAtivoSubscricoes:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});
}