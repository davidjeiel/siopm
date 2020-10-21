
function aplicaDataTableEntidades(){
	
	$('table#lista_ativos_entidades').dataTable({
		"oLanguage": {
			"sUrl": app_path + "/lib/DataTables/dataTables.portugues.txt",
			"sInfoThousands": "."
		},
		"sEmptyTable": "Nenhum registro encontrado.",
		"aoColumnDefs":[				
					{ "orderable": false, "aTargets": [3] }
		],
		"sDom": '<"top">rt<"bottom"iflp><"clear">',
		"bPaginate": false,
		"sScrollY": "150px"
	});
}


function excluirEntidade(AtivoEntidadeID) {
	
	$.ajax(
	 	
	 	{
	 		url: app_path + "/controllers/ativos.entidades.controller.php",
	 		data: {
	 			"ac": "EXCLUIR_ATIVO_ENTIDADE",
	 			"AtivoEntidadeID": AtivoEntidadeID
	 		},
	 		dataType: "json",
	 		success: function(json) {
				if (json.resultado == true) {
					atualizarListaAtivo();
					success_message(json.mensagem);
				} else {
					error_message(json.mensagem);
					console.log(json.mensagem + "\r\n" + json.exception);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				error_message("ERRO ativos.js excluirEntidade:\r\nNão foi possível excluir os dados.");
				console.log(xhr.status + " - " + thrownError );
			}
		}
	);

}

function salvarEntidade(){

	var form = $('#dialog-manut-ativo-entidades form');
	
	if ($(form).valid()){		 
	
	 	$.ajax({

	 	  url: app_path + "/controllers/ativos.entidades.controller.php",
	 	  data: "ac=SALVAR_ATIVO_ENTIDADE&" + form.serialize(),
	 	  dataType: "json",

	 	  success: function(dados) {

	 		if (dados.resultado == true) {

	                  	atualizarListaEntidades(dados.ativoid);
					    $("#camposentidades").hide('slow');	
					    $("#dialog-manut-ativo-entidades #btn_cancelar").text("Sair");				
						$('#camposentidades option[value=""]').prop("selected", true);								
						$("#div_lista_ativos_entidades").show();											
			 			$("#dialog-manut-ativo-entidades #btn_salvar").hide();
			 			atualizarListaAtivo();
			 			if($("#dialog-manut-ativo-finalizar").is(':visible')) atualizarListaErrosAtivos(dados.ativoid);
			 			success_message(dados.mensagem);
	
	 		} else {

	 			error_message(dados.mensagem);
	 			console.log(dados.mensagem + "\r\n"
	 					+ dados.exception);
	 		}

	 	  },
	 	  error: function(xhr, ajaxOptions, thrownError) {
	 		error_message("ERRO entidades.js salvarEntidade:\r\nNão foi possível carregar os dados\r\n\r\n(" +
	 		  xhr.status + " - " + thrownError + ")");
	 	  }
	 	});

	}

}

function atualizarListaEntidades(AtivoID){
		
	$.ajax({
		url: app_path + "/controllers/ativos.entidades.controller.php",
		data : {
			"ac" : "LISTAR_ATIVO_ENTIDADES",
			"AtivoID": AtivoID
		},
		dataType : "html",
		success : function(lista) {
			$('#spanListaConteudoEntidades').html(lista);
			aplicaDataTableEntidades();
		},
		 error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO  ativo.entidades.js editarAtivoEntidade:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});
}
