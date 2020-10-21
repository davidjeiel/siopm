//VER 1.0

function aplicaDataTableErros(){
	
	$('table#lista_erros').dataTable({
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
		"sScrollY": "250px"
	});
}

function goErroAtivo(acao, AtivoID, AbaID, CampoID){

	if (acao == 'EDITAR_ATIVO_DADOS_GERAIS') {
		editarAtivoDadosBasicos(AtivoID);
		 $("#dialog-manut-ativo-dados-basicos .nav li").removeClass("active in");
		 $("#dialog-manut-ativo-dados-basicos .tab-pane").removeClass("active in");
		 $("#tabAtivos #" + AbaID).addClass("active in");
		 $("#navAtivos a[href='#"+ AbaID + "']").closest("li").addClass("active");
	}

	if (acao == 'EDITAR_ATIVO_ENTIDADE') {
		editarAtivoEntidade(AtivoID);
	}
	if (acao == 'arquivos') {
		editarArquivos(AtivoID);
	}	
	
	//$("#dialog-manut-ativo-finalizar").css("opacity" , 0.1);
	//$("#dialog-manut-ativo-finalizar").modal('hide');
}

function atualizarListaErrosAtivos(AtivoID){
		
	$.ajax({
		url: app_path + "/controllers/ativos.finalizar.controller.php",
		data : {
			"ac" : "LISTAR_ATIVO_ERROS",
			"AtivoID": AtivoID
		},
		dataType : "html",
		success : function(lista) {
			
			$('#spanListaConteudoErros').html(lista);
			if($('table#lista_erros tbody tr').length <= 0); {
				$("#dialog-manut-ativo-finalizar #btn_finalizar").show() ;
			} 
			aplicaDataTableErros();
			
		},
		 error: function(xhr, ajaxOptions, thrownError) {
		bootbox.alert("ERRO  ativo.fianlizar.js atualizarListaErrosAtivos:\r\nNão foi possível carregar os dados\r\n\r\n(" +
			xhr.status + " - " + thrownError + ")");
		}
	});
}

function salvarFinalizacao(){

	var form = $('#dialog-manut-ativo-finalizar form');	

	 if ($(form).valid()){

	 	$.ajax({

	 	  url: app_path + "/controllers/ativos.finalizar.controller.php",
	 	  data: "ac=SALVAR_ATIVO_FINALIZACAO&" + form.serialize(),
	 	  dataType: "json",

	 	  success: function(dados) {

	 		if (dados.resultado == true) {

	 			$("#dialog-manut-ativo-finalizar").modal('hide');
	 			atualizarListaAtivo();	 		
	 			success_message(dados.mensagem);

	 		} else {

	 			error_message(dados.mensagem);
	 			console.log(dados.mensagem + "\r\n"
	 					+ dados.exception);
	 		}

	 	  },
	 	  error: function(xhr, ajaxOptions, thrownError) {
	 		error_message("ERRO ativo.js salvarFinalizacao:\r\nNão foi possível carregar os dados\r\n\r\n(" +
	 		  xhr.status + " - " + thrownError + ")");
	 	  }
	 	});

	}// Validação de Usuário

}
